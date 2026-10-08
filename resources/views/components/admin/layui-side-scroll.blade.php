<?php
use Illuminate\Support\Facades\Route;
?>
<div  class="{{ $default_class }}" style="{{ $default_background }}">
    <div class="layui-side-scroll">
        <div class="layui-logo" lay-href="home/console.html">
            <!-- <span>dyyseo11</span> -->
            <img src="{{ asset('/images/logo.png') }}" />
        </div>
        <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
            @foreach($menus as $menu)
                @can($menu['route'])
                    <li data-name="{{ $menu['id'] }}" class="layui-nav-item">
                        @if(isset($menu['children']))
                            <a href="javascript:void(0);" lay-tips="{{ $menu['name'] }}" lay-direction="2" style="{{ $default_color }};">
                                <i class="{{ $menu['icon'] }}"></i>
                                <cite>{{ __($menu['name']) }}</cite>
                            </a>
                            <dl class="layui-nav-child">

                                @foreach($menu['children'] as $first)
                                    @if(!isset($first['children']))
                                        @can($first['route'])
                                            @if($first['name'] == '应用市场')
                                                <dd><a target="_blank" href="http://tg.dyycloud.com/addons" >{{ __($first['name']) }}</a ></dd>
                                            @else
                                                @php
                                                    $firstHref = '';
                                                    if (Route::has($first['route'])) {
                                                        $firstHref = route($first['route']);
                                                    } else {
                                                        $routeSegs = explode('.', (string)($first['route'] ?? ''));
                                                        if (count($routeSegs) >= 3 && $routeSegs[0] === 'admin' && end($routeSegs) === 'index') {
                                                            $firstHref = url(trim((string)config('app.admin_prefix'), '/') . '/' . $routeSegs[1]);
                                                        }
                                                    }
                                                @endphp
                                                @if($firstHref !== '')
                                                    <dd data-name="{{ $first['id'] }}">
                                                        <a lay-href="{{ $firstHref }}">{{ __($first['name']) }}</a>
                                                    </dd>
                                                @endif
                                            @endif
                                        @endcan
                                    @else
                                        @can($first['route'])
                                            <dd data-name="{{ $first['id'] }}">
                                                <a href="javascript:void(0);">{{ __($first['name']) }}</a>
                                                <dl class="layui-nav-child">
                                                    @foreach($first['children'] as $second)
                                                        @can($second['route'])
                                                            @php
                                                                $secondHref = '';
                                                                if (Route::has($second['route'])) {
                                                                    $secondHref = route($second['route']);
                                                                } else {
                                                                    $routeSegs = explode('.', (string)($second['route'] ?? ''));
                                                                    if (count($routeSegs) >= 3 && $routeSegs[0] === 'admin' && end($routeSegs) === 'index') {
                                                                        $secondHref = url(trim((string)config('app.admin_prefix'), '/') . '/' . $routeSegs[1]);
                                                                    }
                                                                }
                                                            @endphp
                                                            @if($secondHref !== '')
                                                                <dd data-name="{{ $second['id'] }}"><a lay-href="{{ $secondHref }}">{{ __($second['name']) }}</a></dd>
                                                            @endif
                                                        @endcan
                                                    @endforeach
                                                </dl>
                                            </dd>
                                        @endcan
                                    @endif
                                @endforeach

                            </dl>
                        @else
                            @if(Route::has($menu['route']))
                                <a lay-href="{{ route($menu['route']) }}"  style="{{ $default_color }}">
                                    <i class="{{ $menu['icon'] }}"></i>
                                    <cite>{{ __($menu['name']) }}</cite></a>
                            @endif
                        @endif
                    </li>
                @endcan
            @endforeach
            <li data-name="666" class="layui-nav-item">
                <a href="https://www.dyystudy.com" target="_blank" lay-tips="第一页学堂" lay-direction="2" style="{{ $default_color }}">
                    <!-- <i class="icon-01z_icon3 my-slide-icon"></i> -->
                    <i class="icon-book my-slide-icon"></i>
                    <cite>{{ __('第一页学堂') }}</cite>
                </a>
            </li>
        </ul>
    </div>
</div>
