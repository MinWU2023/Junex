<?php

namespace App\Console\Commands\Init;

use Database\Seeders\ArticleSeeder;
use Database\Seeders\AttributeSeeder;
use Database\Seeders\BrandsSeeder;
use Database\Seeders\CategoriesSeeder;
use Database\Seeders\InquirySeeder;
use Database\Seeders\PageSeeder;
use Database\Seeders\ProductsSeeder;
use Database\Seeders\TagSeeder;
use Illuminate\Console\Command;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testData:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'init testData';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_images')->truncate();
        DB::table('urls')->truncate();
        DB::table('product_translations')->truncate();
        DB::table('products')->truncate();
        DB::table('product_category_translations')->truncate();
        DB::table('product_categories')->truncate();
        DB::table('product_brands')->truncate();
        DB::table('product_attr_translations')->truncate();
        DB::table('product_tag_translations')->truncate();
        DB::table('product_tags')->truncate();
        DB::table('product_attributes')->truncate();
        DB::table('page_translations')->truncate();
        DB::table('pages')->truncate();
        DB::table('article_translations')->truncate();
        DB::table('articles')->truncate();
        DB::table('article_category_translations')->truncate();
        DB::table('article_categories')->truncate();
        DB::table('inquiries')->truncate();
        $seeder = new class() extends Seeder {
        };
        $seeder->call(CategoriesSeeder::class);
        $seeder->call(BrandsSeeder::class);
        $seeder->call(AttributeSeeder::class);
        $seeder->call(ProductsSeeder::class);
        $seeder->call(PageSeeder::class);
        $seeder->call(TagSeeder::class);
        $seeder->call(ArticleSeeder::class);
        $seeder->call(InquirySeeder::class);
        $this->info('测试数据已生成');
    }
}
