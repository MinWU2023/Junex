<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <div style="font-size:16px;font-weight:bold;line-height:38px;">{{ __('编辑精彩动态（关联博客）') }}</div>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="layui-bg-red" style="padding:10px;margin-bottom:10px;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="table-reload-btn">
                    <form class="test-table-reload-btn layui-form" method="post" action="{{ route('admin.excitingUpdate.update', $model->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('选择博客') }}</label>
                            <div class="layui-input-block">
                                <select name="blog_id" lay-verify="required" lay-search>
                                    <option value="">{{ __('请选择博客') }}</option>
                                    @foreach($blogs as $blog)
                                        <option value="{{ $blog->id }}" @if((string)old('blog_id', (string)$model->blog_id)===(string)$blog->id) selected @endif>
                                            #{{ $blog->id }} {{ $blog->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('排序') }}</label>
                            <div class="layui-input-block">
                                <input type="number" name="sort" value="{{ old('sort', $model->sort) }}" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('启用') }}</label>
                            <div class="layui-input-block">
                                <select name="active">
                                    <option value="1" @if((string)old('active', (string)$model->active)==='1') selected @endif>{{ __('启用') }}</option>
                                    <option value="0" @if((string)old('active', (string)$model->active)==='0') selected @endif>{{ __('禁用') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn layuiadmin-btn-list" type="submit">{{ __('保存') }}</button>
                                <a class="layui-btn layui-btn-primary" href="{{ route('admin.excitingUpdate.index') }}">{{ __('返回') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            layui.use(['form'], function () {
                layui.form.render();
            });
        </script>
    @endsection
    </body>
</x-layui-layout>
