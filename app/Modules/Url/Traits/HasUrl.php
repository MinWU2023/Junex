<?php


namespace App\Modules\Url\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Modules\Url\Exceptions\UrlException;
use App\Modules\Url\Models\Url;
use App\Modules\Url\Options\SlugOptions;
use App\Modules\Url\Options\UrlOptions;

trait HasUrl
{
    use HasSlug;

    /**
     * The container for all the options necessary for this trait.
     * Options can be viewed in the Neurony\Url\Options\UrlOptions file.
     *
     * @var UrlOptions
     */
    protected $urlOptions;

    /**
     * Flag to manually enable/disable the url generation only for the current request.
     *
     * @var bool
     */
    protected static $generateUrl = true;

    /**
     * Set the options for the HasUrl trait.
     *
     * @return UrlOptions
     */
    abstract public function getUrlOptions(): UrlOptions;

    /**
     * Boot the trait.
     *
     * Check if the "getUrlOptions" method has been implemented on the underlying model class.
     * Eager load urls through anonymous global scope.
     * Trigger eloquent events to create, update, delete url.
     *
     * @return void
     */
    public static function bootHasUrl(): void
    {
        static::addGlobalScope('url', function (Builder $builder) {
            $builder->with('url');
        });

        static::created(function (Model $model) {
            if (self::$generateUrl === true) {
                $model->createUrl();
            }
        });

        static::updated(function (Model $model) {
            if (self::$generateUrl === true) {
                $model->updateUrl();
            }
        });

        static::saved(function (Model $model) {
            if (self::$generateUrl === false) {
                self::$generateUrl = true;
            }
        });

        static::deleted(function (Model $model) {
            if ($model->forceDeleting !== false) {
                $model->deleteUrl();
            }
        });
    }

    /**
     * Get the model's url.
     *
     * @return MorphOne
     */
    public function url(): MorphOne
    {
        return $this->morphOne(Url::class, 'urlable');
    }

    /**
     * Get the model's direct url string.
     *
     * @param bool|null $secure
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string|null
     */
    public function getUrl(?bool $secure = null): ?string
    {
        if ($this->url && $this->url->exists) {
            return url($this->url->url, [], $secure);
        }

        return null;
    }

    /**
     * Get the model's direct uri string.
     *
     * @return string|null
     */
    public function getUri(): ?string
    {
        return optional($this->url)->url ?: null;
    }

    /**
     * Disable the url generation manually only for the current request.
     *
     * @return static
     */
    public function doNotGenerateUrl(): self
    {
        self::$generateUrl = false;

        return $this;
    }

