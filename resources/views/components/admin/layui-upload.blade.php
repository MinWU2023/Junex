<div class="layui-form-item">
    <label class="layui-form-label">{{ $data['label'] }}</label>
    <div class="layui-input-block">
        <div class="layui-col-md12">
            <div class="layui-upload layui-upload-box">
                <button type="button"
                        class="layui-btn selectAlbumImage layui-chooseimg"
                        data-field="{{ $data['pathName'] }}">
                    <i class="icon-photo2"></i><br/>{{ __('上传图片') }}
                </button>
                <input class="path-name imgVal_{{ $data['pathName'] }}" value="{{ $data['path'] }}" type="hidden"
                       name="{{ $data['pathName'] }}">
                <div class="layui-upload-list upload_div_{{ $data['pathName'] }} layui-upload-listremoveImg">
                    @inject('showThumbImagePresenter','App\Presenters\ShowThumbImagePresenter')
                    @if(!empty($data['path']))
                        @php
                            $uploadThumb = (string)$showThumbImagePresenter->showImage($data['path']);
                            if ($uploadThumb !== '' && !str_starts_with($uploadThumb, 'http://') && !str_starts_with($uploadThumb, 'https://')) {
                                $uploadThumb = '/' . ltrim($uploadThumb, '/');
                            }
                        @endphp
                        <img class="layui-upload-img field_{{ $data['pathName'] }}" src="{{ $uploadThumb }}">
                    @endif
                    <a class="removeImg" field="{{ $data['pathName'] }}" href="javascript:void(0);"
                       style="{{ empty($data['path']) ? 'display:none;' : 'display:flex;' }}z-index:5;"
                       title="{{ __('删除') }}"><i class="layui-icon layui-icon-close"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
