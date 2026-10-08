<?php
$seoTranslateField = [
    [
        'name' => 'title',
        'label' => 'title',
        'type' => 'text',
        'require' => false
    ],
    [
        'name' => 'keywords',
        'label' => 'keywords',
        'type' => 'text',
        'require' => false
    ],
    [
        'name' => 'description',
        'label' => 'description',
        'type' => 'text',
        'require' => false
    ]
];
return [
    'seo' => $seoTranslateField,
    'setting' => [
        [
            'name' => 'name',
            'label' => '网站名称',
            'type' => 'text',
            'require' => true
        ]
    ],
    'home' => [
        [
            'name' => 'seo_home_title',
            'label' => '首页标题模板{site_name}',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_home_keywords',
            'label' => '首页关键词模板{site_name}',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_home_description',
            'label' => '首页描述模板{site_name}',
            'type' => 'text',
            'require' => false
        ],
    ],
    'product_list' => [
        [
            'name' => 'seo_products_title',
            'label' => '产品列表标题模板',
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
            'name' => 'seo_products_description',
            'label' => '产品列表描述模板',
            'type' => 'text',
            'require' => false
        ],
    ],
    'product_category' => [
        [
            'name' => 'seo_product_category_title',
            'label' => '产品一级分类标题模板{1103}:当前分类{1106}:下级分类',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_product_category_keywords',
            'label' => '产品一级分类关键词模板{1103}:当前分类{1106}:下级分类',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_product_category_description',
            'label' => '产品一级分类描述模板{1103}:当前分类{1106}:下级分类',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_product_category_bottom_title',
            'label' => '产品其他分类标题模板{1103}:当前分类{1105}:上级分类',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_product_category_bottom_keywords',
            'label' => '产品其他分类关键词模板{1103}:当前分类{1105}:上级分类',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_product_category_bottom_description',
            'label' => '产品其他分类描述模板{1103}:当前分类{1105}:上级分类',
            'type' => 'text',
            'require' => false
        ],
    ],
    'product' => [
        [
            'name' => 'seo_product_title',
            'label' => '产品详情标题模板{1101}:产品名称{1102}:产品tag',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_product_keywords',
            'label' => '产品详情关键词{1101}:产品名称{1102}:产品tag',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_product_description',
            'label' => '产品详情描述模板{1101}:产品名称{1102}:产品tag',
            'type' => 'text',
            'require' => false
        ],
    ],
    'product_tag' => [
        [
            'name' => 'seo_product_tag_title',
            'label' => '产品TAG标题模板{1107}:tag名称',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_product_tag_keywords',
            'label' => '产品TAG关键词模板{1107}:tag名称',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_product_tag_description',
            'label' => '产品TAG描述模板{1107}:tag名称',
            'type' => 'text',
            'require' => false
        ],
    ],
//    'article_list' => [
//        [
//            'name' => 'seo_articles_title',
//            'label' => '新闻列表标题模板{1109}:新闻名称',
//            'type' => 'text',
//            'require' => false
//        ],
//        [
//            'name' => 'seo_articles_description',
//            'label' => '新闻列表描述模板{1109}:新闻名称',
//            'type' => 'text',
//            'require' => false
//        ],
//        [
//            'name' => 'seo_articles_keywords',
//            'label' => '新闻列表关键词模板{1109}:新闻名称',
//            'type' => 'text',
//            'require' => false
//        ],
//    ],
    'article_category' => [
        [
            'name' => 'seo_article_category_title',
            'label' => '新闻分类标题{1108}:新闻分类名称',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_article_category_keywords',
            'label' => '新闻分类关键词{1108}:新闻分类名称',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_article_category_description',
            'label' => '新闻分类描述{1108}:新闻分类名称',
            'type' => 'text',
            'require' => false
        ],
    ],
    'article' => [
        [
            'name' => 'seo_article_title',
            'label' => '新闻标题{1109}:新闻名称',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_article_keywords',
            'label' => '新闻关键词{1109}:新闻名称',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_article_description',
            'label' => '新闻详情{1109}:新闻名称',
            'type' => 'text',
            'require' => false
        ],
    ],
    'blog_list' => [
        [
            'name' => 'seo_blogs_title',
            'label' => '博客列表标题模板{site_name}',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_blogs_keywords',
            'label' => '博客列表关键词模板{site_name}',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_blogs_description',
            'label' => '博客列表描述模板{site_name}',
            'type' => 'text',
            'require' => false
        ],
    ],
    'blog_category' => [
        [
            'name' => 'seo_blog_category_title',
            'label' => '博客分类标题模板(可不填){1110}:分类名称',
            'type' => 'text',
            'require' => false
        ],

        [
            'name' => 'seo_blog_category_keywords',
            'label' => '博客分类关键词模板(可不填){1110}:分类名称',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_blog_category_description',
            'label' => '博客分类描述模板(可不填){1110}:分类名称',
            'type' => 'text',
            'require' => false
        ],
    ],
    'blog' => [
        [
            'name' => 'seo_blog_title',
            'label' => '博客标题模板{1112}:博客名称',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_blog_keywords',
            'label' => '博客关键词模板{1112}:博客名称',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_blog_description',
            'label' => '博客描述模板{1112}:博客名称',
            'type' => 'text',
            'require' => false
        ],
    ],
    'blog_tag' => [
        [
            'name' => 'seo_blog_tag_title',
            'label' => '博客TAG标题模板{1113}:tag名称',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_blog_tag_keywords',
            'label' => '博客TAG关键词模板{1113}:tag名称',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_blog_tag_description',
            'label' => '博客TAG描述模板{1113}:tag名称',
            'type' => 'text',
            'require' => false
        ],
    ],
    'sitemap' => [
        [
            'name' => 'seo_sitemap_title',
            'label' => 'sitemap标题模板',
            'type' => 'text',
            'require' => false
        ],
        [
            'name' => 'seo_sitemap_keywords',
            'label' => 'sitemap关键词模板',
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
            'name' => 'product_alt_template',
            'label' => '产品图片ALT模板',
            'type' => 'text',
            'require' => false
        ],
    ],
//    'product_alt'=>[
//
//    ],
];
