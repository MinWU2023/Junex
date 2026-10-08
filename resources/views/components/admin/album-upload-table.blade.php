<div class="layui-col-md12">
    <div class="layui-card">
        <div class="layui-card-header">{{ __('相册图片上传（支持批量上传）') }}</div>
        <div id="allPaths">
        </div>
        <div class="layui-card-body">
            <div class="layui-upload">

                <button type="button" id="upload-upload-uploadList" class="layui-chooseimg layui-btn layui-btn-normal"><i class="icon-photo2"></i><br>{{ __('选择图片') }}</button>


                <p class="care-tips" style="font-size: 12px; color: rgb(254, 112, 110); margin-top: 8px; margin-bottom: 15px;">{{ __('图片格式') }}: {{ __('图片统一为800*800px或者800*600px，文件大小200kb以下，文件类型应为(gif,jpg,jpeg,svg)') }}</p>
                <div class="layui-upload-list">
                    <table id="imglist" class="layui-table">
                        <thead>
                        <tr>
                            <th>{{ __('文件名') }}</th>
                            <th>{{ __('状态') }}</th>
                            <th>{{ __('操作') }}</th>
                        </tr>
                        </thead>
                        @inject('showThumbImagePresenter','App\Presenters\ShowThumbImagePresenter')
                        <tbody id="upload-upload-demoList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
