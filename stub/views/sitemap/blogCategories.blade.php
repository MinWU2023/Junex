<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    @foreach($blogCategories as $blogCategory)

    <url>
        <loc>{{ url($blogCategory->url_key) }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>{{__('weekly')}}</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>

