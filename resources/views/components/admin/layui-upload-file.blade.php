<div class="layui-col-md12">
    <div class="layui-card">
        <div style="display:flex;display: inline-flex;">
            <div class="layui-card-header" style="padding: 9px 15px;width: 130px;box-sizing: border-box;">{{ $data['label'] }}</div>
            <div class="layui-card-body">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-normal layui-chooseimg" id="upload-one-uploadFileList" ><i class="icon-folder"></i><br/>{{ __('选择文件') }}</button>
                    <p class="care-tips" style="font-size: 12px;color: #fe706e;margin-bottom:15px;margin-top:8px">{{ __('支持上传 mp4，也可手动填写链接') }}</p>
                </div>
            </div>
        </div>
        <div id="allFilePaths">
            <div class="layui-form-item">
                <label class="layui-form-label">{{ __('当前文件链接') }}</label>
                <div class="layui-input-block">
                    <input name="{{ $data['pathName'] }}" id="fileOnePath" value="{{ $data['path'] }}"  placeholder="{{ __('请输入url链接') }}" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
    </div>
</div>
