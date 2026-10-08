<?php


namespace App\Services;


use App\Modules\Page\Models\Page;

class PageService
{
    public function getAboutPage()
    {
        return Page::with(['children.translations'])->orderByDesc('sort')->where('url_key', 'about-us')->first();
    }

    public function getPageByName($name)
    {
        return Page::with(['translations'])->whereTranslation('name', $name)->first();
    }
}
