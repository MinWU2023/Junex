<?php

namespace Database\Seeders;

use App\Modules\Article\Models\Article;
use App\Modules\Article\Models\ArticleCategory;
use App\Modules\Product\Models\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
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
        $products = Product::get();
        $names = collect($products)->map(function ($q) {
            return $q->name;
        })->toArray();
        for ($i = 0; $i <= 3; $i++) {
            while (true) {
                $enName = $faker->realText(20);
                if (!in_array($enName, $names)) {
                    array_push($names, $enName);
                    break;
                }
            }
            $add = [
                'url_key' => Str::slug($enName),
                'sort' => 0,
                'parent_id' => 0,
                'path' => $this->getImagePath($images[array_rand($images)]),
                'en' => [
                    'name' => $enName,
                ],
                'ja' => [
                    'name' => $fakerJp->realText(20),
                ],
                'de' => [
                    'name' => $fakerDe->realText(20),
                ],
                'es' => [
                    'name' => $fakerEs->realText(20),
                ],
                'pt' => [
                    'name' => $fakerPt->realText(20),
                ],
                'ru' => [
                    'name' => $fakerRu->realText(20),
                ],
                'it' => [
                    'name' => $fakerIt->realText(20),
                ],
            ];
            $articleCategory = ArticleCategory::create($add);
            for ($j = 0; $j <= random_int(3, 6); $j++) {
                while (true) {
                    $enName = $faker->realText(25);
                    if (!in_array($enName, $names)) {
                        array_push($names, $enName);
                        break;
                    }
                }
                $add = [
                    'url_key' => Str::slug($enName),
                    'sort' => 0,
                    'is_show' => 0,
                    'is_menu' => 0,
                    'active' => 1,
                    'article_category_id' => $articleCategory->id,
                    'path' => $this->getImagePath($images[array_rand($images)]),
                    'en' => [
                        'name' => $enName,
                        'content' => $faker->realText(6000),
                        'title' => $faker->realText(30),
                        'keywords' => $faker->realText(30),
                        'description' => $faker->realText(60)
                    ],
                    'ja' => [
                        'name' => $fakerJp->realText(30),
                        'content' => $fakerJp->realText(6000),
                        'title' => $fakerJp->realText(30),
                        'keywords' => $fakerJp->realText(30),
                        'description' => $fakerJp->realText(60)
                    ],
                    'de' => [
                        'name' => $fakerDe->realText(30),
                        'content' => $fakerDe->realText(6000),
                        'title' => $fakerDe->realText(30),
                        'keywords' => $fakerDe->realText(30),
                        'description' => $fakerDe->realText(60)
                    ],
                    'es' => [
                        'name' => $fakerEs->realText(30),
                        'content' => $fakerEs->realText(6000),
                        'title' => $fakerEs->realText(30),
                        'keywords' => $fakerEs->realText(30),
                        'description' => $fakerEs->realText(60)
                    ],
                    'pt' => [
                        'name' => $fakerPt->realText(30),
                        'content' => $fakerPt->realText(6000),
                        'title' => $fakerPt->realText(30),
                        'keywords' => $fakerPt->realText(30),
                        'description' => $fakerPt->realText(60)
                    ],
                    'ru' => [
                        'name' => $fakerRu->realText(30),
                        'content' => $fakerRu->realText(6000),
                        'title' => $fakerRu->realText(30),
                        'keywords' => $fakerRu->realText(30),
                        'description' => $fakerRu->realText(60)
                    ],
                    'it' => [
                        'name' => $fakerIt->realText(30),
                        'content' => $fakerIt->realText(6000),
                        'title' => $fakerIt->realText(30),
                        'keywords' => $fakerIt->realText(30),
                        'description' => $fakerIt->realText(60)
                    ],
                ];
                $article = Article::create($add);
                if ($article->id === 1) {
                    $article->is_menu = 1;
                    $article->save();
                }
                if ($article->id > 1 && $article->id < 5) {
                    $article->is_show = 1;
                    $article->save();
                }
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
