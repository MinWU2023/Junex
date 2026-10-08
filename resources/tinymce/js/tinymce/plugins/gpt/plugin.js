tinymce.PluginManager.add('gpt', function(editor) {
    editor.ui.registry.addButton('gpt', {
        text: 'GPT',
        onAction: function() {
            // 创建一个弹出层
            layer.open({
                title: '让GPT帮你创作吧~ <i class="layui-icon layui-icon-tips" lay-tips="这里会放一些说明"></i>',
                area: ['800px', '600px'],
                content: `
                <style>
                    .container {
                      display: flex;
                    }
                    .preview {
                      font-size: 14px;
                      line-height: 1.3;
                    }
                    .form {
                      flex: 1;
                      padding: 20px;
                    }

                    .preview {
                      flex: 1;
                      padding: 20px;
                      border: 1px solid #ccc;
                    }

                    /* 可根据需要自定义表单和预览的样式 */

                    .layui-layer-dialog .form{padding-left: 0;padding-top: 0;}
                    .layui-layer-dialog .layui-textarea{border-color: #d7d7d7;border-radius: 3px;}
                    .layui-layer-dialog .preview{border-color: #d7d7d7;border-radius: 3px;}
                    .layui-layer-dialog .layui-form-label{padding: 0;margin-bottom: 15px;}
                    .layui-layer-dialog .layui-form-label{font-size: 16px;color: #222;}
                    .layui-layer-dialog .layui-input-block{margin-top:30px!important}
                    .layui-layer-dialog .form .clearfix:first-child .layui-input-block{margin-top:0px!important}
                    .layui-layer-dialog select{width: 100%;border: 1px solid #d7d7d7;padding:8px;position: relative;border-radius: 3px;color: #444;}
                    .layui-layer-dialog .layui-btn-sm{width:80px;}
                    .layui-layer{width: 90%!important;left: 0!important;right: 0!important;margin: auto;max-width: 1050px}
                    @media only screen and (max-height:750px){
                        .layui-layer-dialog{height: 90%!important;top: 20px!important;}
                    }

                  </style>
                <div class="container">
                    <div class="form">
                     <div class="clearfix">
                        <label class="layui-form-label">简述或关键字</label>
                        <div class="layui-input-block" style="margin-top:20px;margin-left:0px;">
                        <textarea class="layui-textarea" lay-verify="required" id="prod_desc" placeholder="请输入简述或关键字" autocomplete="off" cols="4" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label class="layui-form-label">类型</label>
                        <div class="layui-input-block" style="margin-top:20px;margin-left:0px;">
                        <select id="type">
                            <option value="">请选择</option>
                            <option value="商品描述创作">商品描述创作</option>
                            <option value="文章以及博客创作">文章以及博客创作</option>
                        </select>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label class="layui-form-label">基调</label>
                        <div class="layui-input-block" style="margin-top:20px;margin-left:0px;">
                        <select id="tone">
                            <option value="">请选择</option>
                            <option value="严谨专业">严谨专业</option>
                            <option value="激情澎湃">激情澎湃</option>
                            <option value="活泼开朗">活泼开朗</option>
                            <option value="幽默风趣">幽默风趣</option>
                        </select>
                        </div>
                    </div>
                    <div class="clearfix">
                    <div class="layui-input-block generate" style="margin-top:20px;margin-left:0px;">
                     <button id="generate" class="layui-btn layui-btn-sm layuiadmin-btn-list">生成</button>
                    </div>
                    </div>
                    </div>
                    <div class="preview">
                      暂无内容
                      <!-- 在此处显示预览内容 -->
                    </div>
                  </div>
        `,
                btn: ['插入', '取消'],
                yes: function(index) {
                    // 获取表单数据

                    // 插入表单数据到编辑器
                    editor.insertContent($('.preview').html());

                    // 关闭弹出层
                    layer.close(index);
                },
                btn2: function(index) {
                    // 关闭弹出层
                    layer.close(index);
                }
            });
            $(function(){
                var timer;
                var messageArea = $('.preview');
                var receiveStatus = false;
                var is_finish = false;
                function initPreview() {
                    clearInterval(timer);
                    messageArea.html('暂无内容');
                    $('.generate').html('<button id="generate" class="layui-btn layui-btn-sm layuiadmin-btn-list">生成</button>');
                }
                function waitMessage() {
                    $('.generate').html('<button class="layui-btn layui-btn-disable">正在创作中</button>')
                    timer = setInterval(function () {
                        this.num++;
                        var loading = ''
                        if (this.num === 1) {
                            loading = '.';
                        } else if (this.num === 2) {
                            loading = '..';
                        } else {
                            loading = '...';
                            this.num = 0
                        }
                        messageArea.html('AI创作中 ' + loading);
                    }, 1000);
                }
                $('.generate').on('click', '#generate', function(){
                    var desc = $('#prod_desc').val().trim();
                    var tone = $('#tone').val();
                    var type = $('#type').val();
                    var token = document.head.querySelector('meta[name="csrf-token"]').content
                    if (desc) {
                        waitMessage();
                        $.ajax({
                            url: '/' + window.admin_prefix + '/gpt',
                            type: "post",
                            dataType: "json",
                            data: {desc: desc, tone: tone, type: type, _token: token},
                            success: function (data) {
                                if (data.status) {
                                    var eventSource = new EventSource("https://gpt.dyyyun.com/api/gpt-stream/" + data.data);
                                    eventSource.onmessage = function (e) {
                                        if (!receiveStatus) {
                                            clearInterval(timer);
                                            messageArea.html('');
                                        }
                                        receiveStatus = true
                                        if(e.data == "[DONE]")
                                        {
                                            receiveStatus = false;
                                            is_finish = true
                                            $('.generate').html('<button id="generate" class="layui-btn layui-btn-sm layuiadmin-btn-list">生成</button>');
                                        }
                                        var txt = JSON.parse(e.data).choices[0].delta.content;
                                        if (txt !== undefined) {
                                            messageArea.append(txt.replace(/(?:\r\n|\r|\n)/g, '<br>'));
                                        }
                                    };
                                    eventSource.onerror = function (e) {
                                        if (!is_finish) {
                                            initPreview();
                                            messageArea.html('我现在压力太大了，导致无法正常思考，请重试...')
                                            receiveStatus = false
                                        }
                                        is_finish = false
                                        eventSource.close();
                                    };
                                } else {
                                    alert(data.error_msg);
                                    initPreview();
                                }
                            },
                            error: function(xhr) {
                                alert ("请联系客户安装GPT插件");
                                initPreview();
                            }
                        });
                    }
                })
            })
        }
    });
});
