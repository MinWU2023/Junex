@php
    $paths = $multiple
        ? array_slice(array_values((array)$value), 0, $max)
        : (($value ?? '') !== '' ? [(string)$value] : []);
    $inputName = $multiple ? rtrim($name, '[]') . '[]' : $name;
@endphp
<div class="layui-form-item admin-image-upload"
     id="{{ $uid }}"
     data-name="{{ $name }}"
     data-input-name="{{ $inputName }}"
     data-multiple="{{ $multiple ? '1' : '0' }}"
     data-max="{{ $max }}"
     data-required="{{ $required ? '1' : '0' }}"
     data-limit="{{ $limit ? '1' : '0' }}"
     data-watermark="{{ $watermark ? '1' : '0' }}"
     data-upload-type="{{ $uploadType }}"
     data-album="{{ $album ? '1' : '0' }}"
     data-accept="{{ $accept }}">
    <label class="layui-form-label">{{ $label }}@if($required)<span style="color:#FF5722;">*</span>@endif</label>
    <div class="layui-input-block">
        <div class="aui-dropzone{{ count($paths) >= $max ? ' aui-full' : '' }}">
            <input type="file"
                   class="aui-file"
                   accept="{{ $accept }}"
                   @if($multiple) multiple @endif
                   hidden>
            <div class="aui-list">
                @foreach($paths as $path)
                    @php
                        $preview = front_image_url($path);
                    @endphp
                    <div class="aui-item" data-path="{{ $path }}">
                        <img src="{{ $preview }}" alt="">
                        <button type="button" class="aui-remove" title="{{ __('删除') }}">
                            <i class="layui-icon layui-icon-close"></i>
                        </button>
                        @if($multiple)
                            <input type="hidden" name="{{ $inputName }}" value="{{ $path }}">
                        @endif
                    </div>
                @endforeach
            </div>

            @unless($multiple)
                <input type="hidden"
                       class="aui-single-input path-name imgVal_{{ $name }}"
                       name="{{ $name }}"
                       value="{{ $paths[0] ?? '' }}">
            @endunless

            <div class="aui-actions{{ count($paths) >= $max ? ' aui-hidden' : '' }}">
                <button type="button" class="layui-btn layui-chooseimg aui-pick">
                    <i class="icon-photo2"></i><br/>{{ __('上传图片') }}
                </button>
                @if($album)
                    <button type="button" class="layui-btn layui-btn-primary aui-album" style="margin-left:8px;">
                        {{ __('相册选择') }}
                    </button>
                @endif
            </div>
        </div>
        <div class="layui-word-aux aui-hint">{{ $hint }}@if($multiple) · {{ __('最多') }} {{ $max }} {{ __('张') }}@endif</div>
    </div>
</div>

@once
    <style>
        .admin-image-upload .aui-dropzone {
            min-height: 120px;
            padding: 12px;
            border: 1px dashed #d3d3d3;
            border-radius: 4px;
            background: #fff;
            transition: border-color .15s, background .15s;
        }
        .admin-image-upload .aui-dropzone.aui-dragover {
            border-color: #1E9FFF;
            background: #f5fbff;
        }
        .admin-image-upload .aui-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: flex-start;
        }
        .admin-image-upload .aui-item {
            position: relative;
            width: 120px;
            height: 110px;
            border: 1px solid #eee;
            border-radius: 4px;
            overflow: hidden;
            background: #fafafa;
        }
        .admin-image-upload .aui-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .admin-image-upload .aui-remove {
            position: absolute;
            right: -1px;
            top: -1px;
            width: 22px;
            height: 22px;
            border: 0;
            border-radius: 0 0 0 6px;
            background: rgba(0, 0, 0, .55);
            color: #fff;
            cursor: pointer;
            line-height: 22px;
            padding: 0;
        }
        .admin-image-upload .aui-remove:hover { background: #FF5722; }
        .admin-image-upload .aui-remove i { font-size: 12px; }
        .admin-image-upload .aui-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .admin-image-upload .aui-actions.aui-hidden,
        .admin-image-upload .aui-full .aui-actions { display: none; }
        .admin-image-upload .aui-hint { margin-top: 6px; }
        .admin-image-upload .aui-uploading { opacity: .6; pointer-events: none; }
    </style>
    <script defer src="{{ asset('js/admin/admin.image-upload.js') }}"></script>
@endonce
