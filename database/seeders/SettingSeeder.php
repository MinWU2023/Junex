<?php

namespace Database\Seeders;

use App\Modules\Setting\Models\Setting;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
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
        //
        $add = [
            'logo' => 'images/admin-logo.png',
            'contract_mobile' => '+86 -18145716235',
            'contract_email' => 'mei.chan@sinao.com',
            'mail_mailer' => 'smtp',
            'mail_host' => 'mx.dyyservice.com',
            'mail_port' => '443',
            'mail_encryption' => 'ssl',
            'mail_username' => 'website@dyyseo.com',
            'mail_password' => 'diyiye35246',
            'mail_from_address' => 'talk23@dyyservice.com',
            'mail_from_name' => 'talk23@dyyservice.com',
            'mail_addressee' => 'talk23@dyyservice.com',
            'en' => [
                'name' => $faker->realText(30),
                'title' => $faker->realText(30),
                'keywords'=> $faker->realText(30),
                'description' => $faker->realText(100),
            ],
            'ja' => [
                'name' => $fakerJp->realText(30),
                'title' => $fakerJp->realText(30),
                'keywords'=> $fakerJp->realText(30),
                'description' => $fakerJp->realText(100),
            ],
            'de' => [
                'name' => $fakerDe->realText(30),
                'title' => $fakerDe->realText(30),
                'keywords'=> $fakerDe->realText(30),
                'description' => $fakerDe->realText(100),
            ],
            'es' => [
                'name' => $fakerEs->realText(30),
                'title' => $fakerEs->realText(30),
                'keywords'=> $fakerEs->realText(30),
                'description' => $fakerEs->realText(100),
            ],
            'pt' => [
                'name' => $fakerPt->realText(30),
                'title' => $fakerPt->realText(30),
                'keywords'=> $fakerPt->realText(30),
                'description' => $fakerPt->realText(100),
            ],
            'ru' => [
                'name' => $fakerRu->realText(30),
                'title' => $fakerRu->realText(30),
                'keywords'=> $fakerRu->realText(30),
                'description' => $fakerRu->realText(100),
            ],
            'it' => [
                'name' => $fakerIt->realText(30),
                'title' => $fakerIt->realText(30),
                'keywords'=> $fakerIt->realText(30),
                'description' => $fakerIt->realText(100),
            ],
            'banner_areas'=> json_encode([
                'home' , 'about us' , 'product' , 'project'  , 'video'
                ,'service'  ,'news'  ,'blog' , 'contact us'
            ])
        ];
        Setting::create($add);
    }
}
