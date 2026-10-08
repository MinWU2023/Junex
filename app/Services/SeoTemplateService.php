<?php


namespace App\Services;

use App\Modules\Article\Models\Article;
use App\Modules\Article\Models\ArticleCategory;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogCategory;
use App\Modules\Blog\Models\BlogTag;
use App\Modules\Product\Models\ProductVideo;
use App\Modules\Product\Models\ProductVideoCategory;
use App\Modules\Page\Models\Page;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductCategory;
use App\Modules\Product\Models\ProductTag;
use App\Modules\Download\Models\DownloadCategory;
use Illuminate\Support\Str;

class SeoTemplateService
{
    private $settings;
    private $seo;

    public function __construct()
    {
        $this->settings = app('settings');
        $this->seo = [
            'title' => '',
            'keywords' => '',
            'description' => '',
        ];
    }

    protected function setting()
    {
        return $this->settings['setting'];
    }

    protected function siteName(): string
    {
        return (string)($this->setting()->name ?? '');
    }

    /**
     * Replace placeholders like {1101}, {site_name}.
     */
    protected function replacePlaceholders(?string $template, array $map): string
    {
        $text = (string)$template;
        if ($text === '') {
            return '';
        }
        if (!array_key_exists('{site_name}', $map)) {
            $map['{site_name}'] = $this->siteName();
        }
        return str_replace(array_keys($map), array_values($map), $text);
    }

    protected function fromTemplate(string $titleField, string $keywordsField, string $descriptionField, array $map = []): array
    {
        $s = $this->setting();
        return [
            'title' => $this->replacePlaceholders($s->{$titleField} ?? '', $map),
            'keywords' => $this->replacePlaceholders($s->{$keywordsField} ?? '', $map),
            'description' => $this->replacePlaceholders($s->{$descriptionField} ?? '', $map),
        ];
    }

    public function getProducts()
    {
        $this->seo = $this->fromTemplate(
            'seo_products_title',
            'seo_products_keywords',
            'seo_products_description'
        );
        return $this->seo;
    }

    public function getHome()
    {
        $s = $this->setting();
        $siteName = $this->siteName();

        // Prefer SEO template; fallback to basic site TDK
        $title = trim((string)($s->seo_home_title ?? ''));
        $keywords = trim((string)($s->seo_home_keywords ?? ''));
        $description = trim((string)($s->seo_home_description ?? ''));

        if ($title === '') {
            $title = (string)($s->title ?? '');
        }
        if ($keywords === '') {
            $keywords = (string)($s->keywords ?? '');
        }
        if ($description === '') {
            $description = (string)($s->description ?? '');
        }

        $map = ['{site_name}' => $siteName];
        $this->seo['title'] = $this->replacePlaceholders($title, $map);
        $this->seo['keywords'] = $this->replacePlaceholders($keywords, $map);
        $this->seo['description'] = $this->replacePlaceholders($description, $map);

        return $this->seo;
    }

    public function getBlogs()
    {
        $this->seo = $this->fromTemplate(
            'seo_blogs_title',
            'seo_blogs_keywords',
            'seo_blogs_description'
        );
        return $this->seo;
    }

    public function getSitemap()
    {
        $this->seo = $this->fromTemplate(
            'seo_sitemap_title',
            'seo_sitemap_keywords',
            'seo_sitemap_description'
        );
        return $this->seo;
    }

    public function getProduct(Product $product)
    {
        $tags = collect($product->productTags)->map(function ($q) {
            return $q->name;
        })->filter()->values()->all();

        $tagAll = implode(',', $tags);
        $tagOne = implode(',', array_slice($tags, 0, 1));
        $tagThree = implode(',', array_slice($tags, 0, 3));

        $mapDesc = ['{1101}' => (string)$product->name, '{1102}' => $tagOne !== '' ? $tagOne : $tagAll];
        $mapKw = ['{1101}' => (string)$product->name, '{1102}' => $tagThree !== '' ? $tagThree : $tagAll];
        $mapTitle = ['{1101}' => (string)$product->name, '{1102}' => $tagAll];

        $ownTitle = trim((string)($product->title ?? ''));
        $ownDesc = trim((string)($product->description ?? ''));
        $ownKw = trim((string)($product->keywords ?? ''));

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : $this->replacePlaceholders($this->setting()->seo_product_title ?? '', $mapTitle);

        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : $this->replacePlaceholders($this->setting()->seo_product_description ?? '', $mapDesc);

        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->setting()->seo_product_keywords ?? '', $mapKw);

