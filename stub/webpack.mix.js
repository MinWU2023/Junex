const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js');

// layui 相关
mix.combine([
    'resources/js/admin/layui/lib/index.js'
],'public/ui/lib/index.js')
mix.combine([
    'resources/js/admin/layui/config.js'
],'public/ui/config.js')
mix.combine([
    'resources/js/admin/lay/modules/laytpl.js'
],'public/js/admin/lay/modules/laytpl.js')
mix.combine([
    'resources/js/admin/lay/modules/layim.js'
],'public/js/admin/lay/modules/layim.js')
mix.combine([
    'resources/js/admin/lay/modules/table.js'
],'public/js/admin/lay/modules/table.js')
mix.combine([
    'resources/js/admin/lay/modules/laypage.js'
],'public/js/admin/lay/modules/laypage.js')
mix.combine([
    'resources/js/admin/lay/modules/layer.js'
],'public/js/admin/lay/modules/layer.js')

mix.combine([
    'resources/js/admin/lay/modules/laydate.js'
],'public/js/admin/lay/modules/laydate.js')

mix.combine([
    'resources/js/admin/lay/modules/jquery.js'
],'public/js/admin/lay/modules/jquery.js')
mix.combine([
    'resources/js/admin/lay/modules/element.js'
],'public/js/admin/lay/modules/element.js')
mix.combine([
    'resources/js/admin/lay/modules/form.js'
],'public/js/admin/lay/modules/form.js')
mix.combine([
    'resources/js/admin/lay/modules/util.js'
],'public/js/admin/lay/modules/util.js')
mix.combine([
    'resources/js/admin/lay/modules/util.js'
],'public/js/admin/lay/modules/util.js')
// mix.combine([
//     'resources/js/admin/lay/modules/upload.js'
// ],'public/js/admin/lay/modules/upload.js')
mix.combine([
    'resources/js/admin/layui/lib/admin.js'
],'public/ui/lib/admin.js')
mix.combine([
    'resources/js/admin/layui/lib/view.js'
],'public/ui/lib/view.js')
mix.combine([
    'resources/js/admin/layui/modules/common.js'
],'public/ui/modules/common.js')
mix.combine([
    'resources/js/admin/layui/modules/set.js'
],'public/ui/modules/set.js')
mix.combine([
    'resources/js/admin/layui/modules/im.js'
],'public/ui/modules/im.js')
mix.combine([
    'resources/js/admin/layui/modules/user.js'
],'public/ui/modules/user.js')
mix.combine([
    'resources/js/admin/layui/modules/contlist.js'
],'public/ui/modules/contlist.js')
mix.combine([
    'resources/js/admin/layui/modules/treeTable.js'
],'public/ui/modules/treeTable.js')
mix.combine([
    'resources/js/admin/layui/modules/uploadLaravel.js'
],'public/ui/modules/uploadLaravel.js')
mix.combine([
    'resources/js/admin/layui/modules/productImageUpload.js'
],'public/ui/modules/productImageUpload.js')
mix.combine([
    'resources/js/admin/layui/modules/productFileUpload.js'
],'public/ui/modules/productFileUpload.js')

mix.combine([
    'resources/js/admin/layui/modules/fileUploadOne.js'
],'public/ui/modules/fileUploadOne.js')

mix.combine([
    'resources/css/admin/layer/default/layer.css'
],'public/js/admin/css/modules/layer/default/layer.css')

mix.combine([
    'resources/css/admin/laydate/default/laydate.css'
],'public/js/admin/css/modules/laydate/default/laydate.css')

mix.combine([
    'resources/css/admin/layim/layim.css'
],'public/js/admin/css/modules/layim/layim.css')

mix.copy('resources/layui_exts', 'public/ui/modules/layui_exts')


mix.copy('resources/images', 'public/images')
mix.copy('resources/font', 'public/font')
mix.copy('resources/demo/products', 'public/product-demos')
mix.copy('resources/css/admin/layer/images/icon.png', 'public/js/admin/css/modules/layer/default/icon.png');
mix.copy('resources/css/admin/layer/images/loading-2.gif','public/js/admin/css/modules/layer/default/loading-2.gif')
mix.copy('resources/css/admin/layer/images/loading-1.gif','public/js/admin/css/modules/layer/default/loading-1.gif')
mix.copy('resources/css/admin/layer/images/loading-0.gif','public/js/admin/css/modules/layer/default/loading-0.gif')
mix.copyDirectory('resources/css/admin/layer/font', 'public/css/font');
mix.copyDirectory('resources/css/admin/laydate/default/font', 'public/js/admin/css/modules/laydate/default/font')
mix.copyDirectory('resources/tinymce', 'public/tinymce')

mix.copy('resources/css/admin/layim', 'public/js/admin/css/modules/layim')
// layui 相关结束


// 后台公用 css
mix.styles([
    'resources/css/admin/layui.css',
    'resources/css/admin/admin.css',
    'resources/css/admin/sIcon.css',
], 'public/css/admin/admin.public.css');

// 后台公用 js
mix.js([
    'resources/js/admin/layui/layui.js',
    'resources/js/admin/config.js',
    'resources/js/admin/functions.js'
], 'public/js/admin/admin.public.js');

