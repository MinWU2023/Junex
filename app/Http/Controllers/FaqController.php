<?php

namespace App\Http\Controllers;

use App\Modules\User\Models\Faq;
use App\Modules\User\Models\FaqGroup;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $injectToView = (bool)$request->get('inject', true);

        $pageBanner = $this->getBannersByArea('Faqs');

        $groups = FaqGroup::query()
            ->with([
                'translations',
                'faqs.translations',
            ])
            ->orderByDesc('id')
            ->get();

        $faqGroupsData = $groups->map(function (FaqGroup $g) {
            $name = (string)($g->name ?? '');
            $first = '';
            $rest = '';
            if ($name !== '') {
                $first = mb_substr($name, 0, 1);
                $rest = mb_substr($name, 1);
            }

            $faqs = $g->faqs
                ? $g->faqs
                    ->sortByDesc(static fn (Faq $faq) => sprintf('%010d-%010d', (int)$faq->sort, (int)$faq->id))
                    ->values()
                    ->map(function (Faq $faq) {
                        return [
                            'id' => (int)$faq->id,
                            'subject' => (string)($faq->subject ?? ''),
                            'content' => (string)($faq->content ?? ''),
                            'sort' => (int)($faq->sort ?? 0),
                        ];
                    })->values()->toArray()
                : [];

            return [
                'id' => (int)$g->id,
                'name' => $name,
                'name_first' => $first,
                'name_rest' => $rest,
                'content' => (string)($g->content ?? ''),
                'faqs' => $faqs,
            ];
        })->values()->toArray();

        $setting = app('settings')['setting'];
        $tdk = $this->resolveCmsPageTdkByPath($setting, 'faqs');

        $data = [
            'faqGroupsData' => $faqGroupsData,
            'pageBanner' => $pageBanner,
            'breadcrumbs' => $this->buildBreadcrumbs([
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Faqs', 'url' => null],
            ]),
            'injectToView' => $injectToView,
            'tdk' => $tdk,
        ];

        if (!$injectToView) {
            return response()->json($data);
        }

        return view('front.faqs', $data);
    }
}
