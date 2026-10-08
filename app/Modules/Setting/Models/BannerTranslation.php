<?php
namespace App\Modules\Setting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name','alt','description','button_text','banner_id','locale'];

}
