<?php


namespace App\Modules\Product\Controllers;


use App\Modules\AddonsMarket\Models\Addon;
use App\Modules\Common\Collections\CommonCollection;
use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Product\Collections\TagProductsCollection;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductTag;
use App\Modules\Setting\Models\Locale;
use App\Modules\Url\Models\Url;
use App\Rules\UrlKeyRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;


class ProductTagController extends BaseController
{

    protected $orderBy = 'sort';

    /**
     * ProductBrandController constructor.
     * @param ProductTag $productTag
     * @param Request $request
     */

    public function __construct(ProductTag $productTag)
    {
        $this->modelName = 'ProductTag';
        $this->modelSource =  $productTag;
        $this->model = $productTag;
        $this->viewPath = 'Product.Views.tag';
        $this->validatorData = [
            'sort' => 'required|numeric',
            'translate.' . config('app.locale') . '.name' => 'required'
        ];
    }

    public function update($id, Request $request)
    {
        if ($request->post('url_key')) {
            $this->validatorData['url_key'] = [
                'required',
                new UrlKeyRule($id, ProductTag::class),
            ];
        }
        $validator = $this->getValidationFactory()->make($request->all(), $this->validatorData, $this->validatorMessages);
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


    public function show($id)
    {
        $request = \request();
        if ($request->ajax() || $request->wantsJson()) {
            $data = ProductTag::with(['products' => function ($query) {
                $query->active();
            }])->find($id);
            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                $result = Product::active()->whereHas('productTags', function ($query) use ($id) {
                    $query->where('product_tag_id', $id);
                })->paginate($request->input('limit', 15));
                foreach ($result as $key => $value) {
                    $result[$key]['tag_id'] = $data->id;
                    $result[$key]['tag_name'] = $data->name;
                }
                return new TagProductsCollection($result);
            }
        }
        return view($this->viewPath . '.show', compact('id'));
    }

    public function index()
    {
        $request = \request();
        $name = $request->get('name');
        if ($request->ajax() || $request->wantsJson()) {
            $data = tap(ProductTag::with(['translations:name,product_tag_id,locale']), function ($query) use ($request) {
                if ($name = $request->post('name')) {
                    $query->whereTranslationLike('name', '%' . $name . '%');
                }
                if ($is_hot = $request->get('is_hot')) {
                    $query->where('is_hot', $is_hot);
                }
            })->orderByDesc($this->orderBy)->paginate($request->input('limit', 15));

            if ($collection = $this->collection) {
                return new $collection($data);
            } else {
                return new CommonResourceCollection($data);
            }
        }
        $locales = Locale::get();
        return view($this->viewPath . '.index', compact('locales', 'name'));
    }


    public function destroy($id)
    {
        $model = $this->model->with(['products'])->find($id);
        if (Schema::hasTable('product_tag_ranks')) {
            DB::table('product_tag_ranks')->where(['product_tag_id' => $id])->delete();
        }
        try {
            $model->products()->detach();
            $model->delete();

            Url::withTrashed()->where([
                'urlable_type' => 'App\Modules\Product\Models\ProductTag',
                'urlable_id' => $model->id
            ])->forceDelete();
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest();
        }
        return $this->success();
    }


    /**
     * 清除未关联产品关键词
     */
    public function removes()
    {
        ini_set('memory_limit', '1024M');
        $tags = ProductTag::with(['products' => function ($query) {
            $query->where('is_temp', 0);
        }])->get();
        foreach ($tags as $tag) {
            if (!isset($tag->products[0])) {
                $tag_name = $tag->name;
                if (Schema::hasTable('product_tag_ranks')) {
                    DB::table('product_tag_ranks')->where(['product_tag_id' => $tag->id])->delete();
                }
                DB::table('product_product_tag')->where('product_tag_id', $tag->id)->delete();
                $tag->delete();

                Url::withTrashed()->where([
                    'urlable_type' => 'App\Modules\Product\Models\ProductTag',
                    'urlable_id' => $tag->id
                ])->forceDelete();
                if (Schema::hasTable('keywords')) {
                    DB::table('keywords')->where('name', $tag_name)->delete();
                }
            }
        }
        return $this->success();
    }

    public function detachTag(Request $request)
    {
        $product = Product::query()->find($request->get('product'));
        if ($product) {
            $product->productTags()->detach($request->get('tag'));
        }
        return $this->success();
    }

    public function allProductTags()
    {
        $productTags = ProductTag::with(['translations'])->get();
        $active = Addon::query()->where(['sign' => 'Adwords', 'status' => 1])->first();
        return ['data' => collect($productTags)->map(function ($map) {
            return [
                'value' => $map->id,
                'label' => $map->name
            ];
        }), 'active' => $active ? 1 : 0];
    }

    public function changeProperty($id, Request $request)
    {
        $model = $this->model->find($id);
        switch ($request->type) {
            case 'edit_hot':
                $model->is_hot = !$model->is_hot;
                break;
        }
        $model->save();
        return $this->success();
    }


    public function export(Request $request)
    {
        $ids = $request->post('ids');
        $locale = $request->post('locale');
        $data = [
            [
                'id',
                'tag名',
            ],
        ];
        if ($ids) {
            $tags = ProductTag::whereIn('id', $ids)->get();
        } else {
            $tags = ProductTag::get();
        }
        foreach ($tags as $tag) {
            if (isset($tag->translate($locale)->name)) {
                $tag_name = $tag->translate($locale)->name;
            } else {
                $tag_name = $tag->name;
            }
            $data[] = [
                $tag->id,
                $tag_name
            ];
        }
        return new CommonCollection($data);
    }
}
