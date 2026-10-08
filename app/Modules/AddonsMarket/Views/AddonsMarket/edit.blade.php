<x-layui-layout>
    <body>
    <div id="app" class="layui-card">
        <div class="layui-card-body">
            <div class="layui-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags">
                <div class="layui-tab layui-tab-card">

                    <div class="layui-tab-content">
                        <input type="hidden" id="id" value="{{ $id }}">
                        <div class="layui-tab-item layui-show">
                            <div class="layui-form-item">
                                <form>
                                    @csrf

                                    <div class="layui-form-item layui-hide">
                                        <input type="button" lay-submit lay-filter="layuiadmin-app-edit-form-submit"
                                               id="layuiadmin-app-edit-form-submit" value="{{ __('确认添加') }}">
                                    </div>
                                </form>
                            </div>

                            @foreach($configuration as $name=>$value)
                            <div class="layui-form-item">
                                <label class="layui-form-label">{{$name}}</label>
                                <div class="layui-input-block">
                                    <input type="text" value="{{$value}}" name="{{$name}}"
                                          autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            @endforeach
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="{{ mix('/js/admin/admin.addonsMarket.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection

    </body>
</x-layui-layout>
