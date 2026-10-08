<?php

namespace App\Modules\Download\Models;


use App\Traits\ModelBoot;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory,Translatable,ModelBoot;

    const MODEL_TYPE = 'download';

    public $translatedAttributes = ['name', 'content'];


    public $fillable = ['sort','img','url','filepath','download_category_id','is_translate','download_key'];

    public function downloadCategory(){
        return $this->belongsTo(DownloadCategory::class);
    }


    public function getFilePathAttribute($value)
    {
        // 获取当前请求路径
        $currentPath = request()->path();
        // 判断是否为 /nosay 页面（管理后台）
        if (str_contains($currentPath, config('app.admin_prefix'))) {
            // 在管理后台显示原始数据
            return $value;
        }
        
        // 非管理后台页面，返回下载链接格式
        return $value ? url('/download/' . $this->download_key) : '';
    }

    protected function isTranslationDirty(Model $translation): bool
    {
        $dirtyAttributes = $translation->getDirty();
        unset($dirtyAttributes[$this->getLocaleKey()]);
        $bol = false;
        foreach($translation->getFillable() as $key => $value) {
            if ($translation->$value) {
                $bol = true;
                break;
            }
        }
        return count($dirtyAttributes) > 0 && $bol;
    }


}
