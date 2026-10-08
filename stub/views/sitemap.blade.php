<x-layout>
    @section('title'){{ $page->title }}@endsection
    @section('description'){{ $page->description }}@endsection
    @section('keywords'){{ $page->keywords }}@endsection


    <div class="page_banner">
        <a href="#"><img src="{{ asset('images/page_banner.jpg') }}" alt=""></a>
    </div>


    <div class="breadcrumb clearfix">
        <div class="container">
            <div class="breadcrumbm">
                <div class="in_title">
                    <span>{{__('about us')}}</span>
                </div>
                <div class="bread_right">
                    <a class="home" href="/" title="Return to Home"><i class="fa fa-home"></i>{{__('Home')}}</a>
                    <i class="fa fa-angle-right"></i>
                    <h2>{{__('sitemap')}}</h2>
                </div>
            </div>
        </div>
    </div>


    <div class="page_section clearfix">

        <div class="container">
            <div class="page_column clearfix">
                <div class="sitemap clearfix">
                    <ul class="stp-listA clearfix">
                        <li>
                            <div class="stp-top"><a href="/" class="page_info_title">{{__('Home')}}</a></div>
                            <ul class="stp-listB clearfix">
                                <li><a href="{{url('company-profile')}}">{{__('About us')}}</a></li>
                                <li><a href="{{route('contact-us')}}">{{__('Contact')}}</a></li>
                            </ul>
                        </li>
                        <li>
                            <div class="stp-top"><a href="{{route('products')}}" class="page_info_title">{{__('Products')}}</a></div>
                            <ul class="stp-listB clearfix">
                                @foreach($productCategories as $productCategory)
                                <li><a href="{{url($productCategory->url_key)}}">{{$productCategory->name}}</a>
                                    @isset($productCategory->children)
                                    <ul class="stp-listC">
                                        @foreach($productCategory->children as $children)
                                        <li><a href="{{url($children->url_key)}}"><i class="fa fa-angle-right"></i>{{$children->name}}</a></li>
                                        @endforeach
                                    </ul>
                                        @endif
                                </li>
                                    @endforeach
                            </ul>
                        </li>
{{--                        <li>--}}
{{--                            <div class="stp-top"><a href="cerfiticate.html" class="page_info_title">Certificate</a></div>--}}
{{--                        </li>--}}
                        <li>
                            <div class="stp-top"><a href="{{route('news')}}" class="page_info_title">{{__('News')}}</a></div>
                        </li>
                        <li>
                            <div class="stp-top"><a href="{{route('blogs')}}" class="page_info_title">{{__('blog')}}</a></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


</x-layout>
