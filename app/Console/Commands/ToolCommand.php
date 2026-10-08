<?php

namespace App\Console\Commands;

use App\Modules\Product\Models\ProductTag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ToolCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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

    /**
     * 去除重复的产品关键词
     * @return void
     */
    protected function de_dp(){
        $product_tags = DB::table('product_tag_translations')->where(['locale' => 'en'])->groupBy('name')->get()->toArray();
        foreach ($product_tags as $product_tag) {
            $repeats = ProductTag::whereTranslation('name', $product_tag->name)->get();
            if (count($repeats) > 1) {
                //可以去重的关键词
                $repeat_tag_ids = array_column($repeats->toArray(), 'id');
                $first_id = $repeat_tag_ids[0];
                unset($repeat_tag_ids[0]);
                foreach ($repeat_tag_ids as $repeat_tag_id) {
                    DB::table('product_product_tag')->where([
                        'product_tag_id' => $repeat_tag_id
                    ])->update([
                        'product_tag_id' => $first_id
                    ]);
                }
                ProductTag::query()->whereIn('id', $repeat_tag_ids)->delete();
            }
        }
        $this->info('产品关键词去重成功');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
