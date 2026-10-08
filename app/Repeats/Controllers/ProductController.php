<?php

namespace App\Repeats\Controllers;

use App\Repeats\Models\Product;

class ProductController extends \App\Modules\Product\Controllers\ProductController
{

    public function __construct(Product $product)
    {
        parent::__construct($product);
        $this->model = $product->with(['translations']);
        $this->viewPath = 'Repeats::product';
    }

    //对应repeat.php路由解开注释即访问到该控制器： 重写参考 App\Repeats\Controllers\ArticleController
}
