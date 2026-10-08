<?php
namespace App\Observers;

use App\Modules\Admin\Models\User;
use App\Modules\Inquiry\Models\Inquiry;
use App\Repeats\Models\Product;
use DfaFilter\SensitiveHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
class InquiryObserver
{
    /**
     *
     * 模型保存前事件
     * @param Inquiry $inquiry
     * @return false|void
     * @throws \DfaFilter\Exceptions\PdsBusinessException
     * @throws \DfaFilter\Exceptions\PdsSystemException
     */
    public function creating(Inquiry $inquiry){
        $wordData = config('sensitiveWord');
        $sensitive_words = app('settings')['setting']->sensitive_words;
        if (!app()->runningInConsole()){
            $ip = GetUserIP();
            $ban_ips = app('settings')['setting']->ban_ips;
            if ($ban_ips){
                $ban_ips = json_decode($ban_ips);
            }
            if ($ban_ips){
                foreach ($ban_ips as $ban_ip){
                    if ($ban_ip == $ip){
                        return false;
                    }
                }
            }
            $ban_emails = app('settings')['setting']->ban_emails;
            if ($ban_emails){
                $ban_emails = json_decode($ban_emails,true);
            }
            if ($ban_emails){
                if (in_array_i($inquiry->email,$ban_emails)){
                    return false;
                }
            }
        }
        if ($sensitive_words){
            $wordData = array_merge(json_decode($sensitive_words),$wordData);
        }
        $handle = SensitiveHelper::init()->setTree($wordData);
        $title_islegal = $handle->islegal(strtolower($inquiry->title));
        $content_islegal = $handle->islegal(strtolower($inquiry->content));
        if ($title_islegal  || $content_islegal){
            return false;
        }
        if(app('settings')['setting']->website_id && $inquiry->gibberish_score < app('settings')['setting']->gibberish_threshold){
            Http::post('https://api.crm.dyyseo.com/api/inquiry',[
                'token' => app('settings')['setting']->website_id,
                'content' => $inquiry->title,
            ]);
        }
    }


    /**
     * 保存后触发
     * Handle the Inquiry "created" event.
     *
     * @param \App\Inquiry $inquiry
     * @return void
     */
    public function created(Inquiry $inquiry)
    {
        $allow_ids = User::ALLOW_ADMIN_ID;
        $productIds = $inquiry->inquiryProducts()->pluck('product_id')->all();
        if (!empty($productIds)) {
            $adminUserIds = Product::query()
                ->whereIn('id', $productIds)
                ->pluck('admin_user_id')
                ->filter()
                ->all();
            if (!empty($adminUserIds)) {
                $allow_ids = array_merge($allow_ids, $adminUserIds);
            }
        }
        // Filter out non-existent user ids before syncing
        $allow_ids = array_filter($allow_ids, function ($id) {
            return !is_null($id) && $id !== '';
        });
        $valid_ids = User::query()->whereIn('id', $allow_ids)->pluck('id')->all();
        $inquiry->users()->sync(array_unique($valid_ids));
    }

    /**
     * Handle the Inquiry "updated" event.
     *
     * @param \App\Inquiry $inquiry
     * @return void
     */
    public function updated(Inquiry $inquiry)
    {
        //
    }

    /**
     * Handle the Inquiry "deleted" event.
     *
     * @param \App\Inquiry $inquiry
     * @return void
     */
    public function deleted(Inquiry $inquiry)
    {

    }

    /**
     * Handle the Inquiry "restored" event.
     *
     * @param \App\Inquiry $inquiry
     * @return void
     */
    public function restored(Inquiry $inquiry)
    {

    }

    /**
     * Handle the Inquiry "force deleted" event.
     *
     * @param \App\Inquiry $inquiry
     * @return void
     */
    public function forceDeleted(Inquiry $inquiry)
    {

    }
}
