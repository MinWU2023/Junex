<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
        <div class="layui-tab layui-tab-card" style="padding-top:0">
            <div class="layui-tab-content"  style="padding:5px;padding-top:0;">
                <div class="layui-form-item">
                    <form>
                        @csrf
                        <div class="layui-form-item layui-hide">
                            <input type="button" lay-submit lay-filter="layuiadmin-app-upload-form-submit"
                                   id="layuiadmin-app-upload-form-submit" value="{{ __('确认添加') }}">
                        </div>
                    </form>
                </div>
                <input type="hidden" name="album_id" value="{{ $model->id }}">
                <x-admin.album-upload-table></x-admin.album-upload-table>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            window.__albumUploadExts = 'jpg|jpeg|png|gif|bmp|svg';
        </script>
        <script src="{{ asset('/js/admin/admin.album.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
