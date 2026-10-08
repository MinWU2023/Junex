<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Log;

class AdminLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'ip', 'name', 'modelName','path', 'browser',
        'content','data_source_id','data_created_at'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function log($logs)
    {
        if (!Auth::guest()) {
            DB::table('admin_logs')->insert(array_merge([
                'user_id' => Auth::id(),
                'ip' => GetUserIP(),
                'browser' => Agent::getUserAgent(),
                'path' => \request()->path(),
                'created_at'=>date('Y-m-d H:i:s'),
            ],$logs));
        }
    }

}
