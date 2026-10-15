@php
    $image = front_webp_url($image ?? '/front/imgs/index_rc_01.png');
    $name = $name ?? '';
    $url = $url ?? '#';
    $favorite = (int)($favorite ?? 0);
    $productId = (int)($productId ?? 0);
    $model = (string)($model ?? '');

    if (!empty($product)) {
        $image = '';
        if (!empty($product->productMainImage) && !empty($product->productMainImage->path)) {
            $image = front_webp_url($product->productMainImage->path);
        }
        if ($image === '') {
            $image = front_webp_url('/front/imgs/index_rc_01.png');
        }
        $name = translated_attr($product, 'name');
        $url = '/' . ltrim($product->url->url ?? '', '/');
        if ($url === '/') {
            $url = '#';
        }
        $favorite = (int)($product->is_favorite ?? 0);
        $productId = (int)($product->id ?? 0);
        $model = (string)($product->url_key ?? '');
        $brief = translated_attr($product, 'brief_content');
    }
@endphp

@include('front.partials.product-list-card', [
    'id' => $productId,
    'name' => $name,
    'image' => $image,
    'url' => $url,
    'model' => $model,
    'brief' => $brief,
    'favorite' => $favorite,
    'imageClass' => 'w-full h-auto transition-transform duration-300 group-hover:scale-105',
])
