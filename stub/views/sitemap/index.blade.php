<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{route('sitemap.productCategories')}}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{route('sitemap.products')}}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
    </sitemap>

    <sitemap>
        <loc>{{route('sitemap.productTags')}}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{route('sitemap.blogCategories')}}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{route('sitemap.blogs')}}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{route('sitemap.blogTags')}}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{route('sitemap.pages')}}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
    </sitemap>

</sitemapindex>

