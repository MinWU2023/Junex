<?php

namespace Database\Seeders;

use App\Modules\Product\Models\ProductAttribute;
use App\Modules\Product\Models\ProductAttributeCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attribute_category = ProductAttributeCategory::query()->create([
            'name' => 'default'
        ]);

        $attrs = [
            [
                'Item No',
                ''
            ],
            [
                'Order(MOQ)',
                ''
            ],
            [
                'Payment',
                ''
            ],
            [
                'Product Origin',
                ''
            ],
            [
                'Color',
                ''
            ],
            [
                'Shipping Port',
                ''
            ],
            [
                'Lead Time',
                ''
            ],
            [
                'Weight',
                ''
            ],
        ];
        foreach ($attrs as $k => $attr) {
            $brandsData = [
                'sort' => 10-$k,
                'default' => $attr[1],
                'en' => [
                    'name' => $attr[0]
                ],
            ];
            ProductAttribute::create($brandsData);
        }
        $attrids = array_column(ProductAttribute::query()->select(['id'])->get()->toArray(),'id');
        $attribute_category->attributes()->sync($attrids);
        //
    }
}
