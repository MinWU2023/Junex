<?php


namespace App\Extend;


use App\Modules\Setting\Models\Locale;
use Astrotomic\Translatable\Exception\LocalesNotDefinedException;

class Locales extends \Astrotomic\Translatable\Locales
{
    public function load(): void
    {
        $locales = Locale::orderBy('sort', 'desc')->get();
        $translatable_locales = [];
        $translatable_language = [];
        foreach ($locales as $locale) {
            $translatable_locales[] = $locale->language_code;
            $translatable_language[$locale->language_code] = $locale->language;
        }
        config([
            'translatable.locales' => $translatable_locales,
            'translatable.language' => $translatable_language
        ]);

        $localesConfig = (array) $translatable_locales;

        if (empty($localesConfig)) {
            throw LocalesNotDefinedException::make();
        }

        $this->locales = [];
        foreach ($localesConfig as $key => $locale) {
            if (is_string($key) && is_array($locale)) {
                $this->locales[$key] = $key;

                foreach ($locale as $country) {
                    $countryLocale = $this->getCountryLocale($key, $country);
                    $this->locales[$countryLocale] = $countryLocale;
                }
            } elseif (is_string($locale)) {
                $this->locales[$locale] = $locale;
            }
        }
    }

}
