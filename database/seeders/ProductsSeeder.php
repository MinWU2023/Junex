<?php

namespace Database\Seeders;

use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductAttribute;
use App\Modules\Product\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Faker\Factory;

class ProductsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = Storage::disk('disk');
        $images = $file->allFiles('public/product-demos');
        $faker = Factory::create();
        $fakerJp = Factory::create('ja_JP');
        $fakerDe = Factory::create('de_DE');
        $fakerEs = Factory::create('es_ES');
        $fakerPt = Factory::create('pt_PT');
        $fakerRu = Factory::create('ru_RU');
        $fakerIt = Factory::create('it_IT');
        $productCategories = ProductCategory::get();
        $names = collect($productCategories)->map(function($q){
            return $q->name;
        })->toArray();

        $productAttributes = collect(ProductAttribute::get())->map(function ($q){
            return $q->mark;
        })->toArray();

        foreach ($productCategories as $key => $productCategory) {
            $rand = random_int(0, 10);

            for ($j = 0; $j < $rand; $j++) {
                if ($key % 10 === 0 && $j === 0) {
                    $attribute = 1;
                } else {
                    $attribute = 0;
                }
                while (true) {
                    $enName = $faker->realText(30);
                    if (!in_array($enName, $names)) {
                        array_push($names, $enName);
                        break;
                    }
                }
                foreach ($productAttributes as $productAttribute) {
                    $attributesEn[$productAttribute] = $faker->realText(30);
                    $attributesJp[$productAttribute] = $fakerJp->realText(30);
                    $attributesDe[$productAttribute] = $fakerDe->realText(30);
                    $attributesEs[$productAttribute] = $fakerEs->realText(30);
                    $attributesPt[$productAttribute] = $fakerPt->realText(30);
                    $attributesRu[$productAttribute] = $fakerRu->realText(30);
                    $attributesIt[$productAttribute] = $fakerIt->realText(30);
                }
                $productData = [
                    'admin_user_id' => 1,
                    'product_brand_id' => random_int(1,66),
                    'sort' => 0,
                    'url_key' => Str::slug($enName),
                    'active' => 1,
                    'is_new' => $attribute,
                    'is_hot' => $attribute,
                    'is_recommend' => $attribute,
                    'add_date' => date('Ym'),
                    'en' => [
                        'name' => $enName,
                        'brief_content' => $faker->realText(60),
                        'content' => $faker->realText(600),
                        'title' => $faker->realText(30),
                        'keywords' => $faker->realText(30),
                        'description' => $faker->realText(60),
                        'attribute' => json_encode($attributesEn)
                    ],
                    'ja' => [
                        'name' => $fakerJp->realText(30),
                        'brief_content' => $fakerJp->realText(60),
                        'content' => $fakerJp->realText(600),
                        'title' => $fakerJp->realText(30),
                        'keywords' => $fakerJp->realText(30),
                        'description' => $fakerJp->realText(60),
                        'attribute' => json_encode($attributesJp)
                    ],
                    'de' => [
                        'name' => $fakerDe->realText(30),
                        'brief_content' => $fakerDe->realText(60),
                        'content' => $fakerDe->realText(600),
                        'title' => $fakerDe->realText(30),
                        'keywords' => $fakerDe->realText(30),
                        'description' => $fakerDe->realText(60),
                        'attribute' => json_encode($attributesDe)
                    ],
                    'es' => [
                        'name' => $fakerEs->realText(30),
                        'brief_content' => $fakerEs->realText(60),
                        'content' => $fakerEs->realText(600),
                        'title' => $fakerEs->realText(30),
                        'keywords' => $fakerEs->realText(30),
                        'description' => $fakerEs->realText(60),
                        'attribute' => json_encode($attributesEs)
                    ],
                    'pt' => [
                        'name' => $fakerPt->realText(30),
                        'brief_content' => $fakerPt->realText(60),
                        'content' => $fakerPt->realText(600),
                        'title' => $fakerPt->realText(30),
                        'keywords' => $fakerPt->realText(30),
                        'description' => $fakerPt->realText(60),
                        'attribute' => json_encode($attributesPt)
                    ],
                    'ru' => [
                        'name' => $fakerRu->realText(30),
                        'brief_content' => $fakerRu->realText(60),
                        'content' => $fakerRu->realText(600),
                        'title' => $fakerRu->realText(30),
                        'keywords' => $fakerRu->realText(30),
                        'description' => $fakerRu->realText(60),
                        'attribute' => json_encode($attributesRu)
                    ],
                    'it' => [
                        'name' => $fakerIt->realText(30),
                        'brief_content' => $fakerIt->realText(60),
                        'content' => $fakerIt->realText(600),
                        'title' => $fakerIt->realText(30),
                        'keywords' => $fakerIt->realText(30),
                        'description' => $fakerIt->realText(60),
                        'attribute' => json_encode($attributesIt)
                    ],

                ];
                $product = Product::create($productData);
                $product->productCategory()->sync($productCategory->id);
                $path = $this->getImagePath($images[array_rand($images)]);
                $path1 = $this->getImagePath($images[array_rand($images)]);
                $add = [
                    [
                        'product_id' => $product->id,
                        'path' => $path,
                        'is_main' => 1,
                        'alt' => '',
                        'sort' => 1,
                        'created_at' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d'),
                    ],
                    [
                        'product_id' => $product->id,
                        'path' => $path1,
                        'is_main' => 0,
                        'alt' => '',
                        'sort' => 1,
                        'created_at' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d'),
                    ]
                ];
                DB::table('product_images')->insert($add);
            }
        }
    }

    private function getImagePath($path)
    {
        $path = str_replace('public/', '', $path);
        $path = str_replace('--_100', '', $path);
        $path = str_replace('--_250', '', $path);
        return $path;
    }
}
