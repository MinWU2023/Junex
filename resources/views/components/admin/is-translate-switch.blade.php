@props(['model' => null, 'trSuccessAt' => ''])
@if(in_array('Translate', app('myAddons')) && auth()->user()->hasRole('超级管理员'))
    <div class="layui-form-item">
        <label class="layui-form-label">{{ __('是否开启翻译') }}</label>
        <div class="layui-input-block">
            @if($model && (int)$model->is_translate === 1)
                <input type="checkbox" name="is_translate" lay-skin="switch" lay-text="开启|关闭">
                <span class="help-block">
                    <i class="fa fa-info-circle"></i>&nbsp;{{ __('翻译成功') }}
                    @if($trSuccessAt)
                        ({{ __('最近翻译时间') }}{{ $trSuccessAt }})
                    @endif
                </span>
            @elseif($model && (int)$model->is_translate === 2)
                <input type="checkbox" checked name="is_translate" value="1" lay-skin="switch" lay-text="开启|关闭">
                <span class="help-block">
                    <i class="fa fa-info-circle"></i>&nbsp;{{ __('翻译任务失败,请重新翻译') }}
                </span>
            @elseif($model && (int)$model->is_translate === 3)
                <input type="checkbox" disabled checked lay-skin="switch" lay-text="开启|关闭">
                <span class="help-block">
                    <i class="fa fa-info-circle"></i>&nbsp;{{ __('正在进行翻译，请稍候...') }}
                </span>
            @else
                <input type="checkbox" name="is_translate" value="1" lay-skin="switch" lay-text="开启|关闭">
            @endif
        </div>
    </div>
@endif
