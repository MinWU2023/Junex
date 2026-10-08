<?php

namespace App\Modules\Product\Controllers;

use App\Modules\Admin\Models\AdminLog;
use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Rules\UrlKeyRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class CategoryController
 * @package App\Modules\Category\Controllers
 */
class ProductCategoryController extends BaseController
{
    protected $orderBy = 'sort';

    public function __construct(ProductCategory $productCategory)
    {
        $this->modelName = 'ProductCategory';
        $this->model = $productCategory;
        $this->modelSource =  $productCategory;
        $this->viewPath = 'Product.Views.category';
        $this->validatorData = [
            'sort' => 'required|numeric',
            'translate.' . config('app.locale') . '.name' => 'required'
        ];
    }

    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap($this->model->with(['translations:name,product_category_id,locale']), function ($query) use ($request) {
                if ($name = $request->get('name')) {
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
            })->orderByDesc($this->orderBy)->paginate($request->input('limit',10000));
            $this->sanitizeSelfParentRows($data);
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);

            }
        }
        return view($this->viewPath . '.index', compact('name'));
    }

    public function store(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData, $this->validatorMessages);

        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $translate = $request->get('translate');
        is_array($translate) ? $add = array_merge($translate, $request->all()) : $add = $request->all();
        try {
            $locale = config('translatable.fallback_locale') ?: config('app.locale');
            $name = (string)($add[$locale]['name'] ?? $add[config('app.locale')]['name'] ?? '');
            $add['url_key'] = $this->resolveCategoryUrlKey($request->get('url_key'), $name, true);
            $add['admin_user_id'] = \auth()->id();
            $category = $this->model->create($add);
            // Ensure urls row matches url_key (dedupe conflicts)
            $category->refresh();
            $category->syncUrlRecord();
            $category->load('url');
            AdminLog::log([
                'name' => date('Y-m-d H:i:s').' 用户'.$request->user()->email.'新增产品分类('.$category->id.')'.$category->name,
                'modelName'=> $this->modelName,
                'content' => json_encode($request->all())
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':store，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }

        return $this->success();
    }

    public function update($id, Request $request)
    {
        $model = $this->model->findOrFail($id);

        $locale = config('translatable.fallback_locale') ?: config('app.locale');
        $translate = $request->get('translate');
        is_array($translate) ? $update = array_merge($translate, $request->all()) : $update = $request->all();
        $name = (string)($update[$locale]['name'] ?? $update[config('app.locale')]['name'] ?? $model->name ?? '');
        $update['url_key'] = $this->resolveCategoryUrlKey(
            $request->get('url_key', $model->url_key),
            $name,
            false
        );

        $this->validatorData['url_key'] = [
            'required',
            new UrlKeyRule($id, ProductCategory::class),
        ];
        $validator = $this->getValidationFactory()->make(
            array_merge($request->all(), ['url_key' => $update['url_key']]),
            $this->validatorData,
            $this->validatorMessages
        );
        if (!$validator->passes()) {
            return response()->json([
                'code' => 422,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (isset($update['parent_id']) && (int) $update['parent_id'] === (int) $id) {
            return response()->json([
                'code' => 422,
                'errors' => ['parent_id' => [__('上级分类不能选择自己')]],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $model->update($update);
            $model->refresh();
            $model->syncUrlRecord();
            $model->load('url');
            AdminLog::log([
                'name' => date('Y-m-d H:i:s').' 用户'.$request->user()->email.'编辑产品分类('.$model->id.')'.$model->name,
                'modelName'=> $this->modelName,
                'content' => json_encode($request->all())
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':update:更新失败，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }

    /**
     * Create: always slug from name (no category/ prefix).
     * Edit: use submitted url_key (normalized).
     */
    protected function resolveCategoryUrlKey($raw, string $name, bool $isCreate): string
    {
        if ($isCreate) {
            $key = Str::slug(trim($name), '-', 'en');
            if ($key === '') {
                $key = 'category-' . time();
            }
            return $key;
        }

        $key = trim((string)$raw);
        $key = str_replace('\\', '/', $key);
        $key = trim($key, '/');
        // Strip legacy prefix if pasted by mistake
        $key = preg_replace('#^(category|product-category|product_category)/#i', '', $key);
        $key = trim((string)$key, '/');

        if ($key === '') {
            $key = Str::slug(trim($name), '-', 'en');
        } else {
            if (str_contains($key, '/')) {
                $parts = array_values(array_filter(explode('/', $key), fn ($p) => $p !== ''));
                $key = implode('-', $parts);
            }
            $key = Str::slug($key, '-', 'en');
        }

        if ($key === '') {
            $key = 'category-' . time();
        }

        return $key;
    }


    public function changeProperty($id, Request $request)
    {
        $model = $this->model->find($id);
        switch ($request->type) {
            case 'category_show':
                $model->is_show = !$model->is_show;
                break;
            case 'category_menu':
                $model->is_menu = !$model->is_menu;
                break;
            case 'category_sort':
                $model->sort = intval($request->get('sort'));
                break;
        }
        $model->save();
        return $this->success();
    }


    private static function getChildrenProduct($id,&$product_ids){
        $product_ids = array_merge(DB::table('product_product_category')->where('product_category_id',$id)->pluck('product_id')->toArray(),$product_ids); //当前分类底下产品
        $children_category_ids = DB::table('product_categories')->where('parent_id',$id)->select(['id'])->pluck('id')->toArray(); //获取二级分类和对应子产品
        if (isset($children_category_ids[0])){
            foreach ($children_category_ids as $children_category_id){
                self::getChildrenProduct($children_category_id,$product_ids);
            }
        }

    }

    public function destroy($id)
    {
        $model = $this->model->with(['children'])->find($id);
        if ($model->children()->count()) {
            return $this->badRequest('无法删除此分类！原因：此分类下存在有子分类。');
        }

        $product_ids = [];
        self::getChildrenProduct($id,$product_ids);
        $count = Product::active()->whereIn('id',$product_ids)->count();
        if ($count){
            return $this->badRequest('无法删除此分类！原因：分类下存在商品。');
        }
        try {
            $model->delete();
            AdminLog::log([
                'name' => date('Y-m-d H:i:s').' 用户'.\request()->user()->email.'删除产品分类('.$model->id.')'.$model->name,
                'modelName'=> $this->modelName,
            ]);
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest('无法删除此分类！原因：分类下存在商品。');
        }
        return $this->success();
    }


    public function getAllCategories($id)
    {
        $currentSelectIds= [];
        $checkedData = [];
        $selectCategory = [];
        if ($id) {
            $checkedCategories = Product::where('id', $id)->with('productCategory')->first();
            if ($checkedCategories->productCategory) {
                $checkedData = array_values(array_unique($checkedCategories->productCategory->pluck('name')->toArray()));
//                $checkedData = $checkedCategories->productCategory->pluck('name');
                $currentSelectIds = $checkedCategories->productCategory->pluck('id');
                $selectCategory = $checkedCategories->productCategory->pluck('name','id');
            }
        }
        $categories = ProductCategory::where('parent_id', 0)->with(['translations', 'children' => function ($query) {
            $query->with(['children' => function ($qu) {
                $qu->with(['translations']);
            }, 'translations']);
        }])->get();
        $data = [];
        foreach ($categories as $k => $category) {
            $data[$k] = [
                'label' => strtolower($category->name),
                'id'  => $category->id
            ];
            self::recursion_category($category, $data[$k]);
        }
        $selectCategoryData = [];
        foreach ($selectCategory as $k => $value) {
            $selectCategoryData[] = [
                'id' => $k,
                'name' => strtolower($value)
            ];
        }
        if (app('settings')['setting']['tree_strictly']){
            $bool = false;
        }else{
            $bool = true;
        }
        return json_encode([
            'categories' => $data,
            'currentSelect' => $checkedData,
            'currentSelectIds' =>$currentSelectIds,
            'selectCategory' => $selectCategoryData,
            'tree_strictly' => $bool,
        ]);
    }

    public static function recursion_category($category, &$data)
    {
        if ($category->children) {
            foreach ($category->children as $k => $children) {
                $data['children'][$k] = [
                    'label' => $children->name,
                    'id' => $children->id
                ];
                if (isset($children->children[0])){
                    self::recursion_category($children,$data['children'][$k]);
                }
            }
        }
    }

}
