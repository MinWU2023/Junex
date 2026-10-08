<?php

namespace App\Console\Commands\Init;

use App\Modules\Admin\Models\User;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductAttribute;
use App\Modules\Product\Models\ProductAttributeValue;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Product\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeedYogaProducts extends Command
{
    protected $signature = 'seed:yoga-products {--count=100 : Number of products to create} {--force : Update translations if product already exists}';
    protected $description = 'Seed yoga apparel products with images, attributes, categories, url_key and urls.';

    public function handle(): int
    {
        $count = (int)$this->option('count');
        if ($count <= 0) {
            $this->error('Count must be greater than 0.');
            return 1;
        }

        $force = (bool)$this->option('force');

        $secondLevelCategories = ProductCategory::query()
            ->where('parent_id', '!=', 0)
            ->get();

        if ($secondLevelCategories->isEmpty()) {
            $this->error('No second-level categories found. Please seed categories first.');
            return 1;
        }

        $adminId = (int)(User::query()->value('id') ?? 1);

        $attributeDefs = $this->attributeDefinitions();
        $attributes = $this->ensureAttributes($attributeDefs);

        $images = [
            '/front/data/product-01.png',
            '/front/data/product-02.png',
        ];

        $productNames = [
            'Seamless Yoga Leggings',
            'High-Waist Sculpt Leggings',
            'Ribbed Yoga Set',
            'Breathable Yoga Tank',
            'Supportive Sports Bra',
            'Lightweight Yoga Hoodie',
            'Soft Stretch Joggers',
            'Flowy Yoga Shorts',
            'Long Sleeve Yoga Top',
            'Zip-Up Training Jacket',
        ];

        DB::beginTransaction();
        try {
            $categoryIds = $secondLevelCategories->pluck('id')->values();
            $categoryCount = $categoryIds->count();

            for ($i = 1; $i <= $count; $i++) {
                $categoryId = $categoryIds[($i - 1) % $categoryCount];
                $name = $productNames[array_rand($productNames)];
                $name = $name.' '.$i;
                $urlKey = $this->slug($name);

                $product = Product::query()->where('url_key', $urlKey)->first();
                if (!$product) {
                    $product = new Product();
                    $product->product_brand_id = null;
                    $product->sort = $count - $i;
                    $product->url_key = $urlKey;
                    $product->active = 1;
                    $product->is_new = ($i % 3 === 0) ? 1 : 0;
                    $product->is_hot = ($i % 4 === 0) ? 1 : 0;
                    $product->is_recommend = ($i % 5 === 0) ? 1 : 0;
                    $product->is_temp = 0;
                    $product->admin_user_id = $adminId;
                    $product->add_date = time();
                    $product->attribute_category_id = null;
                    $product->video = null;
                    $product->backup_tags = null;
                    $product->is_draft = 0;
                }

                $translation = $product->translateOrNew('en');
                if ($force || !$translation->name) {
                    $translation->name = $name;
                    $translation->brief_content = 'Performance yoga wear designed for comfort, stretch, and support.';
                    $translation->content = $this->longContent($name);
                    $translation->m_content = $translation->content;
                    $translation->attribute = $this->attributeSummary();
                    $translation->title = $name.' | Yoga Apparel';
                    $translation->keywords = 'yoga wear, yoga clothing, activewear, breathable, stretch';
                    $translation->description = 'Premium yoga apparel with soft fabrics and flexible fit for daily practice.';
                }

                $product->save();
                $product->saveUrl();

                DB::table('product_product_category')->updateOrInsert([
                    'product_id' => $product->id,
                    'product_category_id' => $categoryId,
                ], [
                    'product_id' => $product->id,
                    'product_category_id' => $categoryId,
                ]);

                $existingImages = ProductImage::query()->where('product_id', $product->id)->count();
                if ($existingImages === 0) {
                    for ($imgIndex = 0; $imgIndex < 8; $imgIndex++) {
                        $path = $images[$imgIndex % count($images)];
                        ProductImage::create([
                            'product_id' => $product->id,
                            'path' => $path,
                            'is_main' => $imgIndex === 0 ? 1 : 0,
                            'sort' => 100 - $imgIndex,
                            'alt' => $name.' image '.($imgIndex + 1),
                        ]);
                    }
                }

                foreach ($attributes as $attributeName => $attribute) {
                    $value = $this->attributeValue($attributeName);
                    $attrRow = DB::table('product_attribute_values')
                        ->where('product_id', $product->id)
                        ->where('product_attribute_id', $attribute->id)
                        ->first();

                    if (!$attrRow) {
                        $attrId = DB::table('product_attribute_values')->insertGetId([
                            'product_id' => $product->id,
                            'product_attribute_id' => $attribute->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        $attrId = $attrRow->id;
                    }

                    DB::table('product_attribute_value_translations')->updateOrInsert([
                        'product_attribute_value_id' => $attrId,
                        'locale' => 'en',
                    ], [
                        'name' => $value,
                    ]);
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Seed failed: '.$e->getMessage());
            return 1;
        }

        $this->info('Products seeded successfully.');
        $this->info('Use --force to refresh translations on existing products.');

        return 0;
    }

    private function ensureAttributes(array $definitions): array
    {
        $attributes = [];
        foreach ($definitions as $sort => $name) {
            $existing = ProductAttribute::query()
                ->whereHas('translations', function ($query) use ($name) {
                    $query->where('locale', 'en')->where('name', $name);
                })
                ->first();

            if (!$existing) {
                $existing = new ProductAttribute();
                $existing->sort = $sort + 1;
                $existing->default = 0;
                $existing->admin_user_id = 0;
                $existing->options = null;
                $translation = $existing->translateOrNew('en');
                $translation->name = $name;
                $existing->save();
            }

            $attributes[$name] = $existing;
        }

        return $attributes;
    }

    private function attributeDefinitions(): array
    {
        return [
            'Trademark/Brand',
            'Model',
            'Material',
            'MOQ',
            'Size',
            'Colour',
            'Label & Tag',
            'Supply Type',
            'FOB port',
            'Terms of Payment',
        ];
    }

    private function attributeValue(string $name): string
    {
        switch ($name) {
            case 'Trademark/Brand':
                return 'JUNEX Sportswear Manufacturer';
            case 'Model':
                return 'JA'.rand(200000, 999999).'B';
            case 'Material':
                return 'Nylon/Spandex (Customized)';
            case 'MOQ':
                return rand(100, 500).'PCS';
            case 'Size':
                return 'XXS-XXXL or Customized';
            case 'Colour':
                return 'All sorts of colours';
            case 'Label & Tag':
                return 'JUNEX/Customized';
            case 'Supply Type':
                return 'OEM/ODM/Design service';
            case 'FOB port':
                return 'FOB Shenzhen / Guangzhou';
            case 'Terms of Payment':
                return 'L/C, D/A, D/P, Western Union, MoneyGram, T/T, PayPal';
            default:
                return 'Customized';
        }
    }

    private function slug(string $value): string
    {
        $slug = Str::slug($value, '-');
        return $slug ?: Str::random(10);
    }

    private function longContent(string $name): string
    {
        return $name.' crafted with soft, breathable fabric, ideal for yoga, pilates, and everyday training. '.
            'Designed for flexibility and support with clean finishing and durable stitching.';
    }

    private function attributeSummary(): string
    {
        return 'Brand: JUNEX; Material: Nylon/Spandex; MOQ: 200PCS; Size: XXS-XXXL or Customized; '.
            'Colour: Multiple options; Label & Tag: Customized; Supply Type: OEM/ODM; FOB port: Shenzhen/Guangzhou; '.
            'Terms: L/C, D/A, D/P, Western Union, MoneyGram, T/T, PayPal';
    }
}
