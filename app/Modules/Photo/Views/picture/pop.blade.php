<x-layui-layout>
    <input type="hidden" id="token" value="{{ csrf_token() }}">
    <input type="hidden" id="select_album_id" value="{{ $select_album_id }}">
    <div class="layui-photo_box">
        <div class="layui-photo-fl">
            <ul>
                <li  class="@if($select_album_id==0) on @endif radio_album" data-id="0">{{ __('全部图片') }}
                    <div class="yuan"><span></span><span></span><span></span></div>
                </li>
                @foreach($albums as $album)
                    <li  class="@if($select_album_id==$album->id) on @endif radio_album" data-id="{{ $album->id }}">{{ $album->name }}
                        <div class="yuan"><span></span><span></span><span></span></div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="layui-photo-fr">
            <div class="choose-button">
                <button type="button" class="ivu-btn ml5"  disabled="disabled"><span id="use_images">{{ __('使用选中图片') }}</span></button>
                <div class="ivu-upload ml5">
                    <div class="ivu-upload ivu-upload-select">
                        {{-- 实际上传在弹出的相册上传页中完成，这里的 input 仅占位，避免用户误以为直接选文件就会上传 --}}
                        <input type="file" class="ivu-upload-input" style="display: none;">
                        <button type="button" class="ivu-btn"><span>{{ __('上传图片') }}</span></button>
                    </div>
                </div>
                <button type="button" class="ivu-btn ml5" id="create_album"><span>{{ __('创建相册分类') }}</span></button>
                <!-- <button type="button" class="ivu-btn ivu-btn-error ml5"><span id="remove_images">{{ __('删除图片') }}</span></button> -->
                <form class="layui-form" action="">
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <select name="photo_album_move" lay-filter="photo_move">
                                <option value="0" selected="">{{ __('图片移动至') }}</option>
                                @foreach($albums as $album)
                                    <option value="{{ $album->id }}">{{ $album->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="choose-photo" id="table_photos">
                <dl>
                    @foreach($images as $image)
                        <input style="display: none" class="radio_image_{{ $image->id }}" data-id="{{ $image->id }}" type="checkbox" name="radio_image"  value="{{ $image->true_path }}">
                        <dd class="select_image" data-id="{{ $image->id }}">
                            <div class="dd_image"><img src="{{ asset($image->true_path) }}"></div>
                        </dd>
                    @endforeach
                </dl>
            </div>
            {{ $images->links('layouts.admin.front') }}
        </div>

        @section('css')
            <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
        @endsection

        @section('scripts')
            @if($from_tinymce)
                <script src="{{ asset('/js/admin/admin.picture-tinymce.js') }}?v={{ filemtime(public_path('js/admin/admin.picture-tinymce.js')) }}"></script>
            @else
                <script src="{{ asset('/js/admin/admin.picture.js') }}?v={{ filemtime(public_path('js/admin/admin.picture.js')) }}"></script>
            @endif
        @endsection
</x-layui-layout>
