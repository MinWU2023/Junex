<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $add = [];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $baseUrl = str_replace('http://','',config('app.url'));
        $baseUrl = str_replace('https://','',$baseUrl);
        foreach (config('translatable.locales') as $key => $value) {
            $add[$key]['language'] = config('translatable.language')[$value];
            $add[$key]['language_code'] = $value;
            if ($value === 'en') {
                $add[$key]['url'] = $baseUrl;
                $add[$key]['sort'] = 9999;
            } else {
                $add[$key]['sort'] = 0;
                $add[$key]['url'] = $value. '.' . $baseUrl;
            }
            $add[$key]['path'] = 'images/'.$value . '.jpg';
            $add[$key]['created_at'] = $created_at;
            $add[$key]['updated_at'] = $updated_at;
        }
        DB::table('locales')->insert($add);
    }
}
