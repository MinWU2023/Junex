<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->comment('网站logo');
            $table->string('ico')->comment('网站ico');
            $table->string('company_address')->nullable()->comment("公司地址");
            $table->string('company_brief')->nullable()->comment("公司简介");
            $table->string('whatsapp')->nullable()->comment("whatsapp");
            $table->string('contract_mobile')->nullable()->comment('联系电话');
            $table->string('contract_email')->nullable()->comment('联系邮箱');
            $table->string('facebook')->nullable()->comment('facebook');
            $table->string('twitter')->nullable()->comment('twitter');
            $table->string('skype')->nullable()->comment('skype');
            $table->boolean('chat_status')->default(0)->comment('chat 是否开启');
            $table->string('chat_token')->nullable()->comment('chat token');
            $table->text('head_code')->nullable()->comment('网站跟踪代码');
            $table->boolean('is_cache')->default(0)->comment('是否开启缓存');
            $table->unsignedInteger('cache_ttl')->default(60)->comment('缓存时长');
            $table->string('template_path')->nullable()->comment('模板路径');
            $table->string('website_id')->default(0)->comment('网站id');
            $table->integer('category_product_num')->comment("分类下产品显示个数")->default(12);
            $table->integer('product_list_num')->comment("产品列表显示个数")->default(12);
            $table->integer('article_list_num')->comment("文章列表显示个数")->default(12);
            $table->integer('blog_list_num')->comment("博客列表显示个数")->default(12);
            $table->integer('project_case_list_num')->comment("Project Case列表显示个数")->default(12);
            $table->integer('faq_list_num')->comment("Faq列表显示个数")->default(8);
            $table->integer('product_search_list_num')->comment("产品搜索页显示个数")->default(12);
            $table->integer('related_product_num')->comment("相关产品显示个数")->default(12);
            $table->integer('related_article_num')->comment("相关文章显示个数")->default(12);
            $table->integer('sidebar_product_category_num')->comment("侧边栏产品分类显示个数")->default(8);
            $table->integer('sidebar_new_product_num')->comment("侧边栏最新产品显示个数")->default(8);
            $table->integer('sidebar_blog_category_num')->comment("侧边栏博客分类显示个数")->default(8);
            $table->integer('sidebar_blog_num')->comment("侧边栏博客显示个数")->default(8);
            $table->integer('sidebar_blog_tag_num')->comment("侧边栏博客关键词个数")->default(8);
            $table->integer('header_menu_product_category_num')->comment("导航栏产品分类显示个数")->default(8);
            $table->integer('hot_product_list_num')->comment("hot产品数量")->default(12);
            $table->integer('recommend_product_num')->comment("推荐产品数")->default(8);
            $table->integer('product_tag_num')->comment("产品关键词数")->default(8);
            $table->integer('link_num')->comment("友情链接显示个数")->default(8);
            $table->text('sensitive_words')->nullable()->comment("敏感词");
            $table->text('banner_areas')->nullable()->comment("banner位置");
            $table->text('attribute_categories')->nullable()->comment("属性分类");
            $table->string('mail_mailer')->nullable()->comment('邮件驱动');
            $table->string('mail_host')->nullable()->comment('host');
            $table->string('mail_port')->nullable()->comment('端口号');
            $table->string('mail_username')->nullable()->comment('账户');
            $table->string('mail_password')->nullable()->comment('密码');
            $table->string('mail_encryption')->nullable()->comment('加密方式');
            $table->string('mail_from_address')->nullable()->comment('默认发件人地址');
            $table->string('mail_from_name')->nullable()->comment('默认发件人');
            $table->string('mail_addressee')->nullable()->comment('询盘收件人');
            $table->string('version')->nullable()->comment('版本号');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
