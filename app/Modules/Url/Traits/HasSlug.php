<?php


namespace App\Modules\Url\Traits;


use App\Modules\Url\Models\Url;
use App\Modules\Url\Options\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Modules\Url\Exceptions\SlugException;

trait HasSlug
{
    /**
     * The container for all the options necessary for this trait.
     * Options can be viewed in the Neurony\Url\Options\SlugOptions file.
     *
     * @var SlugOptions
     */
    protected $slugOptions;

    /**
     * Set the options for the HasSlug trait.
     *
     * @return SlugOptions
     */
    abstract public function getSlugOptions(): SlugOptions;

    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->generateSlugOnCreate();
        });

        static::updating(function (Model $model) {
            $model->generateSlugOnUpdate();
        });
    }

    /**
     * Handle setting the slug on model creation.
     *
     * @return void
     * @throws SlugException
     */
    protected function generateSlugOnCreate(): void
    {
        $this->initSlugOptions();

        if ($this->slugOptions->generateSlugOnCreate === false) {
            return;
        }

        $this->generateSlug();
    }

    /**
     * Handle setting the slug on model update.
     *
     * @return void
     * @throws SlugException
     */
    protected function generateSlugOnUpdate(): void
    {
        $this->initSlugOptions();

        if ($this->slugOptions->generateSlugOnUpdate === false) {
            return;
        }

        $this->generateSlug();
    }

    /**
     * The logic for actually setting the slug.
     *
     * @return void
     * @throws SlugException
     */
    public function generateSlug(): void
    {
        $this->initSlugOptions();

        if ($this->slugHasBeenSupplied()) {
            $slug = $this->generateNonUniqueSlug();
            if ($this->slugOptions->uniqueSlugs) {
                $slug = $this->makeSlugUnique($slug);
            }
            $this->setAttribute($this->slugOptions->toField, $slug);
        }
    }

    /**
     * Generate a non unique slug for this record.
     *
     * @return string
     */
    protected function generateNonUniqueSlug(): string
    {
        if ($this->slugHasChanged()) {
            $source = (string)$this->getAttribute($this->slugOptions->toField);
            if (Str::is('/', $source) || $source === '') {
                return $source;
            }
            // Preserve path-style slugs (e.g. product/my-slug)
            if (str_contains($source, '/')) {
                $separator = $this->slugOptions->slugSeparator;
                $language = $this->slugOptions->slugLanguage;
                $parts = array_map(
                    static fn ($p) => Str::slug($p, $separator, $language),
                    explode('/', $source)
                );
                return implode('/', array_values(array_filter($parts, static fn ($p) => $p !== '')));
            }
            return Str::slug($source, $this->slugOptions->slugSeparator, $this->slugOptions->slugLanguage);
        }
        $source = $this->getSlugSource();
        return $source;
    }

    /**
     * Make the given slug unique.
     *
     * @param string $slug
     * @return string
     */
    protected function makeSlugUnique(string $slug): string
    {
        $original = $slug;
        $i = 1;

        while ($this->slugAlreadyExists($slug) || $slug === '') {
            $slug = $original.$this->slugOptions->slugSeparator.$i++;
        }

        return $slug;
    }

    /**
     * Check if the $fromField slug has been supplied.
     * If not, then skip the entire slug generation.
     *
     * @return bool
     */
    protected function slugHasBeenSupplied(): bool
    {
        if (is_array($this->slugOptions->fromField)) {
            foreach ($this->slugOptions->fromField as $field) {
                if ($this->getAttribute($field) !== null) {
                    return true;
                }
            }

            return false;
        }

        return $this->getAttribute($this->slugOptions->fromField) !== null;
    }

    /**
     * Determine if a custom slug has been saved.
     *
     * @return bool
     */
    protected function slugHasChanged(): bool
    {
        return
            $this->getOriginal($this->slugOptions->toField) &&
            $this->getOriginal($this->slugOptions->toField) != $this->getAttribute($this->slugOptions->toField);
    }

    /**
     * Get the string that should be used as base for the slug.
     *
     * @return string
     */
    protected function getSlugSource(): string
    {
        if (is_callable($this->slugOptions->fromField)) {
            return call_user_func($this->slugOptions->fromField, $this);
        }

        return collect($this->slugOptions->fromField)->map(function ($field) {
            return $this->getAttribute($field) ?: '';
        })->implode($this->slugOptions->slugSeparator);
    }

    /**
     * Check if the given slug already exists on another record.
     *
     * @param string $slug
     * @return bool
     */
    protected function slugAlreadyExists(string $slug): bool
    {
        $query = Url::where('url', $slug);

        // Exclude this model's own url row so update/create doesn't force -1/-2 suffixes
        if ($this->getKey()) {
            $query->where(function ($q) {
                $q->where('urlable_type', '<>', static::class)
                    ->orWhere('urlable_id', '<>', $this->getKey());
            });
        }

        return (bool) $query->exists();
    }

    /**
     * Both instantiate the slug options as well as validate their contents.
     *
     * @return void
     * @throws SlugException
     */
    protected function initSlugOptions(): void
    {
        if ($this->slugOptions === null) {
            $this->slugOptions = $this->getSlugOptions();
        }

        $this->validateSlugOptions();
    }

    /**
     * Check if mandatory slug options have been properly set from the model.
     * Check if $fromField and $toField have been set.
     *
     * @return void
     * @throws SlugException
     */
    protected function validateSlugOptions(): void
    {
        if (! $this->slugOptions->fromField) {
            throw SlugException::mandatoryFromField(static::class);
        }

        if (! $this->slugOptions->toField) {
            throw SlugException::mandatoryToField(static::class);
        }
    }
}
