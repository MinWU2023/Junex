<x-layui-layout>
    <body>
    <div class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags"
         style="padding:25px 25px 0 25px; ">
        <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
                <li class="layui-this">{{ __('基本设置') }}</li>
                @for($i=1;$i<4;$i++)
                    <li class="layui-this">{{ __('板块') }}{{ $i }}</li>
                @endfor
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <div class="layui-form-item">
                        <form>
                            @csrf
                            <div class="layui-form-item layui-hide">
                                <input type="button" lay-submit lay-filter="layuiadmin-app-create-form-submit"
                                       id="layuiadmin-app-create-form-submit" value="确认添加">
                            </div>
                        </form>
                    </div>

                    <?php
                    $base_fields = [
                        __('着陆页名称') => 'name',
                        'title' => 'title',
                        'keywords' => 'keywords',
                        'description' => 'description',
                    ];
                    ?>
                    @foreach($base_fields as $k=>$base_field)
                        <div class="layui-form-item">
                            <label class="layui-form-label">{{ $k }}</label>
                            <div class="layui-input-block">
                                <input type="text" name="{{ $base_field }}" lay-verify="required"
                                       placeholder="{{ __('请输入') }}{{ $k }}"
                                       autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    @endforeach
                </div>
                @for($i=1;$i<4;$i++)
                    <div class="layui-tab-item">
                        @for($j=1;$j<11;$j++)
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{ __('名称') }}{{ $j }}</label>
                                <div class="layui-input-block">
                                    <input type="text" name="plate_content_{{ $i }}[name][{{ $j }}]"
                                           placeholder="{{ __('请输入名称') }}{{ $j }}"
                                           autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        @endfor


                        @for($j=1;$j<11;$j++)
                            <div class="layui-form-item">
                                <x-admin.layui-upload label="{{ __('图片') }}{{ $j }}" pathName="plate_content_{{ $i }}[img][{{ $j }}]" watermark="0" path="" ></x-admin.layui-upload>
                            </div>
                        @endfor

                    </div>
                @endfor
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="{{ asset('/js/admin/admin.landpage.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
