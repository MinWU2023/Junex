<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags"
         style="padding:15px 25px 0 25px;">
        <div class="layui-form-item">
            <form>
                @csrf
                <div class="layui-form-item layui-hide">
                    <input type="button" lay-submit lay-filter="layuiadmin-app-multiple-move-album-form-submit" id="layuiadmin-app-multiple-move-album-form-submit" value="{{ __('确认添加') }}">
                </div>
            </form>
        </div>
        <input type="hidden" name="ids" id="ids">
        <div class="layui-form-item " id="app">
            <label class="layui-form-label">{{ __('相册') }}</label>
            <div class="layui-input-block">
                <select name="photo_album_id" lay-verify="required">
                    <option value=""></option>
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}">{{ $album->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="{{ asset('/js/admin/admin.picture.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