//后台form css
mix.combine([
    'resources/css/admin/form.css',
], 'public/css/admin/admin.form.css');

// 后台主界面 js

mix.combine([
    'resources/js/admin/dashboard.js',
], 'public/js/admin/admin.dashboard.js');


// 后台登陆 css
mix.combine([
    'resources/css/admin/login.css',
], 'public/css/admin/admin.login.css');
// 后台登陆 js

mix.combine([
    'resources/js/admin/jquery.min.js',
], 'public/js/admin/admin.newjquery.min.js');
mix.combine([
    'resources/js/admin/login.js',
], 'public/js/admin/admin.login.js');
mix.combine([
    'resources/js/admin/qrcode.js',
], 'public/js/admin/admin.qrcode.js');
mix.combine([
    'resources/js/admin/echo.iife.js',
], 'public/js/admin/admin.echo.iife.js');
mix.combine([
    'resources/js/admin/socket.io.js',
], 'public/js/admin/admin.socket.io.js');
mix.combine([
    'resources/js/admin/pusher.min.js',
], 'public/js/admin/admin.pusher.min.js');
mix.combine([
    'resources/js/admin/chat.js',
], 'public/js/admin/admin.chat.js');

// 后台注册 js
mix.combine([
    'resources/js/admin/register.js',
], 'public/js/admin/admin.register.js');

// 修改密码 js
mix.combine([
    'resources/js/admin/password.js',
], 'public/js/admin/admin.password.js');


// 分类
mix.combine([
    'resources/js/admin/category.js',
], 'public/js/admin/admin.category.js');

// 品牌
mix.combine([
    'resources/js/admin/brand.js',
], 'public/js/admin/admin.brand.js');


// tag
mix.combine([
    'resources/js/admin/tag.js',
], 'public/js/admin/admin.tag.js');

// 属性分类
mix.combine([
    'resources/js/admin/attributeCategory.js',
], 'public/js/admin/admin.attributeCategory.js');


// 属性
mix.combine([
    'resources/js/admin/attribute.js',
], 'public/js/admin/admin.attribute.js');

// 产品
mix.combine([
    'resources/js/admin/product.js',
], 'public/js/admin/admin.product.js');

// setting
mix.combine([
    'resources/js/admin/setting.js',
], 'public/js/admin/admin.setting.js');

//后台私有客户询盘 css
mix.combine([
    'resources/css/admin/pset.css',
], 'public/css/admin/admin.pset.css');

// inquiry
mix.combine([
    'resources/js/admin/inquiry.js',
], 'public/js/admin/admin.inquiry.js');



// newsletter
mix.combine([
    'resources/js/admin/newsletter.js',
], 'public/js/admin/admin.newsletter.js');

// blog分类
mix.combine([
    'resources/js/admin/blog_category.js',
], 'public/js/admin/admin.blog.category.js');

// blog列表
mix.combine([
    'resources/js/admin/blog.js',
], 'public/js/admin/admin.blog.js');

// blog tag列表
mix.combine([
    'resources/js/admin/blog_tag.js',
], 'public/js/admin/admin.blog.tag.js');


// 文章分类
mix.combine([
    'resources/js/admin/article_category.js',
], 'public/js/admin/admin.article.category.js');

// 文章列表
mix.combine([
    'resources/js/admin/article.js',
], 'public/js/admin/admin.article.js');

// 单页面
mix.combine([
    'resources/js/admin/page.js',
], 'public/js/admin/admin.page.js');

// menu
mix.combine([
    'resources/js/admin/menu.js',
], 'public/js/admin/admin.menu.js');

// 角色
mix.combine([
    'resources/js/admin/role.js',
], 'public/js/admin/admin.role.js');

// 权限组
mix.combine([
    'resources/js/admin/permissionGroup.js',
], 'public/js/admin/admin.permissionGroup.js');

// 权限
mix.combine([
    'resources/js/admin/permission.js',
], 'public/js/admin/admin.permission.js');

// log
mix.combine([
    'resources/js/admin/log.js',
], 'public/js/admin/admin.log.js');

// 数据备份
mix.combine([
    'resources/js/admin/databaseBackup.js',
], 'public/js/admin/admin.databaseBackup.js');

// 用户
mix.combine([
    'resources/js/admin/user.js',
], 'public/js/admin/admin.user.js');

// addonsMarket
mix.combine([
    'resources/js/admin/addonsMarket.js',
], 'public/js/admin/admin.addonsMarket.js');

mix.combine([
    'resources/js/admin/download_category.js',
], 'public/js/admin/admin.download.category.js');

mix.combine([
    'resources/js/admin/download.js',
], 'public/js/admin/admin.download.js');

mix.copy('resources/js/admin/layui/modules/images/face', 'public/js/admin/images/face')
mix.combine([
    'resources/js/admin/lay/modules/upload.js'
],'public/js/admin/lay/modules/upload.js')

mix.combine([
    'resources/js/admin/lay/modules/tree.js'
],'public/js/admin/lay/modules/tree.js')

mix.version();
