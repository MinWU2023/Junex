<?php
namespace App\Modules\Download\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['locale','download_id','name','content'];
}
