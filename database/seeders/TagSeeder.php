<?php

namespace Database\Seeders;

use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductTag;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
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
        $products = Product::get();
        $names = collect($products)->map(function($q){
            return $q->name;
        })->toArray();
        for ($i = 0; $i <= 100; $i++) {
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
            ProductTag::create($add);
        }

        $productTags = ProductTag::pluck('id')->toArray();
        $products = Product::get();
        foreach ($products as $product) {
            $keys = array_rand($productTags, random_int(1,7));
            $temp = collect($keys)->map(function($q) use ($productTags){
                return $productTags[$q];
            });
            $product->productTags()->attach($temp);
        }
    }
}
