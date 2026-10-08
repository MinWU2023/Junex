<?php

namespace Database\Seeders;

use App\Modules\Admin\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * 默认超级管理员密码 firstpage
         */
        User::create([
            'name'  => 'dyyseo',
            'email' => 'admin@dyyseo.com',
            'password' => bcrypt('firstpage'),
        ]);


        /**
         * 网站管理员账号密码 website
         */
        User::create([
            'name'  => 'website',
            'email' => 'website@dyyseo.com',
            'password' => bcrypt('website'),
        ]);

//        User::create([
//            'name'  => 'preproduct',
//            'email' => 'pre@dyyseo.com',
//            'password' => bcrypt('preproduct'),
//        ]);


//        //产品+内容管理员
//        User::create([
//            'name'  => 'bdmin',
//            'email' => 'bdmin@dyyseo.com',
//            'password' => bcrypt('bdmin'),
//        ]);
//
//        //产品管理员
//        User::create([
//            'name'  => 'product',
//            'email' => 'product@dyyseo.com',
//            'password' => bcrypt('product'),
//        ]);
//
//
//        //内容管理员
//        User::create([
//            'name'  => 'content',
//            'email' => 'content@dyyseo.com',
//            'password' => bcrypt('content'),
//        ]);





    }
}
