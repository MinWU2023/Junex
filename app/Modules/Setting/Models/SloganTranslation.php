<?php

namespace App\Modules\Setting\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SloganTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

}
