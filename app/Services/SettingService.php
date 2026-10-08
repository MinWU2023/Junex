<?php


namespace App\Services;
use App\Modules\Setting\Models\Banner;
use App\Modules\Setting\Models\Locale;
use App\Modules\Setting\Models\Setting;
use App\Modules\Setting\Models\Slogan;
use Addons\Variable\Models\Variable;

class SettingService
{
    private $response = [];

    private function normalizeBannerArea(string $area): string
    {
        $area = trim($area);
        if ($area === '') {
            return $area;
        }
        return ucwords(strtolower($area));
    }

    public function getAllSetting()
    {
        $this->response['setting'] = Setting::with(['translations'])->first();
        $locales = Locale::all();
        foreach ($locales as $key => $value) {
            $this->response['locales'][$key]['language_code'] = $value->language_code;
            $this->response['locales'][$key]['language'] = $value->language;
            $this->response['locales'][$key]['path'] = $value->path;
            $http =  env('REDIRECT_HTTPS')?'https://':'http://';
            $this->response['locales'][$key]['url'] = $http. $value->url . request()->getPathInfo();
        }
        return $this->response;
    }

    public function getAllSlogan()
    {
        $slogans =  Slogan::with('translations')->get()->toArray();
        $slogans =  array_column($slogans,'title','type');
        return $slogans;
    }

    public function getAllBanner($area)
    {
        $area = $this->normalizeBannerArea((string)$area);
        return Banner::query()
            ->with(['translations'])
            ->orderByDesc('sort')
            ->where('area', $area)
            ->get();
    }

    public function getOneBanner($area)
    {
        $area = $this->normalizeBannerArea((string)$area);
        return Banner::query()
            ->with(['translations'])
            ->orderByDesc('sort')
            ->where('area', $area)
            ->first();
    }

    public function getAllVariable()
    {
        return Variable::with(['translations'])->orderByDesc('sort')->get();
    }

    public function getSlogan($type)
    {
        $slogan = Slogan::with(['translations'])->where('type', $type)->first();
        if ($slogan) {
            return $slogan->title;
        } else {
            return '';
        }
    }
}
