<?php
namespace App\Modules\Product\Controllers;

use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductAttribute;
use App\Modules\Product\Models\ProductAttributeCategory;
use App\Modules\Product\Models\ProductAttributeValue;
use App\Modules\Product\Models\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductAttributeController extends BaseController
{

    /**
     * ProductBrandController constructor.
     * @param ProductBrand $productAttribute
     * @param Request $request
     */

    public function __construct(ProductAttribute $productAttribute)
    {
        $this->modelName = 'ProductAttribute';
        $this->model = $productAttribute->with(['translations']);
        $this->modelSource =  $productAttribute;
        $this->viewPath = 'Product.Views.attribute';
        $this->orderBy = 'sort';
        $this->validatorData = [
            'sort' => 'required|numeric',
            'translate.'.config('app.locale').'.name' => 'required'
        ];
    }

    public function index()
    {
        $request = \request();
        $categories = ProductAttributeCategory::all();
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(ProductAttribute::orderByDesc($this->orderBy),function ($query)use($request){
                if ($name = $request->get('name')) {
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
            });
            if ($category_id = $request->get('category_id')){
                $data->whereHas('categories',function($query)use($category_id){
                    $query->where(['product_attribute_category_id'=>$category_id]);
                });
            }
            $data =  $data->paginate($request->input('limit', 15));
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);
            }
        }
        return view($this->viewPath . '.index',compact('categories'));
    }



    public function update($id, Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData,$this->validatorMessages);
        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $model = $this->model->find($id);
        $translate = $request->get('translate');
        is_array($translate) ? $update = array_merge($translate, $request->all()) : $update = $request->all();
        try {
            $model->update($update);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }



    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData);

        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $translate = $request->get('translate');
        is_array($translate) ? $add = array_merge($translate, $request->all()) : $add = $request->all();
        try {
            if (empty($request->get('url_key')) && isset($add[config('app.locale')]['name'])) $add['url_key'] = Str::slug($add[config('app.locale')]['name'],'-',config('app.locale'));
            $add['admin_user_id'] = \auth()->id();
            $this->model->create($add);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }



    public function bindValues($id, Request $request)
    {
        $user = auth()->user();
        $allowed = $user
            && (
                $user->hasRole('超级管理员')
                || $user->can('admin.product.getAttribute')
                || $user->can('admin.product.update')
                || $user->can('admin.product.store')
                || $user->can('admin.product.edit')
                || $user->can('admin.product.create')
                || $user->can('admin.product.attribute.update')
            );
        if (!$allowed) {
            return $this->badRequest(__('没有操作权限'));
        }

        $attribute = ProductAttribute::query()->find($id);
        if (!$attribute) {
            return $this->badRequest(__('属性不存在'));
        }

        $incoming = $this->parseBindValues((string)$request->input('values', ''));
        if (empty($incoming)) {
            return $this->badRequest(__('请输入属性值'));
        }

        $existing = array_values(array_filter(array_map('trim', explode(',', (string)($attribute->options ?? '')))));
        $existingMap = [];
        foreach ($existing as $opt) {
            $existingMap[mb_strtolower($opt)] = $opt;
        }

        $created = [];
        $resolved = [];
        foreach ($incoming as $value) {
            $key = mb_strtolower($value);
            if (isset($existingMap[$key])) {
                $resolved[] = $existingMap[$key];
                continue;
            }
            $existing[] = $value;
            $existingMap[$key] = $value;
            $created[] = $value;
            $resolved[] = $value;
        }

        if (!empty($created)) {
            try {
                $attribute->options = implode(',', $existing);
                $attribute->save();
            } catch (\PDOException $exception) {
                Log::error($this->modelName . ':bindValues，错误原因为：' . $exception->getMessage());
                return $this->badRequest();
            }
        }

        return $this->data([
            'options' => $existing,
            'created' => $created,
            'values' => $resolved,
        ]);
    }

    private function parseBindValues(string $raw): array
    {
        $parts = preg_split('/[,，]+/u', $raw) ?: [];
        $unique = [];
        foreach ($parts as $part) {
            $value = trim((string)$part);
            if ($value === '') {
                continue;
            }
            $key = mb_strtolower($value);
            if (!isset($unique[$key])) {
                $unique[$key] = $value;
            }
        }
        return array_values($unique);
    }

    public function destroy($id)
    {
        $model = $this->model->find($id);
//        $join_ids = array_column(ProductAttributeValue::query()->select(['product_id'])->where('product_attribute_id',$id)->groupBy('product_id')->get()->toArray(),'product_id');
//        if ($join_ids){
//            $joins =array_column(Product::query()->select(['id'])->with(['translations'])->whereIn('id',$join_ids)->get()->toArray(),'name');
//
//            return $this->badRequest('该属性已关联以下产品:'.implode(',',$joins));
//        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        try {
            $model->delete();
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }


}
