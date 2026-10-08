<?php

namespace App\Modules\Search\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'deadline_time'
    ];

    public function searchDetail()
    {
        return $this->hasMany(SearchDetail::class);
    }
}
