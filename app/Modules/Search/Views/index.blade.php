<x-layui-layout>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card layadmin-serach-main">
                    <div class="layui-card-header">
                        <p style="font-size: 18px;">
                            <span style="color: #01AAED">{{ $keywords }}</span> {{ __('查询到') }}
                            <strong>{{ $searchDetails->total() }}</strong> {{ __('个结果') }}
                        </p>
                    </div>
                    <div class="layui-card-body">

                        <ul class="layadmin-serach-list layui-text">
                            @foreach($searchDetails as $key => $searchDetail)
                                <li>
                                    <div class="layui-serachlist-text">
                                        <h3><a class="searchType" data-attr="{{ $searchDetail->type }}"
                                               data-active="{{ $searchDetail->active }}"
                                               href="javascript:;">{{ $searchDetail->name }}</a></h3>
                                        <p>{{ __('创建时间') }}： {{ $searchDetail->created_at }}</p>
                                        <p>{{ __('最新更新时间') }}： {{ $searchDetail->created_at }}</p>
                                        <p>
                                            <span class="layui-badge layui-bg-green">{{ $searchDetail->type }}</span>
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                            {{ $searchDetails->appends(['keywords' => $keywords])->links() }}
                        </ul>
                        <div id="LAY-template-search-page" style="text-align: center;"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('css')
        <link rel="stylesheet" href="{{asset('/css/admin/admin.template.css') }}" media="all">
    @endsection
    @section('scripts')
        <script>
            $(function () {
                $('.searchType').on('click', function () {
                    var type = $(this).attr('data-attr')
                    var active = $(this).attr('data-active')
                    var keyword = $(this).text()
                    switch (type) {
                        case 'Product':
                            active > 0 ?
                                top.layui.index.openTabsPage('/' + window.admin_prefix + '/product?name=' + keyword, __('产品列表')):
                                top.layui.index.openTabsPage('/' + window.admin_prefix + '/product/trash?name=' + keyword, __('产品回收站'))
                            break
                        case 'ProductCategory':
                            top.layui.index.openTabsPage('/' + window.admin_prefix + '/product/category?name=' + keyword, __('分类列表'));
                            break
                        case 'ProductTag':
                            top.layui.index.openTabsPage('/' + window.admin_prefix + '/product/tag?name=' + keyword, __('关键词数据'));
                            break
                        case 'Page':
                            active > 0 ?
                                top.layui.index.openTabsPage('/' + window.admin_prefix + '/page?name=' + keyword, __('单页面列表')) :
                                top.layui.index.openTabsPage('/' + window.admin_prefix + '/page/trash?name=' + keyword, __('单页面回收站'))
                            break
                        case 'ArticleCategory':
                            top.layui.index.openTabsPage('/' + window.admin_prefix + '/article/category?name=' + keyword, __('文章分类列表'));
                            break
                        case 'Article':
                            active > 0 ?
                                top.layui.index.openTabsPage('/' + window.admin_prefix + '/article?name=' + keyword, __('文章列表')) :
                                top.layui.index.openTabsPage('/' + window.admin_prefix + '/article/trash?name=' + keyword, __('文章回收站'))
                            break
                        case 'Blog':
                            active > 0 ?
                                top.layui.index.openTabsPage('/' + window.admin_prefix + '/blog?name=' + keyword, __('博客列表')) :
                                top.layui.index.openTabsPage('/' + window.admin_prefix + '/blog/trash?name=' + keyword, __('博客回收站'))
                            break
                        case 'BlogTag':
                            top.layui.index.openTabsPage('/' + window.admin_prefix + '/blog/tag?name=' + keyword, __('文章分类列表'));
                            break
                        case 'BlogCategory':
                            top.layui.index.openTabsPage('/' + window.admin_prefix + '/blog/category?name=' + keyword, __('博客分类列表'));
                            break
                        case 'DownloadCategory':
                            top.layui.index.openTabsPage('/' + window.admin_prefix + '/download/category?name=' + keyword, __('博客分类列表'));
                            break
                    }
                })
            })
        </script>
    @endsection
</x-layui-layout>
