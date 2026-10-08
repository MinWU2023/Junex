<?php

namespace App\Console\Commands\Test;

use App\Modules\Url\Models\Url;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class UrlRedirectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:redirect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected static function newUrl(&$new_url, $model, $id)
    {
        $repeat = Url::withTrashed()->where([
            'url' => $new_url,
        ])
            ->where('urlable_id', '<>', $id)
            ->where('urlable_type','<>', $model)
            ->first();
        if ($repeat) {
            $new_url = $new_url . '-' . rand(1, 1000);
            self::newUrl($new_url, $model, $id);
        }
    }

    public function handle()
    {
        if ($this->confirm('确定重新生成新url,将老链接301吗？')){
            $url_data = Url::groupBy('urlable_type')->get()->toArray();
            $models = array_column($url_data, 'urlable_type');
            $count = 0;
            foreach ($models as $model) {
                $data = new $model;
                if (method_exists($data,'scopeActive')){
                    $this->info($model);
                    $data->active()->chunk(200, function ($data) use ($model, &$count) {
                        foreach ($data as $datum) {
                            try {
                                if (!strstr($datum->url_key, '/')) {
                                    $new_url = Str::slug($datum->name, '-', config('app.locale'));
                                    $is_trash = Url::onlyTrashed()->where([
                                        'url' => $new_url,
                                    ])->first();
                                    if($is_trash){
                                        $is_trash->forceDelete();
                                        $datum->url_key = $new_url;
                                        $datum->updated_at = date('Y-m-d H:i:s');
                                        $datum->save();
                                        $count++;
                                    }else{
                                        $repeat = Url::where([
                                            'url' => $new_url,
                                            'urlable_id' =>$datum->id,
                                            'urlable_type' => $model
                                        ])->first();
                                        if (!$repeat){
                                            self::newUrl($new_url,$model, $datum->id);
                                            if ($new_url != $datum->url_key) {
                                                $datum->url_key = $new_url;
                                                $datum->updated_at = date('Y-m-d H:i:s');
                                                $datum->save();
                                                $count++;
                                            }
                                        }
                                    }
                                }
                            } catch (\Exception $exception) {
                                $this->warn('数据ID:' . $datum->id . ',数据model:' . $model . ',新url:' . $new_url);
                                $this->warn('url生成异常，请联系技术查看');
                            }
                        }
                    });
                }else{
                    $data->chunk(200, function ($data) use ($model, &$count) {
                        foreach ($data as $datum) {
                            try {
                                if (!strstr($datum->url_key, '/')) {
                                    $new_url = Str::slug($datum->name, '-', config('app.locale'));
                                    $is_trash = Url::onlyTrashed()->where([
                                        'url' => $new_url,
                                    ])->first();
                                    if($is_trash){
                                        $is_trash->forceDelete();
                                        $datum->url_key = $new_url;
                                        $datum->updated_at = date('Y-m-d H:i:s');
                                        $datum->save();
                                        $count++;
                                    }else{
                                        $repeat = Url::where([
                                            'url' => $new_url,
                                            'urlable_id' =>$datum->id,
                                            'urlable_type' => $model
                                        ])->first();
                                        if (!$repeat){
                                            self::newUrl($new_url, $model, $datum->id);
                                            if ($new_url != $datum->url_key) {
                                                $datum->url_key = $new_url;
                                                $datum->updated_at = date('Y-m-d H:i:s');
                                                $datum->save();
                                                $count++;
                                            }
                                        }
                                    }
                                }
                            } catch (\Exception $exception) {
                                $this->warn('数据ID:' . $datum->id . ',数据model:' . $model . ',新url:' . $new_url);
                                $this->warn('url生成异常，请联系技术查看');
                            }
                        }
                    });
                }
            }
            $this->info('全站url生成成功,新增301数量:' . $count);
        }else{
            $this->info('已取消');
        }
    }


}
