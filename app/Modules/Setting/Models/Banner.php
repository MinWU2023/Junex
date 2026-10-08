<?php
namespace App\Modules\Setting\Models;

use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model implements TranslatableContract
{
    use HasFactory,Translatable,ModelBoot;

    const MODEL_TYPE = 'banner';

    protected $fillable = [
        'area', 'url', 'path', 'path_mobile', 'sort','is_translate'
    ];

    public $translatedAttributes = [
        'name','alt','description','button_text'
    ];

    public function setPathMobileAttribute($value): void
    {
        $value = is_string($value) ? trim($value) : $value;
        $this->attributes['path_mobile'] = ($value === '' || $value === null) ? null : $value;
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
