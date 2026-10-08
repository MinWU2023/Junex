<?php

namespace Database\Seeders;

use App\Modules\Page\Models\Page;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
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
        $arr = ['about-us','contact-us'];
        foreach ($arr as $key => $value) {
            $add = [
                'parent_id' => 0,
                'sort' => 0,
                'url_key' => $value,
                'active' => 1,
                'en' => [
                    'name' => $faker->realText(30),
                    'content' => $faker->realText(5000),
                ],
                'ja' => [
                    'name' => $fakerJp->realText(30),
                    'content' => $fakerJp->realText(5000),
                ],
                'de' => [
                    'name' => $fakerDe->realText(30),
                    'content' => $fakerDe->realText(5000),
                ],
                'es' => [
                    'name' => $fakerEs->realText(30),
                    'content' => $fakerEs->realText(5000),
                ],
                'pt' => [
                    'name' => $fakerPt->realText(30),
                    'content' => $fakerPt->realText(5000),
                ],
                'ru' => [
                    'name' => $fakerRu->realText(30),
                    'content' => $fakerRu->realText(5000),
                ],
                'it' => [
                    'name' => $fakerIt->realText(30),
                    'content' => $fakerIt->realText(5000),
                ],
            ];
            Page::create($add);
        }
    }
}
