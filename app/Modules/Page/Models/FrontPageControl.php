<?php

namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;

class FrontPageControl extends Model
{
    protected $fillable = [
        'path',
        'name',
        'sitemap_on',
        'access_on',
    ];

    protected $casts = [
        'sitemap_on' => 'boolean',
        'access_on' => 'boolean',
    ];
}
