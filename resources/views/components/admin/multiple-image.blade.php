<div class="layui-col-md12">
    <div class="layui-card">
        <div class="layui-card-header">{{ $display_name }}</div>
        <div id="allPaths-{{ $display_name }}">
            @foreach($images as $key => $value)
                <input type="hidden" name="{{ $name }}[imgPath][]" class="imgPaths" value="{{ $value['path'] }}">
            @endforeach
        </div>
        <div class="layui-card-body">
            <div class="layui-upload">
                <button type="button" class="layui-btn layui-btn-normal multiple-image-upload" display_name="{{ $display_name }}" name="{{ $name }}">{{ __('选择图片') }}</button>
                <p class="care-tips" style="font-size: 12px;color: red;">{{ __('图片格式') }}: {{ __('图片统一为800*800px或者800*600px，文件大小200kb以下，文件类型应为(gif,jpg,jpeg)') }}</p>
                <div class="layui-upload-list">
                    <table id="imglist" class="layui-table">
                        <thead>
                        <tr>
                            <th>{{ __('文件名') }}</th>
                            <th>{{ __('主图') }}</th>
                            <th>{{ __('排序') }}</th>
                            <th>{{ __('ALT属性') }}</th>
                            <th>{{ __('状态') }}</th>
                            <th>{{ __('操作') }}</th>
                        </tr>
                        </thead>
                        @inject('showThumbImagePresenter','App\Presenters\ShowThumbImagePresenter')
                        <tbody id="upload-upload-demoList-{{ $display_name }}">
                        @foreach($images as $key => $value)
                            <tr id="upload-{{ $value['path'] }}">
                                <td><img class="showProductImage" data="/{{ $value['path'] }}" src="/{{ $showThumbImagePresenter->showImage($value['path']) }}"></td>
                                <td><input style="display: block;" id="{{ $value['path'] }}" type="radio" name="{{ $name }}[is_main][]"
                                           value="{{ $value['path'] }}" title=""
                                           @if($value['is_main']) checked="checked" @endif></td>
                                <td>
                                    <input class="layui-input" type="text" name="{{ $name }}[imgSorts][]" value="{{ $value['sort'] }}">
                                </td>
                                <td>
                                    <input class="layui-input" type="text" style="width: 100%" name="{{ $name }}[imgAlts][]" value="{{ $value['alt'] }}">
                                </td>
                                <td><span style="color: #5FB878;">{{ __('上传成功') }}</span></td>
                                <td>
                                    <input type="hidden" value="{{ $value['path'] }}">
                                    <button class="layui-btn layui-btn-mini layui-btn-danger upload-upload-demo-delete database-delete">
                                        {{ __('删除') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
