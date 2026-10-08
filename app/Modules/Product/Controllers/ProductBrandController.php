<?php
namespace App\Modules\Product\Controllers;

use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Modules\Product\Models\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductBrandController extends BaseController
{

    protected $orderBy = 'sort';
    /**
     * ProductBrandController constructor.
     * @param ProductBrand $productBrand
     * @param Request $request
     */

    public function __construct(ProductBrand $productBrand)
    {
        $this->modelName = 'ProductBrand';
        $this->model = $productBrand;
        $this->viewPath = 'Product.Views.brand';
        $this->validatorData = [
            'sort' => 'required|numeric',
            'name' => 'required'
        ];
    }



    public function destroy($id)
    {
        $model = $this->model->find($id);
        try {
            $model->delete();
        } catch (\PDOException $exception) {
            Log::error($this->modelName . ':destroy，错误原因为：' . $exception->getMessage());
            return $this->badRequest('无法删除此分类！原因：分类下存在商品。');
        }
        return $this->success();
    }
}
