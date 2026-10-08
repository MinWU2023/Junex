layui.use(['jquery', 'layer'], function () {
        var $ = layui.$ //重点处
        var moreUedit = $('.tinymce_content');

        // 存储已上传的图片 URL 映射
        const uploadedRemoteImages = new Map(); // key: remoteUrl, value: localUrl

        // 存储正在上传过程中的 Promise
        const uploadingTasks = new Map(); // key: remoteUrl, value: Promise

        async function downloadAndUploadRemoteImage(url) {
                // 1. 如果已经上传过，直接返回缓存结果
                if (uploadedRemoteImages.has(url)) {
                        console.log('该图片已上传过，使用缓存地址:', uploadedRemoteImages.get(url));
                        return uploadedRemoteImages.get(url);
                }

                // 2. 如果已有上传任务在进行中，直接返回同一个 Promise
                if (uploadingTasks.has(url)) {
                        console.log('该图片正在上传中，等待结果...');
                        return uploadingTasks.get(url);
                }

                // 3. 创建一个新的上传任务
                const uploadPromise = (async () => {
                        try {
                                const formData = new FormData();
                                formData.append('remote_url', url);

                                const uploadResponse = await fetch('/nosay/getRemoteImages', {
                                        method: 'POST',
                                        headers: {
                                                'X-CSRF-TOKEN': $('#token').val()
                                        },
                                        body: formData
                                });

                                if (!uploadResponse.ok) {
                                        throw new Error("Upload failed with status: " + uploadResponse.status);
                                }

                                const result = await uploadResponse.json();

                                // 存入缓存，下次直接复用
                                uploadedRemoteImages.set(url, result.url);

                                // 清除上传任务标记
                                uploadingTasks.delete(url);

                                return result.data;

                        } catch (error) {
                                // 出错也清除任务标记
                                uploadingTasks.delete(url);
                                console.error('上传失败:', error);
                                throw error;
                        }
                })();

                // 把这个 promise 存入任务队列中
                uploadingTasks.set(url, uploadPromise);

                return uploadPromise;
        }
        moreUedit.each(function () {
                var id = $(this).attr('id');
                var token = $('#token').val();
                let uploadType = $(this).attr('uploadType');

                // 定义一个函数来加载模板文件
                function loadTemplate(url) {
                        return fetch(url)
                                .then(response => {
                                        if (!response.ok) {
                                                throw new Error(`HTTP error! status: ${response.status}`);
                                        }
                                        return response.text();
                                })
                                .catch(error => {
                                        console.error('Error loading template:', error);
                                        return ''; // 返回空字符串作为默认值
                                });
                }
                // 异步加载模板内容
                Promise.all([
                        loadTemplate('/tinymce/js/tinymce/template/left.html'),
                        loadTemplate('/tinymce/js/tinymce/template/right.html'),
                        loadTemplate('/tinymce/js/tinymce/template/bg1.html'),
                        loadTemplate('/tinymce/js/tinymce/template/bg2.html'),
                        loadTemplate('/tinymce/js/tinymce/template/list3.html'),
                        loadTemplate('/tinymce/js/tinymce/template/list4.html'),
                        loadTemplate('/tinymce/js/tinymce/template/list5.html'),
                        loadTemplate('/tinymce/js/tinymce/template/list6.html'),
                        loadTemplate('/tinymce/js/tinymce/template/icon.html'),
                        loadTemplate('/tinymce/js/tinymce/template/title1.html'),
                        loadTemplate('/tinymce/js/tinymce/template/title2.html'),
                        loadTemplate('/tinymce/js/tinymce/template/title3.html'),
                        loadTemplate('/fulltexts/junex-customization-01-yoga-pilates-mats.html'),
                        loadTemplate('/fulltexts/junex-customization-02-activewear-apparel.html'),
                        loadTemplate('/fulltexts/junex-customization-03-yoga-pilates-props.html'),
                        loadTemplate('/fulltexts/junex-customization-04-weighted-fitness.html'),
                ]).then(([left_template, right_template, bg1_template, bg2_template, list3_template, list4_template, list5_template, list6_template, icon_template, title1_template, title2_template, title3_template, cusMats_template, cusApparel_template, cusProps_template, cusWeighted_template]) => {
                        // 初始化 TinyMCE 编辑器
                        tinymce.init({
                                selector: '#' + id,
                                autosave_interval: '5s',
                                language: 'zh_CN',
                                branding: false,
                                elementpath: false,
                                autosave_prefix: 'tinymce-autosave-' + id + '-' + uploadType,
                                autosave_restore_when_empty: false,
                                autosave_retention: '30m',
                                convert_urls: false,  //自动转换URL
                                custom_undo_redo_levels: 30,  //撤销次数
                                //toolbar_sticky: true, //工具栏浮动
                                content_css: '/images/moban.css,/tinymce/tpl/css/det_bootstrap.css,/tinymce/tpl/css/det_font-awesome.min.css,/tinymce/tpl/css/det_style.css',
                                plugins: 'gpt print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template code codesample table charmap hr pagebreak nonbreaking insertdatetime advlist lists wordcount imagetools textpattern help autosave axupimgs',
                                toolbar: 'gpt code template undo redo restoredraft bullist numlist | fontselect fontsizeselect | forecolor backcolor bold italic underline strikethrough link | alignleft aligncenter alignright alignjustify outdent indent |\
                      table image media charmap hr pagebreak insertdatetime | blockquote subscript superscript removeformat print fullscreen |searchreplace lineheight formatpainter',
                                browser_spellcheck: true,
                                contextmenu: false,
                                min_height: 500,
                                image_dimensions: false,
                                fontsize_formats: '12px 14px 16px 18px 20px 24px 36px 48px 56px 72px',
                                font_formats: '微软雅黑=Microsoft YaHei,Helvetica Neue,PingFang SC,sans-serif;苹果苹方=PingFang SC,Microsoft YaHei,sans-serif;宋体=simsun,serif;仿宋体=FangSong,serif;黑体=SimHei,sans-serif;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats;知乎配置=BlinkMacSystemFont, Helvetica Neue, PingFang SC, Microsoft YaHei, Source Han Sans SC, Noto Sans CJK SC, WenQuanYi Micro Hei, sans-serif;小米配置=Helvetica Neue,Helvetica,Arial,Microsoft Yahei,Hiragino Sans GB,Heiti SC,WenQuanYi Micro Hei,sans-serif',
                                image_class_list: [
                                        { title: 'None', value: '' },
                                        { title: 'Some class', value: 'class-name' }
                                ],
                                //为内容模板插件提供预置模板
                                templates: [
                                        { title: '分类页板块-瑜伽普拉提垫', description: 'JUNEX CUSTOMIZATION PROCESS / Yoga & Pilates Mats', content: cusMats_template },
                                        { title: '分类页板块-运动服装', description: 'JUNEX CUSTOMIZATION PROCESS / Activewear & Apparel', content: cusApparel_template },
                                        { title: '分类页板块-瑜伽普拉提辅具', description: 'JUNEX CUSTOMIZATION PROCESS / Yoga & Pilates Props', content: cusProps_template },
                                        { title: '分类页板块-负重健身配件', description: 'JUNEX CUSTOMIZATION PROCESS / Weighted & Fitness Accessories', content: cusWeighted_template },
                                        { title: '图文模板(左)', description: '', content: left_template },
                                        { title: '图文模板(右)', description: '', content: right_template },
                                        { title: '背景', description: '', content: bg1_template },
                                        { title: '背景2', description: '', content: bg2_template },
                                        { title: '列表3', description: '', content: list3_template },
                                        { title: '列表4', description: '', content: list4_template },
                                        { title: '列表5', description: '', content: list5_template },
                                        { title: '列表6', description: '', content: list6_template },
                                        { title: '图标页面', description: '', content: icon_template },
                                        { title: '标题占位符1', description: '', content: title1_template },
                                        { title: '标题占位符2', description: '', content: title2_template },
                                        { title: '标题占位符3', description: '', content: title3_template },
                                ],
                                //content_security_policy: "script-src *;",
                                extended_valid_elements: 'script[src]',
                                setup: function (editor) {
                                        editor.on('OpenWindow', function () {
                                                setTimeout(function () {
                                                        var dialogs = document.querySelectorAll('.tox-dialog');
                                                        dialogs.forEach(function (dialog) {
                                                                // 检查是否是图片对话框（含"上传"标签页）
                                                                var tabs = dialog.querySelectorAll('.tox-tab');
                                                                var isImageDialog = false;
                                                                tabs.forEach(function (tab) {
                                                                        var txt = tab.textContent.trim();
                                                                        if (txt === '上传' || txt === 'Upload') {
                                                                                isImageDialog = true;
                                                                        }
                                                                });
                                                                if (!isImageDialog || dialog.querySelector('.tox-tab-album')) {
                                                                        return;
                                                                }
                                                                // 注入"相册"标签按钮
                                                                var navWrap = dialog.querySelector('.tox-dialog__body-nav');
                                                                if (!navWrap) return;
                                                                var albumBtn = document.createElement('button');
                                                                albumBtn.type = 'button';
                                                                albumBtn.className = 'tox-tab tox-tab-album';
                                                                albumBtn.setAttribute('role', 'tab');
                                                                albumBtn.textContent = '相册';
                                                                albumBtn.style.fontSize = '14px';
                                                                albumBtn.style.color = 'rgba(34, 47, 62, 0.7)';
                                                                albumBtn.addEventListener('click', function () {
                                                                        // 在多个 window 层级注册同一个插入函数，提升在复杂 iframe 场景下的可达性。
                                                                        var insertFn = function (paths) {
                                                                                editor.focus();
                                                                                paths.forEach(function (path) {
                                                                                        editor.insertContent('<img src="/' + path + '" />');
                                                                                });
                                                                                editor.windowManager.close();
                                                                        };
                                                                        var wins = [window];
                                                                        try { if (window.parent !== window) wins.push(window.parent); } catch (e) {}
                                                                        try { if (window.top !== window) wins.push(window.top); } catch (e) {}
                                                                        wins.forEach(function (w) {
                                                                                try { w._tinymceAlbumInsert = insertFn; } catch (e) {}
                                                                        });
                                                                        layer.open({
                                                                                type: 2,
                                                                                area: ['80%', '80%'],
                                                                                title: '选择相册图片',
                                                                                // 额外附带 editor_id，供弹窗端作为兜底定位编辑器
                                                                                content: '/nosay/picture/pop?from_tinymce=1&editor_id=' + encodeURIComponent(editor.id)
                                                                        });
                                                                });
                                                                navWrap.appendChild(albumBtn);
                                                        });
                                                }, 80);
                                        });
                                },
                                template_cdate_format: '[CDATE: %m/%d/%Y : %H:%M:%S]',
                                template_mdate_format: '[MDATE: %m/%d/%Y : %H:%M:%S]',
                                autosave_ask_before_unload: true,
                                image_title: true,
                                toolbar_mode: 'wrap',
                                images_upload_url: '/nosay/upload',
                                _token: token,
                                images_upload_base_path: '/',
                                upload_type: uploadType
                        });
                });

        });
})

