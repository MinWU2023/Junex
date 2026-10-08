<?php

return [
    'data' => [
        "™","/","|",",","‘",":","&","#","%","©","®","™","~","φ","Φ","*","×","(",")",".","〜","="
    ],
    'article_category'=> 'articlecategory/', //新闻分类
    'article'=>'diy/',//新闻,diy/默认链接前缀为上级分类

    'blog_category' => 'blogcategory/', //博客分类
    'blog_tag' => 'blogtag/', //博客关键词
    'blog' => 'blog/', //博客

    'page' => '', //单页面
    
    'download_category'=>'',

    'product' => 'product/', //产品 禁止使用product/
    'product_tag' => 'tag/', //产品关键词
    'product_category' => '', // 产品分类：直接使用名称生成的 slug，不加前缀

    'product_video' => 'video/', //产品视频
    'product_video_category' => 'videocategory/', //产品视频分类
];
