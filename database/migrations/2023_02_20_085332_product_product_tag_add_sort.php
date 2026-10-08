<?php

use App\Modules\Admin\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Modules\Inquiry\Models\Inquiry;
use Illuminate\Support\Facades\Log;
class ProductProductTagAddSort extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_product_tag',function (Blueprint $table){
            $table->unsignedInteger('sort')->default(0)->comment('排序，数字越大越靠前');
        });

        Schema::table('inquiries',function (Blueprint $table){
            $table->string('send_emails')->nullable()->comment('已发送邮箱');
        });

        if (Schema::hasTable('inquiry_user')){
            try {
                $inquiries = Inquiry::query()->with(['users'])->get();
                foreach ($inquiries as $inquiry) {
                    $send_emails = [];
                    foreach ($inquiry->users as $inquiry_user){
                        if (!in_array($inquiry_user->id,User::ALLOW_ADMIN_ID)){
                            $send_emails[] = $inquiry_user->email;
                        }
                    }
                    if (app('settings')['setting']->contract_email) {
                        $send_emails = array_merge($send_emails, explode(',', app('settings')['setting']->contract_email));
                    }
                    if ($send_emails) {
                        $inquiry->send_emails = implode(',', $send_emails);
                        $inquiry->save();
                    }
                }
            }catch (Exception $exception){
                Log::info('询盘收件人同步失败，原因为:'.$exception->getMessage());
            }

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('product_product_tag',['sort']);
        Schema::dropColumns('inquiries',['send_emails']);
    }
}
