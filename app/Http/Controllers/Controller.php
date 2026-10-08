<?php

namespace App\Http\Controllers;

use App\Services\SettingService;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResponseTrait;

    protected function getBannersByArea(string $area)
    {
        return app(SettingService::class)->getAllBanner($area);
    }

    protected function buildBreadcrumbs(array $items): array
    {
        return array_values(array_filter(array_map(function ($item) {
            if (!is_array($item)) {
                return null;
            }
            $label = trim((string)($item['label'] ?? ''));
            if ($label === '') {
                return null;
            }
            $url = $item['url'] ?? null;
            $url = $url !== null && $url !== '' ? (string)$url : null;

            return [
                'label' => $label,
                'url' => $url,
            ];
        }, $items)));
    }

    protected function fillDefaultTdk(array $tdk, $setting): array
    {
        $title = $tdk['title'] ?? null;
        $keywords = $tdk['keywords'] ?? null;
        $description = $tdk['description'] ?? null;

        return [
            'title' => $title !== null && $title !== '' ? $title : ($setting->title ?? ''),
            'keywords' => $keywords !== null && $keywords !== '' ? $keywords : ($setting->keywords ?? ''),
            'description' => $description !== null && $description !== '' ? $description : ($setting->description ?? ''),
        ];
    }

    protected function buildStaticPageTdk(string $pageName, $setting): array
    {
        $siteName = $setting->name ?? '';
        return [
            'title' => $pageName . ' - ' . $siteName,
            'keywords' => $pageName . ', ' . $siteName,
            'description' => $pageName . ', ' . $siteName,
        ];
    }

    /**
     * Resolve TDK from CMS single page by matching request path to pages.url_key.
     * Path is domain-stripped (e.g. http://host/about-us => about-us; / => home).
     * When matched, CMS page SEO takes priority; otherwise uses $fallbackTdk then site defaults.
     *
     * @param  array{title?:string,keywords?:string,description?:string}|null  $fallbackTdk
     */
    protected function resolveCmsPageTdkByPath($setting = null, ?string $path = null, ?array $fallbackTdk = null): array
    {
        $setting = $setting ?? app('settings')['setting'];
        $cmsTdk = page_tdk_by_path($path);

        if (is_array($cmsTdk)) {
            return $this->fillDefaultTdk($cmsTdk, $setting);
        }

        return $this->fillDefaultTdk($fallbackTdk ?? [], $setting);
    }

    /**
     * Resolve Schema.org HTML from CMS page matched by url_key / path.
     */
    protected function resolveCmsPageSchemaHtmlByPath(?string $path = null): string
    {
        return page_schema_org_html($path);
    }

    protected function getCustomerByIp(string $ip)
    {
        if (!$ip) {
            return null;
        }
        return \App\Modules\User\Models\Customer::query()
            ->where('ip', $ip)
            ->orderByDesc('id')
            ->first();
    }
}
