<?php

namespace App\Modules\Setting\Models;

use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyChooseSetting extends Model implements TranslatableContract
{
    use HasFactory, Translatable, ModelBoot;

    const MODEL_TYPE = 'why_choose_setting';

    public $translatedAttributes = [
        'title',
        'subtitle',
        'description_desktop',
    ];

    protected $fillable = [
        'logo',
    ];

    /**
     * Get or create the singleton settings row.
     */
    public static function singleton(): self
    {
        $model = static::query()->with(['translations'])->orderBy('id')->first();
        if ($model) {
            return $model;
        }

        return static::query()->create([
            'logo' => '/front/imgs/index_wc_logo.png',
        ]);
    }
}
