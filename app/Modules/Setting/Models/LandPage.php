<?php

namespace App\Modules\Setting\Models;

use App\Http\Controllers\LandPageController;
use App\Modules\Url\Options\UrlOptions;
use App\Modules\Url\Traits\HasUrl;
use App\Traits\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandPage extends Model
{
    use HasFactory,Time, HasUrl;

    const MAX = 11;

    protected $casts = [
        'plate_content_1'=>'array',
        'plate_content_2'=>'array',
        'plate_content_3'=>'array',
        'plate_content_4'=>'array',
        'plate_content_5'=>'array',
        'plate_content_6'=>'array',
        'plate_content_7'=>'array',
        'plate_content_8'=>'array',
        'plate_content_9'=>'array',
        'plate_content_10'=>'array',
    ];

    protected $fillable = [
        'name','title','keywords','description','url_key','area_name',
        'plate_content_1','plate_content_2','plate_content_3','plate_content_4', 'plate_content_5',
        'plate_content_6','plate_content_7','plate_content_8', 'plate_content_9','plate_content_10'
    ];


    public function getUrlOptions(): UrlOptions
    {
        return UrlOptions::instance()
            ->routeUrlTo(LandPageController::class, 'show')
            ->generateUrlSlugFrom('url_key')
            ->saveUrlSlugTo('url_key');
    }


}
