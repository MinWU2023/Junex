<div class="layui-col-md12">
    <div class="layui-card">
        <div class="layui-card-header">{{ __('产品图片上传（支持批量上传）') }}<x-admin.form-required /></div>
        <div id="allPaths">
            @isset($product->productImages)
                @foreach($product->productImages as $key => $value)
                    <input type="hidden" name="imgPath[]" value="{{ $value->path }}">
                @endforeach
            @endif
        </div>
        <div class="layui-card-body">
            <div class="layui-upload">
                <button type="button" class="layui-chooseimg" id="upload-upload-uploadList" data-type="{{ $uploadType }}">
                    <i class="icon-photo2"></i><br/>{{ __('选择图片') }}</button>
                <x-admin.select-photo key="ad"></x-admin.select-photo>
                <p class="care-tips" style="font-size: 12px;color:#fe706e;margin-top:8px;margin-bottom:15px">{{ __('图片格式') }}: {{ __('图片统一为800*800px或者800*600px，文件大小200kb以下，文件类型应为(gif,jpg,jpeg)') }}</p>
                <div class="layui-upload-list">
                    <table id="imglist" class="layui-table">
                        <thead>
                        <tr>
                            <th>{{ __('文件名') }}</th>
                            <th>{{ __('主图') }}<x-admin.form-required /></th>
                            <th>{{ __('排序') }}<span style="color: #fe706e;">({{ __('数字越大越靠前') }})</span></th>
                            <th>{{ __('ALT属性') }}</th>
                            <th>{{ __('状态') }}</th>
                            <th>{{ __('操作') }}</th>
                        </tr>
                        </thead>
                        @inject('showThumbImagePresenter','App\Presenters\ShowThumbImagePresenter')
                        <tbody id="upload-upload-demoList">
                        @isset($product->productImages)
                            @foreach($product->productImages as $key => $value)
                                <tr id="upload-{{ $value->id }}">
                                    <td><img class="showProductImage" data="/{{ $value->path }}" src="/{{ $showThumbImagePresenter->showImage($value->path) }}"></td>
                                    <td><input style="display: block;" id="{{ $value->id }}" type="radio" name="is_main"
                                               value="{{ $value->path }}" title=""
                                               @if($value->is_main) checked="checked" @endif></td>
                                    <td>
                                        <input class="layui-input" type="text" name="imgSorts[]" value="{{ $value->sort }}">
                                    </td>
                                    <td>
                                        <input class="layui-input" type="text" style="width: 100%" name="imgAlts[]" value="{{ $value->alt }}">
                                    </td>
                                    <td><span style="color: #5FB878;">{{ __('上传成功') }}</span></td>
                                    <td>
                                        <input type="hidden" value="{{ $value->path }}">
                                        <button class="layui-btn layui-btn-mini layui-btn-danger upload-upload-demo-delete database-delete" >
                                            {{ __('删除') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
