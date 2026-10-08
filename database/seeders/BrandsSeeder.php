<?php

namespace Database\Seeders;

use App\Modules\Product\Models\ProductBrand;
use Faker\Factory;
use Illuminate\Database\Seeder;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();
        for ($i =0; $i<=65; $i++) {
            $brandsData = [
                'sort' => 0,
                'name' => $faker->realText(20)
            ];
            ProductBrand::create($brandsData);
        }
        //
    }
}
