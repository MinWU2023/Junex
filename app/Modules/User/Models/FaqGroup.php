<?php

namespace App\Modules\User\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqGroup extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = [
        'name',
        'content',
    ];

    protected $fillable = [
        'name',
        'content',
    ];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'faq_group_id')
            ->orderByDesc('sort')
            ->orderByDesc('id');
    }
}
