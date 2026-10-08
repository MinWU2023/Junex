<?php

namespace Database\Seeders;

use App\Modules\Inquiry\Models\Inquiry;
use Faker\Factory;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $max = rand(500, 1000);
        for ($i = 0; $i < $max; $i++) {
            Inquiry::create([
                'title' => $faker->realText(30),
                'content' => $faker->realText(300),
                'email' => $faker->email(11),
                'tel' => $faker->phoneNumber(11),
                'ip' => $faker->ipv4(10),
                'location' => $faker->city(10),
                'source_url' => $faker->url(12),
                'client' => 'pc',
            ]);
        }
        //给予超级管理员分配权限
    }
}
