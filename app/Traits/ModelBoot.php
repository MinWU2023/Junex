<?php

namespace App\Traits;

use App\Modules\Setting\Models\Locale;
use App\Modules\Translate\Models\TranslateJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait ModelBoot
{

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function ($model) {
            if (request()->get('is_translate')) {
                //保存翻译记录
                $translate_content = [];
                foreach ($model->translatedAttributes as $translatedAttribute) {
                    if ($model->$translatedAttribute){ //空值不推送
                        $translate_content[$translatedAttribute] = $model->$translatedAttribute;
                    }
                }
                $request_url = trim(config("cloud_api") ?? env('MIX_API_CLOUD'), '/') . '/api/customerWebsite/translateOne';
                $translateFields = [];
                foreach (config('multilingual.' . self::MODEL_TYPE . '.value') as $translateField) {
                    $translateFields = array_merge($translateField, $translateFields);
                }
                $status = 2;
                $error_msg = '';
                try {
                    $res = Http::withHeaders(['token' => app()['settings']['setting']->website_token])->withoutVerifying()->post($request_url, [
                        'source_id' => $model->id,
                        'translate_locales' => ['en'],
                        'content' => $translate_content,
                        'model_type' => self::MODEL_TYPE,
                        'translateFields' => $translateFields
                    ]);
                    if ($res->ok()) {
                        $status = 0;
                    }
                } catch (\Exception $exception) {
                    $error_msg = '推送异常:' . $exception->getMessage();
                }
                foreach ($model->translatedAttributes as $translatedAttribute) {
                    if ($model->$translatedAttribute){
                        TranslateJob::query()->updateOrInsert([
                            'source_id' => $model->id,
                            'model' => self::class,
                            'field' => $translatedAttribute,
                        ], [
                            'default_locale' => 'en',
                            'translate_locales' => 'en',
                            'content' => $model->$translatedAttribute,
                            'status' => $status,
                            'created_at' => now()->toDateTime(),
                            'updated_at' => now()->toDateTime(),
                            'model_type' => self::MODEL_TYPE,
                            'error_msg' => $error_msg
                        ]);
                    }

                }
                //推送翻译
            }
        });
    }

}
