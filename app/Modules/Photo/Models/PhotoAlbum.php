<?php

namespace App\Modules\Photo\Models;

use App\Traits\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PhotoAlbum extends Model
{
    use HasFactory,Time;

    protected $fillable = [
        'name','sort'
    ];

    protected $appends = ['img_count'];

    public function getImgCountAttribute(){
      return  DB::table('file_infos')->where('photo_album_id',$this->id)->count();
    }

}
