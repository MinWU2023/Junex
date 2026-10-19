{{-- Sidebar + product grid; pagination lives inside the product column so the sidebar does not separate it on mobile --}}
@php
    $productsData = $productsData ?? [];
    $products = $products ?? null;
    $listPaddingTop = $listPaddingTop ?? __('py-16');
@endphp

<section class="w-full bg-themeBg-a product_list sec-bg-white">
    <div class="sec-pad mx-auto w-[calc(100%-30px)] max-w-[1200px] {{ $listPaddingTop }}">
        <div class="flex flex-col gap-[50px] md4:flex-row md4:items-start">
            @include('front.partials.product-list-sidebar', [
                'sidebarCategories' => $sidebarCategories ?? [],
                'sidebarRecommendProducts' => $sidebarRecommendProducts ?? [],
                'activeCategoryId' => $activeCategoryId ?? null,
            ])

            <div class="order-1 min-w-0 flex-1 md4:order-2">
                @if(!empty($productsData))
                    <div class="grid grid-cols-1 gap-4 sm5:grid-cols-2 md4:grid-cols-2 lg1:grid-cols-3">
                        @foreach($productsData as $p)
                            @include('front.partials.product-list-card', ['p' => $p])
                        @endforeach
                    </div>
                @else
                    <div class="py-16 text-center">
                        <p class="font-poppins-regular text-f16 text-themeText-g">{{ __('No products found.') }}</p>
                    </div>
                @endif

                @if($products)
                    <div class="mt-10">
                        @include('pagination.common', ['paginator' => $products])
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
