<?php

namespace App\Modules\Url\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\SoftDeletes;


class Url extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'url',
        'urlable_id',
        'urlable_type',
    ];

    const TYPENAMES = [
        'App\Modules\Product\Models\Product' => '产品',
        'App\Modules\Product\Models\ProductCategory' => '产品分类',
        'App\Modules\Product\Models\ProductTag' => '产品标签',
        'App\Modules\Article\Models\Article' => '文章',
        'App\Modules\Article\Models\ArticleCategory' => '文章分类',
        'App\Modules\Blog\Models\Blog' => '博客',
        'App\Modules\Blog\Models\BlogCategory' => '博客分类',
        'App\Modules\Blog\Models\BlogTag' =>'博客标签',
        'App\Modules\Download\Models\DownloadCategory' => '下载分类',
        'App\Modules\Page\Models\Page' =>'单页面',
        'App\Modules\Product\Models\ProductVideo' => '产品视频',
        'App\Modules\Product\Models\ProductVideoCategory' => '产品视频分类',
    ];


    public $appends = [
        'type'
    ];

    /**
     * Get all of the owning urlable models.
     *
     * @return MorphTo
     */
    public function urlable(): MorphTo
    {

        return $this->morphTo();
    }

    /**
     * Filter the query by url.
     *
     * @param Builder $query
     * @param string $url
     */
    public function scopeWhereUrl(Builder $query, string $url)
    {
        $query->where('url', $url);
    }



    public function getTypeAttribute()
    {
        $models = self::TYPENAMES;
        if (isset($models[$this->urlable_type])){
            return $models[$this->urlable_type];
        }
        return '未知';
    }

    /**
     * Filter the query by the urlable morph relation.
     *
     * @param Builder $query
     * @param int $id
     * @param string $type
     */
    public function scopeWhereUrlable(Builder $query, int $id, string $type)
    {
        $query->where([
            'urlable_id' => $id,
            'urlable_type' => $type,
        ]);
    }

    /**
     * Sort the query alphabetically by url.
     *
     * @param Builder $query
     */
    public function scopeInAlphabeticalOrder(Builder $query)
    {
        $query->orderBy('url', 'asc');
    }

    /**
     * Get the model instance correlated with the accessed url.
     *
     * @param bool $silent
     * @return Model|null
     * @throws ModelNotFoundException
     */
    public static function getUrlable(bool $silent = true): ?Model
    {
        $model = Request::route()->action['model'] ?? null;

        if ($model && $model instanceof Model && $model->exists) {
            return $model;
        }

        if ($silent === false) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * Get the model instance correlated with the accessed url.
     * Throw a ModelNotFoundException if the model doesn't exist.
     *
     * @return Model|null
     * @throws ModelNotFoundException
     */
    public static function getUrlableOrFail(): ?Model
    {
        return static::getUrlable(false);
    }


}