    /**
     * Get the options for the HasSlug trait.
     *
     * @return SlugOptions
     * @throws Exception
     */
    public function getSlugOptions(): SlugOptions
    {
        $this->initUrlOptions();

        return SlugOptions::instance()
            ->generateSlugFrom($this->urlOptions->fromField)
            ->saveSlugTo($this->urlOptions->toField);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function saveUrl(): void
    {
        $this->initUrlOptions();

        if ($this->url && $this->url->exists) {
            $this->updateUrl();
        } else {
            $this->createUrl();
        }
    }

    /**
     * Create a new url for the model.
     *
     * @return void
     * @throws Exception
     */
    public function createUrl(): void
    {
        $this->initUrlOptions();
        $this->syncUrlRecord();
    }

    /**
     * Update the existing url for the model.
     *
     * @return void
     * @throws Exception
     */
    public function updateUrl(): void
    {
        $this->initUrlOptions();
        $this->syncUrlRecord();
    }

    /**
     * Upsert urls row for this model by current url_key (toField).
     * Deduplicate: unique against other models (suffix -1/-2...),
     * reclaim soft-deleted same slug, keep a single morph row for this model.
     */
    public function syncUrlRecord(): void
    {
        $this->initUrlOptions();

        $slug = trim((string)$this->getAttribute($this->urlOptions->toField), '/');
        if ($slug === '') {
            return;
        }

        try {
            DB::transaction(function () use (&$slug) {
                $type = static::class;
                $id = (int)$this->getKey();
                $toField = $this->urlOptions->toField;

                // Soft-deleted rows still occupy unique(url); clear them for this slug if not ours
                Url::onlyTrashed()
                    ->where('url', $slug)
                    ->where(function ($q) use ($type, $id) {
                        $q->where('urlable_type', '<>', $type)
                            ->orWhere('urlable_id', '<>', $id);
                    })
                    ->forceDelete();

                // Active conflict with another model => unique suffix
                $original = $slug;
                $i = 1;
                while (
                    Url::where('url', $slug)
                        ->where(function ($q) use ($type, $id) {
                            $q->where('urlable_type', '<>', $type)
                                ->orWhere('urlable_id', '<>', $id);
                        })
                        ->exists()
                ) {
                    $slug = $original . '-' . $i++;
                }

                if ($slug !== trim((string)$this->getAttribute($toField), '/')) {
                    $wasGenerating = self::$generateUrl;
                    self::$generateUrl = false;
                    $this->setAttribute($toField, $slug);
                    $this->save();
                    self::$generateUrl = $wasGenerating;
                }

                // Prefer existing morph url for this model (including soft-deleted)
                $mine = Url::withTrashed()
                    ->where('urlable_type', $type)
                    ->where('urlable_id', $id)
                    ->orderByDesc('id')
                    ->get();

                $primary = $mine->first();
                if ($primary) {
                    foreach ($mine->slice(1) as $dup) {
                        $dup->forceDelete();
                    }
                    if (method_exists($primary, 'trashed') && $primary->trashed()) {
                        $primary->restore();
                    }
                    if ((string)$primary->url !== $slug) {
                        // Free target slug if held by soft-deleted other (already handled) or self duplicate
                        Url::onlyTrashed()->where('url', $slug)->where('id', '<>', $primary->id)->forceDelete();
                        $primary->url = $slug;
                        $primary->save();
                    }
                    return;
                }

                $trashedSame = Url::onlyTrashed()->where('url', $slug)->first();
                if ($trashedSame) {
                    $trashedSame->restore();
                    $trashedSame->urlable_type = $type;
                    $trashedSame->urlable_id = $id;
                    $trashedSame->url = $slug;
                    $trashedSame->save();
                    return;
                }

                $this->url()->create([
                    'url' => $slug,
                ]);
            });
        } catch (Exception $e) {
            Log::error('syncUrlRecord failed: ' . $e->getMessage(), [
                'model' => static::class,
                'id' => $this->getKey(),
                'slug' => $slug,
            ]);
            throw UrlException::updateFailed();
        }
    }

    /**
     * Delete the url for the just deleted model.
     *
     * @return void
     * @throws UrlException
     */
    public function deleteUrl(): void
    {
        try {
            $this->url()->delete();
        } catch (Exception $e) {
            throw UrlException::deleteFailed();
        }
    }

    /**
     * Synchronize children urls for the actual model's url.
     * Saves all children urls of the model in use with the new parent model's slug.
     *
     * @return void
     */
    protected function updateUrlsInCascade(): void
    {
        $old = trim($this->getOriginal($this->urlOptions->toField), '/');
        $new = trim($this->getAttribute($this->urlOptions->toField), '/');

        $children = URL::where('urlable_type', static::class)->where(function ($query) use ($old) {
            $query->where('url', 'like', "{$old}/%")->orWhere('url', 'like', "%/{$old}/%");
        })->get();

        foreach ($children as $child) {
            $child->update([
                'url' => str_replace($old.'/', $new.'/', $child->url),
            ]);
        }
    }

    /**
     * Get the full relative url.
     * The full url will also include the prefix and suffix if any was provided.
     *
     * @return string
     */
    protected function buildFullUrl(): string
    {
        return $this->getAttribute($this->urlOptions->toField);
        $prefix = $this->buildUrlSegment('prefix');
        $suffix = $this->buildUrlSegment('suffix');
        return
            (Str::is('/', $prefix) ? '' : ($prefix ? $prefix.$this->urlOptions->urlGlue : '')).
            $this->getAttribute($this->urlOptions->toField).
            (Str::is('/', $suffix) ? '' : ($suffix ? $this->urlOptions->urlGlue.$suffix : ''));
    }

    /**
     * Build the url segment.
     * This can be either "prefix" or "suffix".
     * The accepted parameter $type accepts only "prefix" and "suffix" as it's value.
     * Otherwise, the method will return an empty string.
     *
     * @param string $type
     * @return string
     */
    protected function buildUrlSegment(string $type): string
    {
        if ($type != 'prefix' && $type != 'suffix') {
            return '';
        }

        $segment = $this->urlOptions->{'url'.ucwords($type)};

        if (is_callable($segment)) {
            return call_user_func_array($segment, [[], $this]);
        } elseif (is_array($segment)) {
            return implode($this->urlOptions->urlGlue, $segment);
        } elseif (is_string($segment)) {
            return $segment;
        } else {
            return '';
        }
    }

    /**
     * Both instantiate the url options as well as validate their contents.
     *
     * @return void
     * @throws Exception
     */
    protected function initUrlOptions(): void
    {
        if ($this->urlOptions === null) {
            $this->urlOptions = $this->getUrlOptions();
        }

        $this->validateUrlOptions();
    }

    /**
     * Check if mandatory slug options have been properly set from the model.
     * Check if $fromField and $toField have been set.
     *
     * @return void
     * @throws UrlException
     */
    protected function validateUrlOptions(): void
    {
        if (! $this->urlOptions->routeController || ! $this->urlOptions->routeAction) {
            throw UrlException::mandatoryRouting(static::class);
        }

        if (! $this->urlOptions->fromField) {
            throw UrlException::mandatoryFromField(static::class);
        }

        if (! $this->urlOptions->toField) {
            throw UrlException::mandatoryToField(static::class);
        }
    }
}
