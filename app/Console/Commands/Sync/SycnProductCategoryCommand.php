<?php

namespace App\Console\Commands\Sync;

use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use Illuminate\Console\Command;

class SycnProductCategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:product-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新产品和分类关联';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private static function getParentCategory($category_id,&$category_ids){
        $parent_category =  ProductCategory::query()->find($category_id);
        if ($parent_category->parent_id){
            $category_ids[] = $parent_category->parent_id;
            self::getParentCategory($parent_category->parent_id,$category_ids);
        }
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = Product::query()->with(['productCategory'])->get();
        foreach ($products as $product){
            $category_ids = $product->productCategory->pluck('id')->toArray();
            foreach ($category_ids as $category_id){
                self::getParentCategory($category_id,$category_ids);
            }
            $product->productCategory()->sync($category_ids);
        }
    }

}
