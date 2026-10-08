<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SloganSeeder extends Seeder
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


        $slogans = [
            [
                'id' => 1,
                'type' => '产品分类标语',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'type' => '热卖产品标语',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'type' => '关于我们标语',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'type' => '最新新闻标语',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        DB::table('slogans')->insert($slogans);

        foreach ($slogans as $slogan){
            $translations = [
                [
                    'slogan_id' => $slogan['id'],
                    'locale' => 'en',
                    'name' => $faker->realText(500)
                ],
                [
                    'slogan_id' => $slogan['id'],
                    'locale' => 'ja',
                    'name' => $fakerJp->realText(500)
                ],
                [
                    'slogan_id' => $slogan['id'],
                    'locale' => 'de',
                    'name' => $fakerDe->realText(500)
                ],
                [
                    'slogan_id' => $slogan['id'],
                    'locale' => 'es',
                    'name' => $fakerEs->realText(500)
                ],
                [
                    'slogan_id' => $slogan['id'],
                    'locale' => 'pt',
                    'name' => $fakerPt->realText(500)
                ],
                [
                    'slogan_id' => $slogan['id'],
                    'locale' => 'ru',
                    'name' => $fakerRu->realText(500)
                ],
                [
                    'slogan_id' => $slogan['id'],
                    'locale' => 'it',
                    'name' => $fakerIt->realText(500)
                ],
            ];
            DB::table('slogan_translations')->insert($translations);
        }

    }
}
