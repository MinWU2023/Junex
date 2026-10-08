<?php

namespace App\Modules\Download\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadCategoryTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable =['locale','download_category_id','name','title','keywords','description'];
}
