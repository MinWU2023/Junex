<?php
$seoTranslateField = [
    [
        'name' => 'title',
        'label' => 'meta title',
        'type' => 'text',
        'require' => false
    ],
    [
        'name' => 'keywords',
        'label' => 'meta keywords',
        'type' => 'text',
        'require' => false
    ],
    [
        'name' => 'description',
        'label' => 'meta description',
        'type' => 'text',
        'require' => false
    ]
];
return [
    'setting' => [
        'label' => '系统设置',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '网站名称',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'search_placeholder',
                    'label' => '搜索提示词',
                    'type' => 'text',
                    'require' => false
                ],
                [
                    'name' => 'search_hot_keywords',
                    'label' => '搜索热门关键词(逗号隔开)',
                    'type' => 'text',
                    'require' => false
                ]
            ],
            'seoTranslateField' => $seoTranslateField,
            'seoTemplateTranslateField' =>
                [
                    [
                        'name' => 'seo_product_title',
                        'label' => '产品详情标题模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_product_description',
                        'label' => '产品详情描述模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_product_keywords',
                        'label' => '产品详情关键词模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_products_title',
                        'label' => '产品列表标题模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_products_description',
                        'label' => '产品列表描述模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_products_keywords',
                        'label' => '产品列表关键词模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_product_category_title',
                        'label' => '产品分类标题模板 6201当前分类名称 6202上级分类 6203下级分类',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_product_category_description',
                        'label' => '产品分类描述模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_product_category_keywords',
                        'label' => '产品分类关键词模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_product_tag_title',
                        'label' => '产品TAG标题模板 7201 tag名称',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_product_tag_description',
                        'label' => '产品TAG描述模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_product_tag_keywords',
                        'label' => '产品TAG关键词模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_articles_title',
                        'label' => '新闻列表标题模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_articles_description',
                        'label' => '新闻列表描述模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_articles_keywords',
                        'label' => '新闻列表关键词模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_article_category_title',
                        'label' => '新闻分类标题模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_article_category_description',
                        'label' => '新闻分类描述模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_article_category_keywords',
                        'label' => '新闻分类关键词模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_article_title',
                        'label' => '新闻标题模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_article_description',
                        'label' => '新闻详情模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_article_keywords',
                        'label' => '新闻关键词模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_blogs_title',
                        'label' => '博客列表标题模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_blogs_description',
                        'label' => '博客列表描述模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_blogs_keywords',
                        'label' => '博客列表关键词模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_videos_title',
                        'label' => '视频列表标题模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_videos_description',
                        'label' => '视频列表描述模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_videos_keywords',
                        'label' => '视频列表关键词模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_blog_category_title',
                        'label' => '博客分类标题模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_blog_category_description',
                        'label' => '博客分类描述模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_blog_category_keywords',
                        'label' => '博客分类关键词模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_blog_title',
                        'label' => '博客标题模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_blog_description',
                        'label' => '博客描述模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_blog_keywords',
                        'label' => '博客关键词模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_blog_tag_title',
                        'label' => '博客TAG标题模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_blog_tag_description',
                        'label' => '博客TAG描述模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_blog_tag_keywords',
                        'label' => '博客TAG关键词模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_sitemap_title',
                        'label' => 'sitemap标题模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_sitemap_description',
                        'label' => 'sitemap描述模板',
                        'type' => 'text',
                        'require' => false
                    ],
                    [
                        'name' => 'seo_sitemap_keywords',
                        'label' => 'sitemap关键词模板',
                        'type' => 'text',
                        'require' => false
                    ],
                ]
        ],
        'model' => \App\Modules\Setting\Models\Setting::class
    ],
    'product_category' => [
        'label' => '产品分类',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '分类名',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'content',
                    'label' => '分类描述',
                    'type' => 'uedit',
                    'require' => true
                ],
                [
                    'name' => 'content2',
                    'label' => '分类描述2',
                    'type' => 'uedit',
                    'require' => false
                ],
                [
                    'name' => 'page_block',
                    'label' => '分类页板块',
                    'type' => 'uedit',
                    'require' => false
                ],
            ],
            'seoTranslateField' => $seoTranslateField,
        ],
        'model' => \App\Modules\Product\Models\ProductCategory::class
    ],
    'product' => [
        'label' => '产品列表',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '产品名',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'brief_content',
                    'label' => '产品简介',
                    'type' => 'uedit',
                    'require' => false
                ],
                [
                    'name' => 'content',
                    'label' => '产品详情',
                    'type' => 'uedit',
                    'require' => true
                ],
                [
                    'name' => 'm_content',
                    'label' => '产品详情(手机端)',
                    'type' => 'uedit',
                    'require' => false,
                    'hidden' => true,
                ],
                [
                    'name' => 'product_details',
                    'label' => 'Product Details',
                    'type' => 'uedit',
                    'require' => false
                ]
            ],
            'seoTranslateField' => $seoTranslateField,
        ],
        'model' => \App\Modules\Product\Models\Product::class
    ],
    'product_tag' => [
        'label' => '产品关键词',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '关键词名称',
                    'type' => 'text',
                    'require' => true
                ],
            ]
        ],
        'model' => \App\Modules\Product\Models\ProductTag::class
    ],
    'product_attribute' => [
        'label' => '产品属性',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '属性名称',
                    'type' => 'text',
                    'require' => true
                ],
            ]
        ],
        'model' => \App\Modules\Product\Models\ProductAttribute::class
    ],
    'page' => [
        'label' => '单页面',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '页面名称',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'brief_content',
                    'label' => '页面内容简介',
                    'type' => 'uedit',
                    'require' => true
                ],
                [
                    'name' => 'content',
                    'label' => '页面内容',
                    'type' => 'uedit',
                    'require' => true
                ],
            ],
            'seoTranslateField' => $seoTranslateField,
        ],
        'model' => \App\Modules\Page\Models\Page::class
    ],
    'staticBlock' => [
        'label' => '静态块',
        'value' => [
            'translateField' => [
                [
                    'name' => 'title',
                    'label' => '标题',
                    'type' => 'text',
                    'require' => false
                ],
                [
                    'name' => 'content',
                    'label' => '内容',
                    'type' => 'uedit',
                    'require' => false
                ],
            ],
        ],
        'model' => \App\Modules\Page\Models\StaticBlock::class
    ],
    'article_category' => [
        'label' => '文章分类',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '分类名',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'content',
                    'label' => '分类描述',
                    'type' => 'uedit',
                    'require' => true
                ],
            ],
            'seoTranslateField' => $seoTranslateField
        ],
        'model' => \App\Modules\Article\Models\ArticleCategory::class
    ],
    'article' => [
        'label' => '文章列表',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '文章标题',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'content',
                    'label' => '文章内容',
                    'type' => 'uedit',
                    'require' => true
                ],
            ],
            'seoTranslateField' => $seoTranslateField
        ],
        'model' => \App\Modules\Article\Models\Article::class
    ],
    'blog_category' => [
        'label' => '博客分类',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '分类名',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'content',
                    'label' => '分类描述',
                    'type' => 'uedit',
                    'require' => true
                ],
            ],
            'seoTranslateField' => $seoTranslateField
        ],
        'model' => \App\Modules\Blog\Models\BlogCategory::class
    ],
    'blog' => [
        'label' => '博客列表',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '博客标题',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'content',
                    'label' => '博客内容',
                    'type' => 'uedit',
                    'require' => true
                ],
            ],
            'seoTranslateField' => $seoTranslateField
        ],
        'model' => \App\Modules\Blog\Models\Blog::class
    ],
    'blog_tag' => [
        'label' => '博客关键词列表',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '博客关键词',
                    'type' => 'text',
                    'require' => true
                ],
            ],
        ],
        'model' => \App\Modules\Blog\Models\BlogTag::class
    ],
    'slogan' =>[
        'label' => 'slogan列表',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => 'slogan',
                    'type' => 'text',
                    'require' => true
                ],
            ],
        ],
        'model' => \App\Modules\Setting\Models\Slogan::class
    ],
    'productVideo' => [
        'label' => '产品视频管理',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '名称',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'content',
                    'label' => '简介',
                    'type' => 'uedit',
                    'require' => false
                ],
                [
                    'name' => 'content2',
                    'label' => '详情',
                    'type' => 'uedit',
                    'require' => false
                ],
            ],
            'seoTranslateField' => $seoTranslateField,
        ],
        'model' => \App\Modules\Product\Models\ProductVideo::class
    ],
    'productVideoCategory' => [
        'label' => '产品视频分类',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '分类名',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'content',
                    'label' => '简介',
                    'type' => 'uedit',
                    'require' => false
                ],
                [
                    'name' => 'content2',
                    'label' => '详情',
                    'type' => 'uedit',
                    'require' => false
                ],
            ],
            'seoTranslateField' => $seoTranslateField,
        ],
        'model' => \App\Modules\Product\Models\ProductVideoCategory::class
    ],
    'faq' => [
        'label' => 'Faqs管理',
        'value' => [
            'translateField' => [
                [
                    'name' => 'subject',
                    'label' => '问题',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'content',
                    'label' => '答案',
                    'type' => 'uedit',
                    'require' => true
                ],
            ],
        ],
        'model' => \App\Modules\User\Models\Faq::class
    ],

    'productFaq' => [
        'label' => '产品问答',
        'value' => [
            'translateField' => [
                [
                    'name' => 'subject',
                    'label' => '问题',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'content',
                    'label' => '答案',
                    'type' => 'uedit',
                    'require' => true
                ],
            ],
        ],
        'model' => \App\Modules\Product\Models\ProductFaq::class
    ],

    'faqGroup' => [
        'label' => 'Faqs分组管理',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '名称',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'content',
                    'label' => '描述',
                    'type' => 'uedit',
                    'require' => false
                ],
            ],
        ],
        'model' => \App\Modules\User\Models\FaqGroup::class
    ],
    'customerReview' => [
        'label' => '评论管理',
        'value' => [
            'translateField' => [
                [
                    'name' => 'subject',
                    'label' => '主题',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'content',
                    'label' => '内容',
                    'type' => 'uedit',
                    'require' => true
                ],
            ],
        ],
        'model' => \App\Modules\User\Models\CustomerReview::class
    ],

    'banner' =>[
        'label' => 'banner列表',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '标题',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'description',
                    'label' => '描述',
                    'type' => 'text',
                    'require' => false
                ],
                [
                    'name' => 'button_text',
                    'label' => '按钮文案',
                    'type' => 'text',
                    'require' => false
                ],
            ],
        ],
        'model' => \App\Modules\Setting\Models\Banner::class
    ],
    'download' =>[
        'label' => '下载列表',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '分类名',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'content',
                    'label' => '分类描述',
                    'type' => 'text',
                    'require' => true
                ],
            ],
        ],
        'model' => \App\Modules\Download\Models\Download::class
    ],
    'download_category' =>[
        'label' => '下载分类',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '分类',
                    'type' => 'text',
                    'require' => true
                ],
            ],
            'seoTranslateField' => $seoTranslateField
        ],
        'model' => \App\Modules\Download\Models\DownloadCategory::class
    ],

    'navigation' =>[
        'label' => '自定义导航',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '名称',
                    'type' => 'text',
                    'require' => true
                ],
            ],
        ],
        'model' => \App\Modules\Navigation\Models\Navigation::class
    ],

    'brandSolution' => [
        'label' => '品牌解决方案',
        'value' => [
            'translateField' => [
                [
                    'name' => 'title',
                    'label' => '标题',
                    'type' => 'text',
                    'require' => true
                ],
                [
                    'name' => 'description',
                    'label' => '简介',
                    'type' => 'textarea',
                    'require' => false
                ],
                [
                    'name' => 'features',
                    'label' => '文案列表项',
                    'type' => 'list',
                    'require' => false
                ],
                [
                    'name' => 'button_text',
                    'label' => '按钮文案',
                    'type' => 'text',
                    'require' => false
                ],
            ],
        ],
        'model' => \App\Modules\Setting\Models\BrandSolution::class
    ],

    'homeProductCategory' => [
        'label' => '首页产品分类',
        'value' => [
            'translateField' => [
                [
                    'name' => 'title',
                    'label' => '标题',
                    'type' => 'textarea',
                    'require' => true,
                    'tip' => '支持HTML，如红色高亮与换行：<span class="text-brand-red">Recent</span> New<br />Products',
                ],
                [
                    'name' => 'description',
                    'label' => '简介',
                    'type' => 'textarea',
                    'require' => false,
                    'tip' => '支持HTML换行，如 Custom ...<br />Set ...',
                ],
                [
                    'name' => 'button_text',
                    'label' => '按钮文案',
                    'type' => 'text',
                    'require' => false
                ],
                [
                    'name' => 'alt',
                    'label' => '图片Alt',
                    'type' => 'text',
                    'require' => false
                ],
            ],
        ],
        'model' => \App\Modules\Setting\Models\HomeProductCategory::class
    ],

    'hotStyleTab' => [
        'label' => '热门款式Tab',
        'value' => [
            'translateField' => [
                [
                    'name' => 'label',
                    'label' => 'Tab文案',
                    'type' => 'text',
                    'require' => true,
                ],
            ],
        ],
        'model' => \App\Modules\Setting\Models\HotStyleTab::class
    ],

    'excitingUpdate' => [
        'label' => '精彩动态',
        'value' => [
            'translateField' => [
                [
                    'name' => 'title',
                    'label' => '标题',
                    'type' => 'text',
                    'require' => true,
                ],
                [
                    'name' => 'button_text',
                    'label' => '按钮文案',
                    'type' => 'text',
                    'require' => false,
                ],
                [
                    'name' => 'alt',
                    'label' => '图片Alt',
                    'type' => 'text',
                    'require' => false,
                ],
            ],
        ],
        'model' => \App\Modules\Setting\Models\ExcitingUpdate::class
    ],

    'whyChooseCard' => [
        'label' => '为何选择我们',
        'value' => [
            'translateField' => [
                [
                    'name' => 'label',
                    'label' => '标签',
                    'type' => 'text',
                    'require' => true,
                ],
                [
                    'name' => 'value',
                    'label' => '数值',
                    'type' => 'text',
                    'require' => false,
                ],
                [
                    'name' => 'value_suffix',
                    'label' => '数值后缀',
                    'type' => 'text',
                    'require' => false,
                ],
                [
                    'name' => 'description',
                    'label' => '描述',
                    'type' => 'textarea',
                    'require' => false,
                ],
            ],
        ],
        'model' => \App\Modules\Setting\Models\WhyChooseCard::class
    ],

    'customService' => [
        'label' => '定制服务',
        'value' => [
            'translateField' => [
                [
                    'name' => 'title_prefix',
                    'label' => '标题前缀(红色)',
                    'type' => 'text',
                    'require' => true,
                ],
                [
                    'name' => 'title_suffix',
                    'label' => '标题后缀',
                    'type' => 'text',
                    'require' => false,
                ],
                [
                    'name' => 'subtitle',
                    'label' => '副标题',
                    'type' => 'text',
                    'require' => false,
                ],
            ],
        ],
        'model' => \App\Modules\Setting\Models\CustomService::class
    ],

    'customServiceItem' => [
        'label' => '定制服务项',
        'value' => [
            'translateField' => [
                [
                    'name' => 'title',
                    'label' => '卡片标题',
                    'type' => 'text',
                    'require' => true,
                ],
            ],
        ],
        'model' => \App\Modules\Setting\Models\CustomServiceItem::class
    ],

    'sectionTitle' => [
        'label' => '板块标题',
        'value' => [
            'translateField' => [
                [
                    'name' => 'title',
                    'label' => '板块标题',
                    'type' => 'text',
                    'require' => true,
                ],
                [
                    'name' => 'subtitle',
                    'label' => '板块副标题',
                    'type' => 'textarea',
                    'require' => false,
                ],
            ],
        ],
        'model' => \App\Modules\Setting\Models\SectionTitle::class
    ],

    'snsIcon' => [
        'label' => 'SNS图标',
        'value' => [
            'translateField' => [
                [
                    'name' => 'alt',
                    'label' => 'Alt属性',
                    'type' => 'text',
                    'require' => false,
                ],
            ],
        ],
        'model' => \App\Modules\Setting\Models\SnsIcon::class
    ],

    'whyChooseSetting' => [
        'label' => '为何选择我们-中间板块',
        'value' => [
            'translateField' => [
                [
                    'name' => 'title',
                    'label' => '中间标题(移动端)',
                    'type' => 'text',
                    'require' => false,
                ],
                [
                    'name' => 'subtitle',
                    'label' => '中间副标题(移动端)',
                    'type' => 'text',
                    'require' => false,
                ],
                [
                    'name' => 'description_desktop',
                    'label' => '中间描述(桌面端)',
                    'type' => 'textarea',
                    'require' => false,
                ],
            ],
        ],
        'model' => \App\Modules\Setting\Models\WhyChooseSetting::class
    ],
];
