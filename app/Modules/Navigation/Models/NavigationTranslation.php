<?php
namespace App\Modules\Navigation\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationTranslation extends Model
{
    use HasFactory;

    public $timestamps= false;
    protected $fillable = ['name','navigation_id','locale'];
}
