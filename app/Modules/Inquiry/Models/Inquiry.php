<?php

namespace App\Modules\Inquiry\Models;

use App\Modules\Admin\Models\User;
use App\Models\InquiryProduct;
use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'content', 'email', 'tel', 'ip', 'location', 'source_url',
        'client','add_date','is_read','msg_name','msg_company','msg_country','msg_country1','send_emails',
         'source_data','is_send','is_unlock','gibberish_score','gibberish_details'
    ];

    public function inquiryRemark()
    {
        return $this->hasMany(InquiryRemark::class)->latest();
    }

    public function inquiryProducts()
    {
        return $this->hasMany(InquiryProduct::class, 'inquiry_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'inquiry_products', 'inquiry_id', 'product_id')
            ->withPivot(['quantity'])
            ->withTimestamps();
    }

    public function attachments()
    {
        return $this->hasMany(InquiryAttachment::class)->orderBy('id');
    }

    public function getCreatedAtAttribute($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function getContentAttribute($value){
        return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }


    public function reads(){
        return $this->hasMany(InquiryUserRead::class);
    }

    /**
     * 获取垃圾检测详情
     *
     * @param string $value
     * @return array
     */
    public function getGibberishDetailsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * 设置垃圾检测详情
     *
     * @param array $value
     * @return void
     */
    public function setGibberishDetailsAttribute($value)
    {
        $this->attributes['gibberish_details'] = json_encode($value);
    }

}
