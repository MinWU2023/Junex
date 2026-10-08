<x-layui-layout>
    <body>
    <style>
        html{
            background: #fff;
        }
        .msg-box{
            padding: 0 20px;
            margin-left: 0;
            min-height: auto;
        }

        .msg-box .title{
            font-size: 15px;
            color: #666;
            padding: 0;
            background-color: transparent;
            height: auto;
            line-height: 1;
            position: relative;
            padding-left: 16px;
            display: block;
        }
        .msg-box .title::before{
            content: '';
            width: 6px;
            height: 6px;
            background-color: #656EE6;
            position: absolute;
            left: 0;
            top: 4px;
            border-radius: 50%;
        }

        .msg-box .text{
            font-size: 14px;
            color: #555555;
            font-style: normal;
            word-break:break-word;
            display: inline-block;
            min-width: 306px;
            background-color: #f7f7f7;
            margin: 10px 0 0 16px;
            padding: 0 15px;
            box-sizing: border-box;
            line-height: 30px;
        }
        .msg-box .item{
            margin-bottom: 20px;
        }

        .msg-box .item:last-child{
            margin-bottom: 0;
        }

        .msg-box .products-block{
            margin-top: 8px;
        }

        .msg-box .product-list{
            margin: 10px 0 0 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 640px;
        }

        .msg-box .product-row{
            display: flex;
            align-items: center;
            gap: 12px;
            background-color: #f7f7f7;
            padding: 10px 12px;
            box-sizing: border-box;
        }

        .msg-box .product-row .thumb{
            width: 64px;
            height: 64px;
            flex: 0 0 64px;
            overflow: hidden;
            background: #fff;
            border: 1px solid #e8e8e8;
        }

        .msg-box .product-row .thumb img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .msg-box .product-row .meta{
            flex: 1;
            min-width: 0;
        }

        .msg-box .product-row .meta .name{
            font-size: 14px;
            color: #333;
            line-height: 1.4;
            word-break: break-word;
        }

        .msg-box .product-row .meta .qty{
            margin-top: 6px;
            font-size: 13px;
            color: #666;
        }

        .font-20{
            font-size: 21px !important;
            margin-right: 1px !important;
        }
    </style>
    <div class="layui-form" lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags" style="padding-top: 30px;">
        <div class="layui-form-item">
            <div class="layui-input-block msg-box">
                <p class="item">
                    <button type="button" class="layui-btn title">{{ __('询盘标题') }}:</button>
                    <i class="text">{{ $model->title }}</i>
                </p>
                <p class="item">
                    <button type="button" class="layui-btn title">{{ __('询盘内容') }}:</button>
                    <i class="text">{{ mb_convert_encoding($model->content, 'UTF-8', 'UTF-8') }}</i>
                </p>
                @if($model->msg_name)
                    <p class="item">
                        <button type="button" class="layui-btn title">{{ __('询盘人姓名') }}:</button>
                        <i class="text">{{ $model->msg_name }}</i>
                    </p>
                @endif
                @if($model->msg_company)
                    <p class="item">
                        <button type="button" class="layui-btn title">{{ __('询盘人公司') }}:</button>
                        <i class="text">{{ $model->msg_company }}</i>
                    </p>
                @endif
                @if($model->msg_country1)
                    <p class="item">
                        <button type="button" class="layui-btn title">{{ __('询盘人国家') }}:</button>
                        <i class="text">{{ $model->msg_country1 }}</i>
                    </p>
                @endif
                <p class="item">
                    <button type="button" class="layui-btn title">{{ __('询盘人邮箱') }}:</button>
                    <i class="text">{{ $model->email }}</i>
                </p>
                <p class="item">
                    <button type="button" class="layui-btn title">{{ __('询盘人电话') }}:</button>
                    <i class="text">{{ $model->tel }}</i>
                </p>
                <p class="item">
                    <button type="button" class="layui-btn title">{{ __('询盘人ip') }}:</button>
                    <i class="text">{{ $model->ip }} ({{ $model->location }})</i>
                </p>
                @if(app('settings')['setting']->inquiry_source_on)
                <p class="item">
                        <button type="button" class="layui-btn title">{{ __('客户端/来源') }}:</button>
                        <i class="text">{{ $model->client }}</i>
                </p>
                @endif

                @if($model->products && $model->products->count())
                    <div class="item products-block">
                        <button type="button" class="layui-btn title">{{ __('关联产品') }}:</button>
                        <div class="product-list">
                            @foreach($model->products as $product)
                                @php
                                    $img = '';
                                    if (!empty($product->productMainImage) && !empty($product->productMainImage->path)) {
                                        $path = (string)$product->productMainImage->path;
                                        $img = str_starts_with($path, 'http') ? $path : ('/' . ltrim($path, '/'));
                                    }
                                    if ($img === '') {
                                        $img = '/front/imgs/index_rc_01.png';
                                    }
                                    $qty = (int)($product->pivot->quantity ?? 1);
                                @endphp
                                <div class="product-row">
                                    <div class="thumb">
                                        <img src="{{ $img }}" alt="{{ $product->name }}" />
                                    </div>
                                    <div class="meta">
                                        <div class="name">{{ $product->name }}</div>
                                        <div class="qty">{{ __('数量') }}：{{ $qty }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($model->attachments && $model->attachments->count())
                    <div class="item products-block">
                        <button type="button" class="layui-btn title">{{ __('附件') }}:</button>
                        <div class="product-list">
                            @foreach($model->attachments as $attachment)
                                <div class="product-row" style="justify-content:space-between;">
                                    <div class="meta" style="flex:1;">
                                        <div class="name">{{ $attachment->original_name }}</div>
                                        <div class="qty">
                                            {{ __('类型') }}：{{ strtoupper((string)$attachment->extension) }}
                                            &nbsp;|&nbsp;
                                            {{ __('大小') }}：{{ $attachment->human_size }}
                                            @if($attachment->mime)
                                                &nbsp;|&nbsp;MIME：{{ $attachment->mime }}
                                            @endif
                                        </div>
                                    </div>
                                    <div style="flex:0 0 auto;display:flex;gap:8px;">
                                        @if(in_array(strtolower((string)$attachment->extension), ['png','jpg','jpeg','gif','webp','bmp','pdf'], true) && $attachment->existsOnDisk())
                                            <a class="layui-btn layui-btn-sm layui-btn-primary" href="{{ $attachment->public_url }}" target="_blank" rel="noopener">{{ __('查看') }}</a>
                                        @endif
                                        <a class="layui-btn layui-btn-sm" href="{{ route('admin.inquiry.attachment.download', $attachment->id) }}">{{ __('下载') }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="layui-fluid">
            <div class="layadmin-caller" style="padding:20px;">
                <form class="layui-form caller-seach" id="form1" method="post" action="{{ route('admin.inquiry.remark') }}" style="padding-bottom:0;">
                    @csrf
                    <input type="hidden" name="inquiry_id" value="{{ $model->id }}">
                    <textarea type="text" id="content" name="content" autocomplete="off" placeholder="{{ __('请输入跟踪备注') }}"
                              class="layui-textarea"></textarea>
                    <div class="layui-layer-btn layui-layer-btn-" style="margin-top:15px;padding-right: 0;">
                        <a class="layui-layer-btn0">{{ __('确定') }}</a>
                        <a class="layui-layer-btn1" style="margin-right:0;">{{ __('取消') }}</a>
                    </div>
                </form>
                <div class="caller-contar">
                    @foreach($model->inquiryRemark as $remark)
                        <div class="caller-item">
                            <div class="caller-main caller-fl">
                                <p><strong>{{ $remark->user->name }}</strong> <em>{{ $remark->created_at }}</em></p>
                                <p class="caller-adds">{{ $remark->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="demo-template-caller1"></div>
            </div>
        </div>
    </div>
    @section('css')
        <link rel="stylesheet" href="{{  mix('/css/admin/admin.pset.css') }}" media="all">
    @endsection
    @section('scripts')
        <script src="{{ mix('/js/admin/admin.inquiry.js') }}"></script>
    @endsection
    </body>
</x-layui-layout>
