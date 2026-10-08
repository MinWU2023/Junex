<?php

namespace App\Modules\Page\Models;

use Illuminate\Database\Eloquent\Model;

class StaticBlockPageKey extends Model
{
    protected $table = 'static_block_page_keys';

    protected $fillable = [
        'static_block_id',
        'page_key',
    ];

    public function staticBlock()
    {
        return $this->belongsTo(StaticBlock::class, 'static_block_id');
    }
}
