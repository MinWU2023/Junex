<?php

namespace App\Modules\Setting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name', 'title', 'keywords', 'description',
        'seo_product_title', 'seo_product_description', 'seo_product_keywords',
        'seo_products_title', 'seo_products_description', 'seo_products_keywords',
        'seo_product_category_title', 'seo_product_category_description', 'seo_product_category_keywords',
        'seo_product_category_bottom_title', 'seo_product_category_bottom_description', 'seo_product_category_bottom_keywords',
        'seo_product_tag_title', 'seo_product_tag_description', 'seo_product_tag_keywords',
        'seo_blogs_title','seo_blogs_description', 'seo_blogs_keywords',
        'seo_blog_title','seo_blog_description', 'seo_blog_keywords',
        'seo_blog_category_title','seo_blog_category_description','seo_blog_category_keywords',
        'seo_blog_tag_title','seo_blog_tag_description','seo_blog_tag_keywords',
        'seo_articles_title','seo_articles_description', 'seo_articles_keywords',
        'seo_article_title','seo_article_description', 'seo_article_keywords',
        'seo_article_category_title','seo_article_category_description','seo_article_category_keywords',
        'seo_sitemap_title','seo_sitemap_description','seo_sitemap_keywords','product_alt_template',
        'seo_home_title','seo_home_description','seo_home_keywords',
        'search_placeholder','search_hot_keywords'
    ];
}
