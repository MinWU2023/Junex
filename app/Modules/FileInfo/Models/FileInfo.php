<?php

namespace App\Modules\FileInfo\Models;

use App\Modules\Photo\Models\PhotoAlbum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name', 'mimeType', 'true_path', 'extention', 'size', 'is_download', 'is_upload',
        'manual', 'remark', 'create_by','is_watermark','photo_album_id'
    ];

    protected $appends = ['album'];

    public function getAlbumAttribute(){
        if ($this->photo_album_id){
            $album = PhotoAlbum::query()->find($this->photo_album_id);
            if ($album){
                return  $album->name;
            }
        }
        return '';
    }
}
