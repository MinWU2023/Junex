@php
    $snsShareUrl = url()->current();
    $snsShareTitle = translated_attr($product, 'name');
    $snsShareImage = (string)(($productImagesData[0]['url'] ?? '') ?: '');
    if ($snsShareImage !== '' && !preg_match('#^https?://#i', $snsShareImage)) {
        $snsShareImage = url($snsShareImage);
    }
@endphp
<div class="product-share-bar">
    <span class="product-share-label">{{ __('Share') }}</span>
    <div class="product-share-list">
        @include('front.partials.sns-icons', [
            'variant' => 'product',
            'shareUrl' => $snsShareUrl,
            'shareTitle' => $snsShareTitle,
            'shareImage' => $snsShareImage,
            'snsIcons' => $snsIcons ?? ($data['snsShareIcons'] ?? sns_icons('share')),
        ])
    </div>
</div>
