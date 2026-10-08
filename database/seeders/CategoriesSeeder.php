<?php

namespace Database\Seeders;

use App\Modules\Product\Models\ProductCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();
        $fakerJp = Factory::create('ja_JP');
        $fakerDe = Factory::create('de_DE');
        $fakerEs = Factory::create('es_ES');
        $fakerPt = Factory::create('pt_PT');
        $fakerRu = Factory::create('ru_RU');
        $fakerIt = Factory::create('it_IT');

        $file = Storage::disk('disk');
        $images = $file->allFiles('public/product-demos');

        for ($i = 0; $i <= 14; $i++) {
            if ($i % 2 === 0) {
                $attribute = 1;
            } else {
                $attribute = 0;
            }
            $enName = $faker->realText(30);
            $categoriesData = [
                'parent_id' => 0,
                'sort' => 0,
                'is_show' => $attribute,
                'is_menu' => $attribute,
                'path' => $this->getImagePath($images[array_rand($images)]),
                'url_key' => Str::slug($enName),
                'en' => [
                    'name' => $enName,
                    'content' => $faker->realText(300),
                    'title' => $faker->realText(30),
                    'keywords' => $faker->realText(30),
                    'description' => $faker->realText(300)
                ],
                'ja' => [
                    'name' => $fakerJp->realText(30),
                    'content' => $fakerJp->realText(300),
                    'title' => $fakerJp->realText(30),
                    'keywords' => $fakerJp->realText(30),
                    'description' => $fakerJp->realText(300)
                ],
                'de' => [
                    'name' => $fakerDe->realText(30),
                    'content' => $fakerDe->realText(300),
                    'title' => $fakerDe->realText(30),
                    'keywords' => $fakerDe->realText(30),
                    'description' => $fakerDe->realText(300)
                ],
                'es' => [
                    'name' => $fakerEs->realText(30),
                    'content' => $fakerEs->realText(300),
                    'title' => $fakerEs->realText(30),
                    'keywords' => $fakerEs->realText(30),
                    'description' => $fakerEs->realText(300)
                ],
                'pt' => [
                    'name' => $fakerPt->realText(30),
                    'content' => $fakerPt->realText(300),
                    'title' => $fakerPt->realText(30),
                    'keywords' => $fakerPt->realText(30),
                    'description' => $fakerPt->realText(300)
                ],
                'ru' => [
                    'name' => $fakerRu->realText(30),
                    'content' => $fakerRu->realText(300),
                    'title' => $fakerRu->realText(30),
                    'keywords' => $fakerRu->realText(30),
                    'description' => $fakerRu->realText(300)
                ],
                'it' => [
                    'name' => $fakerIt->realText(30),
                    'content' => $fakerIt->realText(300),
                    'title' => $fakerIt->realText(30),
                    'keywords' => $fakerIt->realText(30),
                    'description' => $fakerIt->realText(300)
                ],
            ];
            $productCategory = ProductCategory::create($categoriesData);
            $rand = random_int(0, 5);
            for ($j = 0; $j < $rand; $j++) {
                $enName = $faker->realText(30);
                $childrenData = [
                    'parent_id' => $productCategory->id,
                    'sort' => 0,
                    'is_show' => $attribute,
                    'is_menu' => $attribute,
                    'path' => $this->getImagePath($images[array_rand($images)]),
                    'url_key' => Str::slug($enName),
                    'en' => [
                        'name' => $enName,
                        'content' => $faker->realText(300),
                        'title' => $faker->realText(30),
                        'keywords' => $faker->realText(30),
                        'description' => $faker->realText(300)
                    ],
                    'ja' => [
                        'name' => $fakerJp->realText(30),
                        'content' => $fakerJp->realText(300),
                        'title' => $fakerJp->realText(30),
                        'keywords' => $fakerJp->realText(30),
                        'description' => $fakerJp->realText(300)
                    ],
                    'de' => [
                        'name' => $fakerDe->realText(30),
                        'content' => $fakerDe->realText(300),
                        'title' => $fakerDe->realText(30),
                        'keywords' => $fakerDe->realText(30),
                        'description' => $fakerDe->realText(300)
                    ],
                    'es' => [
                        'name' => $fakerEs->realText(30),
                        'content' => $fakerEs->realText(300),
                        'title' => $fakerEs->realText(30),
                        'keywords' => $fakerEs->realText(30),
                        'description' => $fakerEs->realText(300)
                    ],
                    'pt' => [
                        'name' => $fakerPt->realText(30),
                        'content' => $fakerPt->realText(300),
                        'title' => $fakerPt->realText(30),
                        'keywords' => $fakerPt->realText(30),
                        'description' => $fakerPt->realText(300)
                    ],
                    'ru' => [
                        'name' => $fakerRu->realText(30),
                        'content' => $fakerRu->realText(300),
                        'title' => $fakerRu->realText(30),
                        'keywords' => $fakerRu->realText(30),
                        'description' => $fakerRu->realText(300)
                    ],
                    'it' => [
                        'name' => $fakerIt->realText(30),
                        'content' => $fakerIt->realText(300),
                        'title' => $fakerIt->realText(30),
                        'keywords' => $fakerIt->realText(30),
                        'description' => $fakerIt->realText(300)
                    ],
                ];
                ProductCategory::create($childrenData);
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
