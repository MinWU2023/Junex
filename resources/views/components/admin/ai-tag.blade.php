<div class="layui-card-header">{{ __('Ai推荐关键词') }}</div>
<div class="layui-card-body">
    <div class="layui-btn-container layadmin-layer-demo">
        @foreach($tags as $tag)
            <span class="layui-btn layui-btn-primary add-tag" >{{ ucfirst($tag) }}</span>
        @endforeach
    </div>
</div>
