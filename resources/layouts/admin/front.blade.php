@if ($paginator->hasPages())
    <div class="page_num clearfix">
        @if ($paginator->onFirstPage())
            <a href="javascript:;" class="disabled"><i class="layui-icon"></i></a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"><i class="layui-icon"></i></a>
        @endif
        @foreach ($elements as $element)

            @if (is_string($element))
                <a href="javascript:;"><i class="fa fa-ellipsis-h"></i></a>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span>{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{$page}}</a>
                    @endif
                @endforeach
            @endif

        @endforeach
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"><i class="layui-icon"></i></a>
        @else
            <a href="javascript:;" class="disabled"><i class="layui-icon"></i></a>
        @endif

        <p>A total of<strong>{{$paginator->lastPage()}}</strong>pages</p>
    </div>
@endif
