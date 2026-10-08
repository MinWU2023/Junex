<x-layui-layout>
    <body>
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <div style="font-size:16px;font-weight:bold;line-height:38px;">{{ __('添加热门款式Tab') }}</div>
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
                    <form class="test-table-reload-btn layui-form" method="post" action="{{ route('admin.hotStyleTab.store') }}">
                        @csrf

                        <x-admin.multilingualism
                            :translateField="config('multilingual.hotStyleTab.value.translateField')"
                            value=""
                        >
                        </x-admin.multilingualism>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('标识') }}</label>
                            <div class="layui-input-block">
                                <input type="text" name="tab_key" value="{{ old('tab_key') }}" class="layui-input" placeholder="new / best / yoga_sets" lay-verify="required">
                            </div>
                        </div>

                        @include('Setting.Views.hotStyleTab._source_fields', ['model' => (object)['source_type' => old('source_type', 'flag'), 'product_source' => old('product_source', 'hot'), 'product_category_id' => old('product_category_id')]])

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('排序') }}</label>
                            <div class="layui-input-block">
                                <input type="number" name="sort" value="{{ old('sort', 0) }}" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ __('启用') }}</label>
                            <div class="layui-input-block">
                                <select name="active">
                                    <option value="1" @if((string)old('active','1')==='1') selected @endif>{{ __('启用') }}</option>
                                    <option value="0" @if((string)old('active')==='0') selected @endif>{{ __('禁用') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn layuiadmin-btn-list" type="submit">{{ __('保存') }}</button>
                                <a class="layui-btn layui-btn-primary" href="{{ route('admin.hotStyleTab.index') }}">{{ __('返回') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        @include('Setting.Views.hotStyleTab._source_scripts')
    @endsection
    </body>
</x-layui-layout>
