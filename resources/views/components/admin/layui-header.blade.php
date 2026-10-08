<div class="layui-header">
    <ul class="layui-nav layui-layout-left">
        <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="{{ __('侧边伸缩') }}">
                <i class="icon-indent" id="LAY_app_flexible"
                   style="font-size:20px;color:#5C6B77;line-height: 60px;"></i>
            </a>
        </li>
        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="/" target="_blank" title="{{ __('前台') }}">
                <i class="layui-icon layui-icon-website" style="font-size:19px;color:#5C6B77;line-height: 60px;"></i>
            </a>
        </li>
        <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="{{ __('刷新') }}">
                <i class="icon-rotate" style="font-size:17px;color:#5C6B77;line-height: 60px;"></i>
            </a>
        </li>
        @if (Route::has('admin.search') && app('settings')['setting']->website_id)
            <li class="layui-nav-item layui-hide-xs" lay-unselect>
                <input type="text" placeholder="{{ __('搜索') }}..." autocomplete="off" class="layui-input layui-input-search"
                       layadmin-event="serach" lay-action="{{ route('admin.search') }}?keywords=">
            </li>
        @endif
    </ul>
    <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right"
        style="display: flex;align-items: center;">
        @if(Route::has('admin.aiVideo.aiGen'))
            <li class="layui-nav-item layui-hide-xs chatgpt-item" lay-unselect
                style="display: flex;align-items: center;">
                    <?php
                    $generate_count = \Addons\AiVideo\Models\AiVideo::query()->where('status', 0)->first();
                    $view_count =  \Addons\AiVideo\Models\AiVideo::query()->where([
                        'status' => 1,
                        'is_view' => 0
                    ])->first();
                    ?>
                @if($generate_count)
                    <div class="video_generate"><a href="/nosay/aiVideo/{{ $generate_count->product_id }}/generate" target="_blank"><i
                                class="layui-icon layui-icon-loading-1 layui-anim layui-anim-rotate layui-anim-loop"></i><span>{{ __('视频生成中') }}</span></a>
                    </div>
                @endif
                @if($view_count)
                <div class="video_complete"><a  href="/nosay/aiVideo/{{ $view_count->product_id }}/generate" target="_blank">
                        <svg t="1742982496083" class="icon" viewBox="0 0 1024 1024" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" p-id="8199" width="16" height="16">
                            <path
                                d="M512 0C229.23 0 0 229.23 0 512s229.23 512 512 512 512-229.23 512-512S794.77 0 512 0z m295.53 339.55l-313.17 382-21.6 26.34a50.46 50.46 0 0 1-7.17 7.15c-0.65 0.52-1.3 1-2 1.51-1.08 0.79-2.19 1.52-3.32 2.22-0.57 0.35-1.15 0.69-1.73 1s-1.26 0.7-1.91 1c-1.2 0.61-2.43 1.18-3.67 1.69a51 51 0 0 1-5.05 1.74c-1.38 0.39-2.77 0.74-4.17 1a50.812 50.812 0 0 1-9.47 0.95h-0.07a51.39 51.39 0 0 1-7.19-0.5 49.67 49.67 0 0 1-20.53-7.8 48.89 48.89 0 0 1-4.11-3L200.19 589a50 50 0 0 1-7-70.37 50 50 0 0 1 70.37-7l124.91 102.46a50 50 0 0 0 70.36-7l271.36-331a50 50 0 0 1 70.37-7 50 50 0 0 1 6.97 70.46z"
                                p-id="8200" fill="#fff"></path>
                        </svg>
                        <span>{{ __('视频生成完成') }}</span></a></div>
                @endif
            </li>
        @endif
        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="/manual.pdf" target="_blank" download="/manual.pdf"
               style="color: #5C6B77;line-height:60px; display: flex;align-items: center;height: 60px;">
                <i class="icon-download" style="font-size:18px;margin-right:5px;"></i> <span style="line-height:20px;">{{ __('通用手册') }}</span>
            </a>
        </li>
        @if(app('settings')['setting']->operation_guide)
        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="{{ asset(app('settings')['setting']->operation_guide) }}" target="_blank" download="{{ app('settings')['setting']->operation_guide }}"
               style="color: #5C6B77;line-height:60px; display: flex;align-items: center;height: 60px;">
                <i class="icon-download" style="font-size:18px;margin-right:5px;"></i> <span style="line-height:20px;">{{ __('操作指南') }}</span>
            </a>
        </li>
        @endif
        <!-- <li class="layui-nav-item" lay-unselect>
           <a lay-href="app/message/index.html" layadmin-event="message" lay-text="消息中心">
               <i class="icon-notice" style="font-size:19px;color: #5C6B77;line-height:60px;"></i>
              <span class="layui-badge-dot"></span>
         </a>
        </li> -->
        <li class="layui-nav-item layui-hide-xs layui-change-color" lay-unselect>
            <a href="javascript:;">
                <i class="icon-settings" style="font-size:18px;color: #5C6B77;line-height:60px;"></i>
            </a>

            <dl class="layui-nav-child sidebar-color">
                <dt>{{ __('侧导航背景') }}</dt>
                <dd class="global-color" data-color="black" style="background:#101427;"></dd>
                <dd class="global-color" data-color="blue" style="background:#656EE6;"></dd>
                <dd class="global-color" data-color="white" style="background:#fff;"></dd>
                <dd class="global-color" data-color="grey" style="background:f6f8fc;"></dd>
            </dl>
        </li>
        <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:void(0);" layadmin-event="fullscreen">
                <i class="icon-max" style="font-size:18px;color: #5C6B77;line-height:60px;"></i>
            </a>
        </li>
        <li class="layui-nav-item layui-username" lay-unselect style="margin-right: 10px;">
            <a href="javascript:;">
                <cite>{{ $data['name'] }}</cite>
            </a>
            <dl class="layui-nav-child">
                <dd><a lay-href="{{ route('admin.password') }}">{{ __('修改密码') }}</a></dd>
                <dd layadmin-event="logout" style="text-align: center;"><a>{{ __('退出') }}</a></dd>
            </dl>
        </li>
    </ul>
</div>
<script type="text/javascript" src="{{asset('/report/js/jquery.min.js')}}"></script>

