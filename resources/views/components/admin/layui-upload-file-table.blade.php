<div class="layui-col-md12">
    <div class="layui-card">
        <div class="layui-card-header">{{ __('附件上传（支持批量上传）') }}</div>
        <div id="allFilePaths">
            @foreach($files as $key => $value)
                <input type="hidden" name="filePath[]" value="{{ $value->path }}">
            @endforeach
        </div>
        <div class="layui-card-body">
            <div class="layui-upload">
                <button type="button" class="layui-chooseimg" id="upload-upload-uploadFileList"><i class="icon-folder"></i><br/>{{ __('选择文件') }}</button>
                <p class="care-tips" style="font-size: 12px;color:#fe706e;margin-top:8px;margin-bottom:15px">{{ __('文件类型应为(zip,pdf,rar,png,jpg,gif,jpeg)') }}</p>
                <div class="layui-upload-list">
                    <table id="filelist" class="layui-table">
                        <thead>
                        <tr>
                            <th>{{ __('文件名') }}</th>
                            <th>{{ __('排序') }}</th>
                            <th>{{ __('状态') }}</th>
                            <th>{{ __('操作') }}</th>
                        </tr>
                        </thead>
                        <tbody id="upload-upload-fileList">
                        @foreach($files as $key => $value)
                            <tr id="upload-{{ $value->id }}">
                                <td><input class="layui-input" type="text" name="fileNames[]" value="{{ $value->name }}"></td>
                                <td>
                                    <input class="layui-input" type="text" name="fileSorts[]" value="{{ $value->sort }}">
                                </td>
                                <td><span style="color: #5FB878;">{{ __('上传成功') }}</span></td>
                                <td>
                                    <input type="hidden" value="{{ $value->path }}">
                                    <button class="layui-btn layui-btn-mini layui-btn-danger upload-upload-demo-delete upload-product-file-delete" >
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
