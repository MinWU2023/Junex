<?php
namespace App\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTagTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function setNameAttribute($value){
        return $this->attributes['name'] =  str_replace('&nbsp;',' ', trim($value));
    }

    public function setTitleAttribute($value){
        return $this->attributes['title'] =  str_replace('&nbsp;',' ', trim($value));
    }


    public function setKeywordsAttribute($value){
        return $this->attributes['keywords'] =  str_replace('&nbsp;',' ', trim($value));
    }

    public function setDescriptionAttribute($value){
        return $this->attributes['description'] =  str_replace('&nbsp;',' ', trim($value));
    }

}
