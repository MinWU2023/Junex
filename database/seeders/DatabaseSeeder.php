<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SettingSeeder::class,
            AdminUserSeeder::class,
            MenuSeeder::class,
            PermissionSeeder::class,

//            CategoriesSeeder::class,
//            BrandsSeeder::class,
//            AttributeSeeder::class,
//            ProductsSeeder::class,
            LocaleSeeder::class,
//            PageSeeder::class,
//            TagSeeder::class,
//            ArticleSeeder::class,
        ]);
    }
}
