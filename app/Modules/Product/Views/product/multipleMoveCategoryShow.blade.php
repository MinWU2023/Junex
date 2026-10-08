<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags" style="padding-top: 30px;">
        <div class="layui-form-item">
            <form>
                @csrf
                <div class="layui-form-item layui-hide">
                    <input type="button" lay-submit lay-filter="layuiadmin-app-multiple-move-category-form-submit" id="layuiadmin-app-multiple-move-category-form-submit" value="确认添加">
                </div>
            </form>
        </div>
        <div class="layui-form-item add-pr-15" id="app">
            <label class="layui-form-label">{{ __('请选择需要转移到的分类') }}</label>
            <div class="layui-input-block">
                <input type="hidden" name="ids" id="ids">
                <category-component id="0" type="product"></category-component>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ mix('/js/admin/admin.product.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
