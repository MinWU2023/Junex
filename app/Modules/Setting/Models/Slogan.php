<?php

namespace App\Modules\Setting\Models;

use App\Traits\ModelBoot;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slogan extends Model implements TranslatableContract
{
    use HasFactory,Translatable,ModelBoot;

    const MODEL_TYPE = 'slogan';

    public $translatedAttributes = [
       'name'
    ];

    protected $fillable = ['type','is_translate'];

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
