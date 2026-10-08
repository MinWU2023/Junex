<?php

namespace Database\Seeders;

use App\Modules\Menu\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $created_at = date('Y-m-d H:i:s');
        $updated_at = $created_at;

        $homeMenu = [
            'parent_id' => 0,
            'sort' => 0,
            'name' => '主页',
            'route' => 'admin.report.index',
            'icon' => 'icon-home my-slide-icon',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        Menu::create($homeMenu);

        Menu::create(
            [
                'parent_id' => 0,
                'sort' => 0,
                'name' => '管理员账号',
                'route' => 'admin.manager.index',
                'icon' => 'icon-users my-slide-icon',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]
        );

        //产品相关
        $productMenu = [
            'parent_id' => 0,
            'sort' => 0,
            'name' => '产品管理',
            'route' => 'admin.menu.product.visibility',
            'icon' => 'icon-shopping my-slide-icon',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        $product_success = Menu::create($productMenu);
        $videoMenu = Menu::create([
            'parent_id' => $product_success->id,
            'sort' => 20,
            'name' => '视频管理',
            'route' => 'admin.menu.productVideo.visibility',
            'icon' => '',
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);
        DB::table('menus')->insert([
            [
                'parent_id' => $product_success->id,
                'sort' => 0,
                'name' => '产品列表',
                'route' => 'admin.product.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $videoMenu->id,
                'sort' => 10,
                'name' => '视频分类',
                'route' => 'admin.productVideoCategory.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $videoMenu->id,
                'sort' => 20,
                'name' => '视频列表',
                'route' => 'admin.productVideo.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $product_success->id,
                'sort' => 0,
                'name' => 'Faqs管理',
                'route' => 'admin.faq.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $product_success->id,
                'sort' => 0,
                'name' => '评论管理',
                'route' => 'admin.customerReview.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $product_success->id,
                'sort' => 0,
                'name' => '分类列表',
                'route' => 'admin.product.category.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $product_success->id,
                'sort' => 0,
                'name' => '品牌列表',
                'route' => 'admin.product.brand.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],



            [
                'parent_id' => $product_success->id,
                'sort' => 0,
                'name' => '属性列表',
                'route' => 'admin.product.attribute.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $product_success->id,
                'sort' => 0,
                'name' => '属性分类列表',
                'route' => 'admin.product.attributeCategory.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $product_success->id,
                'sort' => 0,
                'name' => '产品草稿箱',
                'route' => 'admin.product.draft.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]

        ]);

        //内容相关
        $contentMenu = [
            'parent_id' => 0,
            'sort' => 0,
            'name' => '内容相关',
            'route' => 'admin.menu.content.visibility',
            'icon' => 'icon-server my-slide-icon',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        $content_success = Menu::create($contentMenu);
        $articleMenu =[
            'parent_id' => $content_success->id,
            'sort' => 0,
            'name' => '文章',
            'route' => 'admin.menu.article.visibility',
            'icon' => '',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        $article_success = Menu::create($articleMenu);
        $pageMenu =[
            'parent_id' => $content_success->id,
            'sort' => 0,
            'name' => '页面',
            'route' => 'admin.menu.page.visibility',
            'icon' => '',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        $page_success = Menu::create($pageMenu);

        DB::table('menus')->insert([
            [
                'parent_id' => $article_success->id,
                'sort' => 0,
                'name' => '文章列表',
                'route' => 'admin.article.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $article_success->id,
                'sort' => 0,
                'name' => '文章分类列表',
                'route' => 'admin.article.category.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $article_success->id,
                'sort' => 0,
                'name' => '文章草稿箱',
                'route' => 'admin.article.draft.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $page_success->id,
                'sort' => 0,
                'name' => '单页面列表',
                'route' => 'admin.page.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
        ]);


        $blog_success = Menu::create(
            [
                'parent_id' => $content_success->id,
                'sort' => 0,
                'name' => '博客',
                'route' => 'admin.menu.blog.visibility',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]
        );
        DB::table('menus')->insert([
            [
                'parent_id' => $blog_success->id,
                'sort' => 0,
                'name' => '博客列表',
                'route' => 'admin.blog.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $blog_success->id,
                'sort' => 0,
                'name' => '博客分类列表',
                'route' => 'admin.blog.category.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $blog_success->id,
                'sort' => 0,
                'name' => '博客草稿箱',
                'route' => 'admin.blog.draft.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
        ]);


        $download_success = Menu::create(
            [
                'parent_id' => $content_success->id,
                'sort' => 0,
                'name' => '下载',
                'route' => 'admin.menu.download.visibility',
                'icon' => 'icon-download my-slide-icon',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]
        );
        DB::table('menus')->insert([
            [
                'parent_id' => $download_success->id,
                'sort' => 0,
                'name' => '下载列表',
                'route' => 'admin.download.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $download_success->id,
                'sort' => 0,
                'name' => '下载分类列表',
                'route' => 'admin.download.category.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]
        ]);


        //后台管理相关
        $managerMenu = [
            'parent_id' => 0,
            'sort' => 0,
            'name' => '后台管理',
            'route' => 'admin.menu.manager.visibility',
            'icon' => 'icon-layers my-slide-icon',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        $manager_success = Menu::create($managerMenu);
        DB::table('menus')->insert([
            [
                'parent_id' => $manager_success->id,
                'sort' => 0,
                'name' => '菜单列表',
                'route' => 'admin.menu.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $manager_success->id,
                'sort' => 0,
                'name' => '管理员列表',
                'route' => 'admin.user.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $manager_success->id,
                'sort' => 0,
                'name' => '角色列表',
                'route' => 'admin.role.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $manager_success->id,
                'sort' => 0,
                'name' => '权限组',
                'route' => 'admin.permissionGroup.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $manager_success->id,
                'sort' => 0,
                'name' => '权限列表',
                'route' => 'admin.permission.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $manager_success->id,
                'sort' => 0,
                'name' => '操作日志',
                'route' => 'admin.log.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $manager_success->id,
                'sort' => 99,
                'name' => '数据备份',
                'route' => 'admin.databaseBackup.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
        ]);




        //回收站
        $trashMenu = [
            'parent_id' => 0,
            'sort' => 0,
            'name' => '回收站相关',
            'route' => 'admin.menu.trash.visibility',
            'icon' => 'icon-trash my-slide-icon',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        $trash_success = Menu::create($trashMenu);
        DB::table('menus')->insert([
            [
                'parent_id' => $trash_success->id,
                'sort' => 0,
                'name' => '产品回收站',
                'route' => 'admin.product.trash',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $trash_success->id,
                'sort' => 0,
                'name' => '文章回收站',
                'route' => 'admin.article.trash',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $trash_success->id,
                'sort' => 0,
                'name' => '单页面回收站',
                'route' => 'admin.page.trash',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $trash_success->id,
                'sort' => 0,
                'name' => '询盘回收站',
                'route' => 'admin.inquiry.trash',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $trash_success->id,
                'sort' => 0,
                'name' => '博客回收站',
                'route' => 'admin.blog.trash',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
        ]);

        //系统设置
        $systemMenu = [
            'parent_id' => 0,
            'sort' => 0,
            'name' => '系统设置',
            'route' => 'admin.menu.system.visibility',
            'icon' => 'icon-settings my-slide-icon',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        $system_success = Menu::create($systemMenu);
        DB::table('menus')->insert([
            [
                'parent_id' => $system_success->id,
                'sort' => 0,
                'name' => '网站设置',
                'route' => 'admin.setting.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $system_success->id,
                'sort' => 0,
                'name' => '自定义导航',
                'route' => 'admin.navigation.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $system_success->id,
                'sort' => 0,
                'name' => '清除所有缓存',
                'route' => 'admin.setting.clearCache',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $system_success->id,
                'sort' => 0,
                'name' => '翻译任务',
                'route' => 'admin.translateJob.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $system_success->id,
                'sort' => 0,
                'name' => 'url管理',
                'route' => 'admin.url.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
        ]);

        //应用管理
        $extensionMarketMenu = [
            'parent_id' => 0,
            'sort' => 0,
            'name' => '应用管理',
            'route' => 'admin.menu.extensionMarket.visibility',
            'icon' => 'icon-box my-slide-icon',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        $extensionMarket_success = Menu::create($extensionMarketMenu);
        DB::table('menus')->insert([
            [
                'parent_id' => $extensionMarket_success->id,
                'sort' => 0,
                'name' => '应用市场',
                'route' => 'admin.extensionMarket.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $extensionMarket_success->id,
                'sort' => 0,
                'name' => '应用配置',
                'route' => 'admin.extensionMarket.edit',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' => $extensionMarket_success->id,
                'sort' => 0,
                'name' => '应用配置保存',
                'route' => 'admin.extensionMarket.update',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
        ]);


        //营销管理
        $marketingMenu = [
            'parent_id' => 0,
            'sort' => 0,
            'name' => '营销管理',
            'route' => 'admin.menu.marketing.visibility',
            'icon' => 'icon-barchart my-slide-icon',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        $marketing_success = Menu::create($marketingMenu);
        DB::table('menus')->insert([
            [
                'parent_id' =>$marketing_success->id,
                'sort' => 0,
                'name' => '客户询盘',
                'route' => 'admin.inquiry.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' =>$marketing_success->id,
                'sort' => 0,
                'name' => 'newsletter列表',
                'route' => 'admin.newsletter.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $marketing_success->id,
                'sort' => 0,
                'name' => '友情链接列表',
                'route' => 'admin.friendLink.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'parent_id' =>$marketing_success->id,
                'sort' => 0,
                'name' => 'listing数据',
                'route' => 'admin.listing.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
        ]);



        //数据管理
        $informationMenu = [
            'parent_id' =>0,
            'sort' => 0,
            'name' => '数据管理',
            'route' => 'admin.menu.information.visibility',
            'icon' => 'icon-relation  my-slide-icon',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        $information_success = Menu::create($informationMenu);
        DB::table('menus')->insert([
            [
                'parent_id' => $information_success->id,
                'sort' => 0,
                'name' => '产品关键词',
                'route' => 'admin.product.tag.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $information_success->id,
                'sort' => 0,
                'name' => '博客关键词数据',
                'route' => 'admin.blog.tag.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $information_success->id,
                'sort' => 0,
                'name' => '数据管家',
                'route' => 'admin.dataManager.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $information_success->id,
                'sort' => 0,
                'name' => '关键词排名',
                'route' => 'admin.keywordsRank.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
        ]);


        //相册
        $photoMenu = [
            'parent_id' =>0,
            'sort' => 0,
            'name' => '相册',
            'route' => 'admin.photo.visibility',
            'icon' => 'icon-image  my-slide-icon',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        $photo_success = Menu::create($photoMenu);
        DB::table('menus')->insert([
            [
                'parent_id' => $photo_success->id,
                'sort' => 0,
                'name' => '图片管理',
                'route' => 'admin.picture.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],

            [
                'parent_id' => $photo_success->id,
                'sort' => 0,
                'name' => '相册管理',
                'route' => 'admin.photoAlbum.index',
                'icon' => '',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
        ]);
    }
}