        return $this->seo;
    }

    public function getCategory(ProductCategory $productCategory)
    {
        $ownTitle = trim((string)($productCategory->title ?? ''));
        $ownKw = trim((string)($productCategory->keywords ?? ''));
        $ownDesc = trim((string)($productCategory->description ?? ''));

        $name = (string)($productCategory->name ?? '');
        $parentName = $productCategory->parent ? (string)($productCategory->parent->name ?? '') : '';
        $childName = isset($productCategory->children[0])
            ? (string)($productCategory->children[0]->name ?? '')
            : '';

        if ($productCategory->parent) {
            $map = ['{1103}' => $name, '{1105}' => $parentName, '{1106}' => $childName];
            $titleField = 'seo_product_category_bottom_title';
            $kwField = 'seo_product_category_bottom_keywords';
            $descField = 'seo_product_category_bottom_description';
        } else {
            $map = ['{1103}' => $name, '{1105}' => $parentName, '{1106}' => $childName];
            $titleField = 'seo_product_category_title';
            $kwField = 'seo_product_category_keywords';
            $descField = 'seo_product_category_description';
        }

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : $this->replacePlaceholders($this->setting()->{$titleField} ?? '', $map);
        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->setting()->{$kwField} ?? '', $map);
        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : $this->replacePlaceholders($this->setting()->{$descField} ?? '', $map);

        return $this->seo;
    }

    public function getTag(ProductTag $productTag)
    {
        $map = ['{1107}' => (string)($productTag->name ?? '')];
        $ownTitle = trim((string)($productTag->title ?? ''));
        $ownDesc = trim((string)($productTag->description ?? ''));
        $ownKw = trim((string)($productTag->keywords ?? ''));

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : $this->replacePlaceholders($this->setting()->seo_product_tag_title ?? '', $map);
        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : $this->replacePlaceholders($this->setting()->seo_product_tag_description ?? '', $map);
        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->setting()->seo_product_tag_keywords ?? '', $map);

        return $this->seo;
    }

    public function getBlogCategory(BlogCategory $blogCategory)
    {
        $map = ['{1110}' => (string)($blogCategory->name ?? '')];
        $ownTitle = trim((string)($blogCategory->title ?? ''));
        $ownDesc = trim((string)($blogCategory->description ?? ''));
        $ownKw = trim((string)($blogCategory->keywords ?? ''));

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : $this->replacePlaceholders($this->setting()->seo_blog_category_title ?? '', $map);
        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : $this->replacePlaceholders($this->setting()->seo_blog_category_description ?? '', $map);
        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->setting()->seo_blog_category_keywords ?? '', $map);

        return $this->seo;
    }

    public function getDownloadCategory(DownloadCategory $downloadCategory)
    {
        $this->seo['title'] = (string)($downloadCategory->title ?? '');
        $this->seo['description'] = (string)($downloadCategory->description ?? '');
        $this->seo['keywords'] = (string)($downloadCategory->keywords ?? '');
        return $this->seo;
    }

    public function getBlogTag(BlogTag $blogTag)
    {
        $map = ['{1113}' => (string)($blogTag->name ?? '')];
        $ownTitle = trim((string)($blogTag->title ?? ''));
        $ownDesc = trim((string)($blogTag->description ?? ''));
        $ownKw = trim((string)($blogTag->keywords ?? ''));

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : $this->replacePlaceholders($this->setting()->seo_blog_tag_title ?? '', $map);
        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : $this->replacePlaceholders($this->setting()->seo_blog_tag_description ?? '', $map);
        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->setting()->seo_blog_tag_keywords ?? '', $map);

        return $this->seo;
    }

    public function getBlog(Blog $blog)
    {
        $tags = collect($blog->blogTags)->map(function ($q) {
            return $q->name;
        })->filter()->values()->all();

        $tagOne = implode(',', array_slice($tags, 0, 1));
        $tagThree = implode(',', array_slice($tags, 0, 3));
        $name = (string)($blog->name ?? '');
        $host = (string)request()->getHost();

        $ownTitle = trim((string)($blog->title ?? ''));
        $ownDesc = trim((string)($blog->description ?? ''));
        $ownKw = trim((string)($blog->keywords ?? ''));

        if ($ownTitle !== '') {
            $this->seo['title'] = $ownTitle . '-' . $host;
        } else {
            $tpl = trim((string)($this->setting()->seo_blog_title ?? ''));
            if ($tpl !== '') {
                $this->seo['title'] = $this->replacePlaceholders($tpl, [
                    '{1112}' => $name,
                    '{1113}' => $tagOne,
                ]);
            } else {
                $this->seo['title'] = $name . '-' . $host;
            }
        }

        if ($ownDesc !== '') {
            $this->seo['description'] = $ownDesc;
        } else {
            $tpl = trim((string)($this->setting()->seo_blog_description ?? ''));
            if ($tpl !== '') {
                $this->seo['description'] = $this->replacePlaceholders($tpl, [
                    '{1112}' => $name,
                    '{1113}' => $tagOne,
                ]);
            } else {
                $this->seo['description'] = mb_substr(strip_tags((string)($blog->content ?? '')), 0, 300);
            }
        }

        if ($ownKw !== '') {
            $this->seo['keywords'] = $ownKw;
        } else {
            $tpl = trim((string)($this->setting()->seo_blog_keywords ?? ''));
            if ($tpl !== '') {
                $this->seo['keywords'] = $this->replacePlaceholders($tpl, [
                    '{1112}' => $name,
                    '{1113}' => $tagThree,
                ]);
            } else {
                $this->seo['keywords'] = implode(',', $tags);
            }
        }

        return $this->seo;
    }

    public function getArticleCategory(ArticleCategory $articleCategory)
    {
        $map = ['{1108}' => (string)($articleCategory->name ?? '')];
        $ownTitle = trim((string)($articleCategory->title ?? ''));
        $ownDesc = trim((string)($articleCategory->description ?? ''));
        $ownKw = trim((string)($articleCategory->keywords ?? ''));

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : $this->replacePlaceholders($this->setting()->seo_article_category_title ?? '', $map);
        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : $this->replacePlaceholders($this->setting()->seo_article_category_description ?? '', $map);
        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->setting()->seo_article_category_keywords ?? '', $map);

        return $this->seo;
    }

    public function getarticle(Article $article)
    {
        $map = ['{1109}' => (string)($article->name ?? '')];
        $ownTitle = trim((string)($article->title ?? ''));
        $ownKw = trim((string)($article->keywords ?? ''));

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : $this->replacePlaceholders($this->setting()->seo_article_title ?? '', $map);

        $tplDesc = trim((string)($this->setting()->seo_article_description ?? ''));
        if ($tplDesc !== '') {
            $this->seo['description'] = $this->replacePlaceholders($tplDesc, $map);
        } else {
            $this->seo['description'] = mb_substr(str_replace("\n", '', strip_tags((string)($article->content ?? ''))), 0, 300);
        }

        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->setting()->seo_article_keywords ?? '', $map);

        return $this->seo;
    }

    public function getPage(Page $page)
    {
        $ownTitle = trim((string)($page->title ?? ''));
        $ownDesc = trim((string)($page->description ?? ''));
        $ownKw = trim((string)($page->keywords ?? ''));
        $name = (string)($page->name ?? '');

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : ($name . '-' . request()->getHost());

        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : Str::substr(strip_tags((string)($page->content ?? '')), 0, 300);

        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $name;

        return $this->seo;
    }

    public function getVideos()
    {
        $this->seo = $this->fromTemplate('seo_videos_title', 'seo_videos_keywords', 'seo_videos_description');
        return $this->seo;
    }

    public function getVideo(ProductVideo $video)
    {
        $ownTitle = trim((string)($video->title ?? ''));
        $ownKw = trim((string)($video->keywords ?? ''));
        $ownDesc = trim((string)($video->description ?? ''));
        $name = (string)($video->name ?? '');
        $host = (string)request()->getHost();

        $this->seo['title'] = $ownTitle !== '' ? $ownTitle . '-' . $host : $name . '-' . $host;
        $this->seo['keywords'] = $ownKw !== '' ? $ownKw : $name;
        $this->seo['description'] = $ownDesc !== '' ? $ownDesc : mb_substr(strip_tags((string)($video->content ?? '')), 0, 300);
        return $this->seo;
    }

    public function getVideoCategory(ProductVideoCategory $category)
    {
        $ownTitle = trim((string)($category->title ?? ''));
        $ownKw = trim((string)($category->keywords ?? ''));
        $ownDesc = trim((string)($category->description ?? ''));
        $name = (string)($category->name ?? '');

        $this->seo['title'] = $ownTitle !== '' ? $ownTitle : $name;
        $this->seo['keywords'] = $ownKw !== '' ? $ownKw : $name;
        $this->seo['description'] = $ownDesc !== '' ? $ownDesc : mb_substr(strip_tags((string)($category->content ?? '')), 0, 300);
        return $this->seo;
    }
}
