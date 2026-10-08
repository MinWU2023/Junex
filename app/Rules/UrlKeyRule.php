<?php

namespace App\Rules;

use App\Modules\Url\Models\Url;
use Illuminate\Contracts\Validation\Rule;

class UrlKeyRule implements Rule
{
    public $id;

    protected $urlable_type;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id,$urlable_type)
    {
        $this->id = $id;
        $this->urlable_type = $urlable_type;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$value) {
            return true;
        }

        $slug = trim($value, '/');
        $query = Url::where('url', $slug);

        if ($this->id) {
            $query->where(function ($q) {
                $q->where('urlable_type', '<>', $this->urlable_type)
                    ->orWhere('urlable_id', '<>', $this->id);
            });
        }

        return !$query->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '该url已存在网站中,请换一个';
    }
}
