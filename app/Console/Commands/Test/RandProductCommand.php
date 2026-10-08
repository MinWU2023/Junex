<?php

namespace App\Console\Commands\Test;

use App\Modules\Article\Models\Article;
use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Product\Models\Product;
use App\Modules\SiteCount\Models\SiteCount;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RandProductCommand extends Command
{
    /**
     * The name and signature of the console command.123
     *
     * @var string
     */
    protected $signature = 'rand:product';

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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $produceModel = new Product();
        $this->randModel($produceModel);
        $inquiriesModel = new Inquiry();
        $this->randModel($inquiriesModel);
        $articleModel = new Article();
        $this->randModel($articleModel);

        $siteModel = new SiteCount();
        $this->randModel($siteModel);

        dd('success');
    }

    public function randModel($model)
    {
        $data = $model->all()->toArray();
        $count = count($data);
        $rands = [];
        for ($i=0;$i<6;$i++){
            if ($i<5){
                $num = mt_rand(0,ceil($count/2));
                $rands[] = $num;
                $count = $count-$num;
            }else{
                $rands[] = $count;
            }
        }
        $ks = 0;
        $aa = [];
        foreach ($rands as $k=>$rand){
            $products = $model->whereBetween('id',[$ks+1,$ks+$rand])->get()->toArray();
            $ids = array_column($products,'id');
            $model->whereIn('id',$ids)->update(['add_date'=>'20210'.($k+1),'created_at'=>'2021-0'.($k+1).'-25 11:19:52']);
            $ks += $rand;
            $aa[] = count($products);
        }


    }

}
