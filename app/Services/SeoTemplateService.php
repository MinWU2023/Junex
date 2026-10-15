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
        return translated_attr($this->setting(), 'name');
    }

    protected function settingField(string $field): string
    {
        return translated_attr($this->setting(), $field);
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
        return [
            'title' => $this->replacePlaceholders($this->settingField($titleField), $map),
            'keywords' => $this->replacePlaceholders($this->settingField($keywordsField), $map),
            'description' => $this->replacePlaceholders($this->settingField($descriptionField), $map),
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
        $siteName = $this->siteName();

        // Prefer SEO template; fallback to basic site TDK（当前语言→英语）
        $title = $this->settingField('seo_home_title');
        $keywords = $this->settingField('seo_home_keywords');
        $description = $this->settingField('seo_home_description');

        if ($title === '') {
            $title = $this->settingField('title');
        }
        if ($keywords === '') {
            $keywords = $this->settingField('keywords');
        }
        if ($description === '') {
            $description = $this->settingField('description');
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
            return translated_attr($q, 'name');
        })->filter()->values()->all();

        $tagAll = implode(',', $tags);
        $tagOne = implode(',', array_slice($tags, 0, 1));
        $tagThree = implode(',', array_slice($tags, 0, 3));

        $productName = translated_attr($product, 'name');
        $mapDesc = ['{1101}' => $productName, '{1102}' => $tagOne !== '' ? $tagOne : $tagAll];
        $mapKw = ['{1101}' => $productName, '{1102}' => $tagThree !== '' ? $tagThree : $tagAll];
        $mapTitle = ['{1101}' => $productName, '{1102}' => $tagAll];

        $ownTitle = translated_attr($product, 'title');
        $ownDesc = translated_attr($product, 'description');
        $ownKw = translated_attr($product, 'keywords');

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : $this->replacePlaceholders($this->settingField('seo_product_title'), $mapTitle);

        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : $this->replacePlaceholders($this->settingField('seo_product_description'), $mapDesc);

        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->settingField('seo_product_keywords'), $mapKw);

        return $this->seo;
    }

    public function getCategory(ProductCategory $productCategory)
    {
        $ownTitle = translated_attr($productCategory, 'title');
        $ownKw = translated_attr($productCategory, 'keywords');
        $ownDesc = translated_attr($productCategory, 'description');

        $name = translated_attr($productCategory, 'name');
        $parentName = $productCategory->parent ? translated_attr($productCategory->parent, 'name') : '';
        $childName = isset($productCategory->children[0])
            ? translated_attr($productCategory->children[0], 'name')
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
            : $this->replacePlaceholders($this->settingField($titleField), $map);
        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->settingField($kwField), $map);
        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : $this->replacePlaceholders($this->settingField($descField), $map);

        return $this->seo;
    }

    public function getTag(ProductTag $productTag)
    {
        $map = ['{1107}' => translated_attr($productTag, 'name')];
        $ownTitle = translated_attr($productTag, 'title');
        $ownDesc = translated_attr($productTag, 'description');
        $ownKw = translated_attr($productTag, 'keywords');

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : $this->replacePlaceholders($this->settingField('seo_product_tag_title'), $map);
        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : $this->replacePlaceholders($this->settingField('seo_product_tag_description'), $map);
        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->settingField('seo_product_tag_keywords'), $map);

        return $this->seo;
    }

    public function getBlogCategory(BlogCategory $blogCategory)
    {
        $map = ['{1110}' => translated_attr($blogCategory, 'name')];
        $ownTitle = translated_attr($blogCategory, 'title');
        $ownDesc = translated_attr($blogCategory, 'description');
        $ownKw = translated_attr($blogCategory, 'keywords');

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : $this->replacePlaceholders($this->settingField('seo_blog_category_title'), $map);
        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : $this->replacePlaceholders($this->settingField('seo_blog_category_description'), $map);
        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->settingField('seo_blog_category_keywords'), $map);

        return $this->seo;
    }

    public function getDownloadCategory(DownloadCategory $downloadCategory)
    {
        $this->seo['title'] = translated_attr($downloadCategory, 'title');
        $this->seo['description'] = translated_attr($downloadCategory, 'description');
        $this->seo['keywords'] = translated_attr($downloadCategory, 'keywords');
        return $this->seo;
    }

    public function getBlogTag(BlogTag $blogTag)
    {
        $map = ['{1113}' => translated_attr($blogTag, 'name')];
        $ownTitle = translated_attr($blogTag, 'title');
        $ownDesc = translated_attr($blogTag, 'description');
        $ownKw = translated_attr($blogTag, 'keywords');

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : $this->replacePlaceholders($this->settingField('seo_blog_tag_title'), $map);
        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : $this->replacePlaceholders($this->settingField('seo_blog_tag_description'), $map);
        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->settingField('seo_blog_tag_keywords'), $map);

        return $this->seo;
    }

    public function getBlog(Blog $blog)
    {
        $tags = collect($blog->blogTags)->map(function ($q) {
            return translated_attr($q, 'name');
        })->filter()->values()->all();

        $tagOne = implode(',', array_slice($tags, 0, 1));
        $tagThree = implode(',', array_slice($tags, 0, 3));
        $name = translated_attr($blog, 'name');
        $host = (string)request()->getHost();

        $ownTitle = translated_attr($blog, 'title');
        $ownDesc = translated_attr($blog, 'description');
        $ownKw = translated_attr($blog, 'keywords');

        if ($ownTitle !== '') {
            $this->seo['title'] = $ownTitle . '-' . $host;
        } else {
            $tpl = $this->settingField('seo_blog_title');
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
            $tpl = $this->settingField('seo_blog_description');
            if ($tpl !== '') {
                $this->seo['description'] = $this->replacePlaceholders($tpl, [
                    '{1112}' => $name,
                    '{1113}' => $tagOne,
                ]);
            } else {
                $this->seo['description'] = mb_substr(strip_tags(translated_attr($blog, 'content')), 0, 300);
            }
        }

        if ($ownKw !== '') {
            $this->seo['keywords'] = $ownKw;
        } else {
            $tpl = $this->settingField('seo_blog_keywords');
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
        $map = ['{1108}' => translated_attr($articleCategory, 'name')];
        $ownTitle = translated_attr($articleCategory, 'title');
        $ownDesc = translated_attr($articleCategory, 'description');
        $ownKw = translated_attr($articleCategory, 'keywords');

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : $this->replacePlaceholders($this->settingField('seo_article_category_title'), $map);
        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : $this->replacePlaceholders($this->settingField('seo_article_category_description'), $map);
        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->settingField('seo_article_category_keywords'), $map);

        return $this->seo;
    }

    public function getarticle(Article $article)
    {
        $map = ['{1109}' => translated_attr($article, 'name')];
        $ownTitle = translated_attr($article, 'title');
        $ownKw = translated_attr($article, 'keywords');

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : $this->replacePlaceholders($this->settingField('seo_article_title'), $map);

        $tplDesc = $this->settingField('seo_article_description');
        if ($tplDesc !== '') {
            $this->seo['description'] = $this->replacePlaceholders($tplDesc, $map);
        } else {
            $this->seo['description'] = mb_substr(str_replace("\n", '', strip_tags(translated_attr($article, 'content'))), 0, 300);
        }

        $this->seo['keywords'] = $ownKw !== ''
            ? $ownKw
            : $this->replacePlaceholders($this->settingField('seo_article_keywords'), $map);

        return $this->seo;
    }

    public function getPage(Page $page)
    {
        $ownTitle = translated_attr($page, 'title');
        $ownDesc = translated_attr($page, 'description');
        $ownKw = translated_attr($page, 'keywords');
        $name = translated_attr($page, 'name');

        $this->seo['title'] = $ownTitle !== ''
            ? $ownTitle
            : ($name . '-' . request()->getHost());

        $this->seo['description'] = $ownDesc !== ''
            ? $ownDesc
            : Str::substr(strip_tags(translated_attr($page, 'content')), 0, 300);

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
        $ownTitle = translated_attr($video, 'title');
        $ownKw = translated_attr($video, 'keywords');
        $ownDesc = translated_attr($video, 'description');
        $name = translated_attr($video, 'name');
        $host = (string)request()->getHost();

        $this->seo['title'] = $ownTitle !== '' ? $ownTitle . '-' . $host : $name . '-' . $host;
        $this->seo['keywords'] = $ownKw !== '' ? $ownKw : $name;
        $this->seo['description'] = $ownDesc !== '' ? $ownDesc : mb_substr(strip_tags(translated_attr($video, 'content')), 0, 300);
        return $this->seo;
    }

    public function getVideoCategory(ProductVideoCategory $category)
    {
        $ownTitle = translated_attr($category, 'title');
        $ownKw = translated_attr($category, 'keywords');
        $ownDesc = translated_attr($category, 'description');
        $name = translated_attr($category, 'name');

        $this->seo['title'] = $ownTitle !== '' ? $ownTitle : $name;
        $this->seo['keywords'] = $ownKw !== '' ? $ownKw : $name;
        $this->seo['description'] = $ownDesc !== '' ? $ownDesc : mb_substr(strip_tags(translated_attr($category, 'content')), 0, 300);
        return $this->seo;
    }
}
