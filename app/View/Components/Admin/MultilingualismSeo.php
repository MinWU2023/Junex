<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class MultilingualismSeo extends Component
{
    private $locales;
    private $tips;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->locales = config('translatable.locales');
        $this->tips = config('tips');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if(!auth()->user()->hasRole('超级管理员') && !app('settings')['setting']->all_locale_active){
            $this->locales = [config('app.locale')];
        }
        $locales = is_iterable($this->locales) ? $this->locales : [];
        $tips = is_iterable($this->tips) ? $this->tips : [];
        $theTranslateField = [];
        if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->setting_seo_show){
            $theTranslateField = array_merge($theTranslateField,config('seo.home'));
        }
        if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->product_list_seo_show){
            $theTranslateField = array_merge($theTranslateField,config('seo.product_list'));
        }

        if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->product_category_seo_show){
            $theTranslateField = array_merge($theTranslateField,config('seo.product_category'));
        }

        if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->product_detail_seo_show){
            $theTranslateField = array_merge($theTranslateField,config('seo.product'));
        }

        if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->product_tag_seo_show){
            $theTranslateField = array_merge($theTranslateField,config('seo.product_tag'));
        }

//        if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->article_list_seo_show){
//            $theTranslateField = array_merge($theTranslateField,config('seo.article_list'));
//        }

        if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->article_category_seo_show){
            $theTranslateField = array_merge($theTranslateField,config('seo.article_category'));
        }

        if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->article_detail_seo_show){
            $theTranslateField = array_merge($theTranslateField,config('seo.article'));
        }

        if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->blog_list_seo_show){
            $theTranslateField = array_merge($theTranslateField,config('seo.blog_list'));
        }

        if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->blog_category_seo_show){
            $theTranslateField = array_merge($theTranslateField,config('seo.blog_category'));
        }

        if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->blog_detail_seo_show){
            $theTranslateField = array_merge($theTranslateField,config('seo.blog'));
        }

        if (auth()->user()->hasRole('超级管理员') || app('settings')['setting']->blog_tag_seo_show){
            $theTranslateField = array_merge($theTranslateField,config('seo.blog_tag'));
        }

        if (auth()->user()->hasRole('超级管理员')){
            $theTranslateField = array_merge($theTranslateField,config('seo.sitemap'));
        }

        foreach ($theTranslateField as $key => $value) {
            foreach ($tips as $k => $v) {
                $tip = $v['tip'];
                unset($v['tip']);
                if ($value === $v) {
                    $theTranslateField[$key]['tip'] = $tip;
                }
            }
        }
        return view('components.admin.multilingualism',
            [
                'theTranslateField' => $theTranslateField,
                'theValue' => app('settings')['setting'],
                'theLocales' => $locales
            ]
        );
    }
}
