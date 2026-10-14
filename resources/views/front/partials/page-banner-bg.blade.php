@php
    $banners = $pageBanner ?? collect();
    $pcBanner = $banners->first();
    $pcPath = $pcBanner ? front_image_url($pcBanner->path ?? '') : '';
    $hasAnyMobile = $banners->contains(function ($item) {
        return !empty($item->path_mobile);
    });
    $mobileBanner = $hasAnyMobile
        ? $banners->first(function ($item) {
            return !empty($item->path_mobile);
        })
        : null;
    $mobilePath = $mobileBanner ? front_image_url($mobileBanner->path_mobile ?? '') : '';
@endphp
@if($pcPath !== '')
    @if($hasAnyMobile && $mobilePath !== '')
        <div class="absolute inset-0 bg-center bg-no-repeat bg-cover pagebanner-bg pagebanner-bg--pc" style="background-image:url('{{ $pcPath }}')" aria-hidden="true"></div>
        <div class="absolute inset-0 bg-center bg-no-repeat bg-cover pagebanner-bg pagebanner-bg--mobile" style="background-image:url('{{ $mobilePath }}')" aria-hidden="true"></div>
    @else
        <div class="absolute inset-0 bg-center bg-no-repeat bg-cover" style="background-image:url('{{ $pcPath }}')" aria-hidden="true"></div>
    @endif
@endif
