<x-layui-layout>
    <body>
    <div id="app" class="layui-form base-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags" style="padding:25px 25px  0 25px;">
        <div  class="layui-form-item">
            <form>
                @csrf
                <x-admin.multilingualism
                    :translateField="config('multilingual.product_attribute.value.translateField')"
                    value=""
                >
                </x-admin.multilingualism>
                <div class="layui-form-item layui-hide">
                    <input type="button" lay-submit lay-filter="layuiadmin-app-create-form-submit" id="layuiadmin-app-create-form-submit" value="{{ __('确认添加') }}">
                </div>
            </form>
        </div>


        {{--        <div class="layui-form-item add-space-20">--}}
        {{--            <label class="layui-form-label">分类</label>--}}
        {{--            <div class="layui-input-block">--}}
        {{--                <select name="category_name">--}}
        {{--                <option>请选择</option>--}}
        {{--                @foreach($categories as $key => $value)--}}
        {{--                        <option value="{{ $value }}" @if(!$key) selected @endif>{{ $value }}</option>--}}
        {{--                    @endforeach--}}
        {{--                </select>--}}
        {{--            </div>--}}
        {{--        </div>--}}


        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('排序（数字越大越靠前）') }}<x-admin.form-required /></label>
            <div class="layui-input-block">
                <input type="number" value="0" name="sort" lay-verify="required" placeholder="{{ __('请输入排序数字') }}" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">{{ __('可选属性值') }}</label>
            <div class="layui-input-block">
                <div class="attribute-tags-container">
                    <div class="tags-display" id="tags-display"></div>
                    <div class="tag-input-wrapper">
                        <input type="text" id="tag-input" placeholder="{{ __('输入属性值后按回车添加') }}" autocomplete="off" class="layui-input">
                    </div>
                    <input type="hidden" name="options" id="options-hidden" value="">
                </div>
                <div class="layui-form-mid layui-word-aux">{{ __('填写后产品编辑时将显示为多选标签下拉框') }}</div>
            </div>
        </div>
    </div>
    <style>
        .attribute-tags-container {
            border: 1px solid #e6e6e6;
            border-radius: 2px;
            padding: 5px;
            min-height: 38px;
            background: #fff;
        }
        .tags-display {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-bottom: 5px;
        }
        .tag-item {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            margin: 2px;
            background: #009688;
            color: #fff;
            border-radius: 2px;
            cursor: default;
        }
        .tag-remove {
            margin-left: 5px;
            cursor: pointer;
            font-size: 12px;
        }
        .tag-remove:hover {
            color: #ff5722;
        }
        .tag-input-wrapper {
            margin-top: 5px;
        }
        #tag-input {
            border: none;
            outline: none;
            box-shadow: none;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tagInput = document.getElementById('tag-input');
            const tagsDisplay = document.getElementById('tags-display');
            const optionsHidden = document.getElementById('options-hidden');

            function updateHiddenInput() {
                const tags = Array.from(tagsDisplay.querySelectorAll('.tag-item')).map(tag => tag.dataset.value);
                optionsHidden.value = tags.join(',');
            }

            function addTag(value) {
                value = value.trim();
                if (!value) return;

                // 检查是否已存在
                const existingTags = Array.from(tagsDisplay.querySelectorAll('.tag-item')).map(tag => tag.dataset.value);
                if (existingTags.includes(value)) {
                    tagInput.value = '';
                    return;
                }

                const tagElement = document.createElement('span');
                tagElement.className = 'layui-badge-rim tag-item';
                tagElement.dataset.value = value;
                tagElement.innerHTML = `${value} <i class="layui-icon layui-icon-close tag-remove"></i>`;

                tagElement.querySelector('.tag-remove').addEventListener('click', function() {
                    tagElement.remove();
                    updateHiddenInput();
                });

                tagsDisplay.appendChild(tagElement);
                tagInput.value = '';
                updateHiddenInput();
            }

            tagInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addTag(tagInput.value);
                }
            });
        });
    </script>
    </div>

    @section('scripts')
        {{--        <script src="{{ asset('js/app.js') }}"></script>--}}
        <script src="{{ mix('/js/admin/admin.attribute.js') }}"></script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.form.css') }}" media="all">
    @endsection
    </body>
</x-layui-layout>
