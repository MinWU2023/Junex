<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Multilingualism extends Component
{
    public $translateField;
    public $value;
    protected $locales;
    protected $tips;
    protected $uploadType;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($translateField, $value = null,$uploadType="system")
    {
        $this->locales = config('translatable.locales');
        $this->tips = config('tips');
        $this->translateField = $translateField;
        $this->value = $value;
        $this->uploadType = $uploadType;
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
        $translateField = is_iterable($this->translateField) ? $this->translateField : [];
        $tips = is_iterable($this->tips) ? $this->tips : [];
        foreach ($translateField as $key => $value) {
            foreach ($tips as $k => $v) {
                $tip = $v['tip'];
                unset($v['tip']);
                if ($value === $v) {
                    $this->translateField[$key]['tip'] = $tip;
                }
            }
        }
        return view('components.admin.multilingualism',
            [
                'theTranslateField' => $translateField,
                'theValue' => $this->value,
                'theLocales' => $locales,
                'uploadType' => $this->uploadType
            ]
        );
    }
}
