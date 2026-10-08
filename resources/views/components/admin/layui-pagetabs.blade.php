<div class="layadmin-pagetabs" id="LAY_app_tabs">
    <div class="layui-icon layadmin-tabs-control icon-left" layadmin-event="leftPage"></div>
    <div class="layui-icon layadmin-tabs-control icon-right" layadmin-event="rightPage"></div>
    <div class="layui-icon layadmin-tabs-control icon-close">
        <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
            <li class="layui-nav-item" lay-unselect>
                <a href="javascript:;"></a>
                <dl class="layui-nav-child layui-anim-fadein">
                    <dd layadmin-event="closeThisTabs"><a href="javascript:;">{{ __('关闭当前标签页') }}</a></dd>
                    <dd layadmin-event="closeOtherTabs"><a href="javascript:;">{{ __('关闭其它标签页') }}</a></dd>
                    <dd layadmin-event="closeAllTabs"><a href="javascript:;">{{ __('关闭全部标签页') }}</a></dd>
                </dl>
            </li>
        </ul>
    </div>
    <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
        <ul class="layui-tab-title" id="LAY_app_tabsheader">
            <li lay-id="home/console.html" lay-attr="home/console.html" class="layui-this"><i class="layui-icon icon-home"></i></li>
        </ul>
    </div>
</div>
