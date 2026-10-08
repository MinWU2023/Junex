<?php

namespace App\Modules\User\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = [
        'subject',
        'content',
    ];

    protected $fillable = [
        'faq_group_id',
        'group',
        'subject',
        'content',
        'sort',
    ];

    protected $casts = [
        'sort' => 'integer',
        'faq_group_id' => 'integer',
    ];

    public function faqGroup()
    {
        return $this->belongsTo(FaqGroup::class, 'faq_group_id');
    }
}
