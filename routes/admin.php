<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Modules\Admin\Controllers\AuthenticatedController;
use App\Modules\Admin\Controllers\RegisteredUserController;
use App\Modules\Admin\Controllers\DashboardController;
use App\Modules\Admin\Controllers\PasswordUserController;
use App\Modules\Product\Controllers\ProductCategoryController;
use App\Modules\Product\Controllers\ProductBrandController;
use App\Modules\Product\Controllers\ProductAttributeController;
use App\Modules\Product\Controllers\ProductTagController;
use App\Modules\Product\Controllers\ProductController;
use App\Modules\FileInfo\Controllers\FileInfoController;
use App\Modules\Setting\Controllers\BannerController;
use App\Modules\Setting\Controllers\BrandSolutionController;
use App\Modules\Setting\Controllers\CustomServiceController;
use App\Modules\Setting\Controllers\HomeProductCategoryController;
use App\Modules\Setting\Controllers\HotStyleTabController;
use App\Modules\Setting\Controllers\ExcitingUpdateController;
use App\Modules\Setting\Controllers\WhyChooseCardController;
use App\Modules\Setting\Controllers\SectionTitleController;
use App\Modules\Setting\Controllers\SnsIconController;
use App\Modules\Setting\Controllers\LocaleController;
use App\Modules\Article\Controllers\ArticleCategoryController;
use App\Modules\Article\Controllers\ArticleController;
use App\Modules\Page\Controllers\PageController;
use App\Modules\Page\Controllers\FrontPageListController;
use App\Modules\Page\Controllers\StaticBlockController;
use App\Modules\Admin\Controllers\RoleController;
use App\Modules\Admin\Controllers\PermissionController;
use App\Modules\Admin\Controllers\PermissionGroupController;
use App\Modules\Admin\Controllers\SettingController;
use App\Modules\Admin\Controllers\AdminUserController;
use App\Modules\Menu\Controllers\MenuController;
use App\Modules\AddonsMarket\Controllers\AddonsMarketController;
use App\Modules\Inquiry\Controllers\InquiryController;
use App\Modules\Report\Controllers\ReportController;
use App\Modules\Setting\Controllers\SloganController;
use App\Modules\Blog\Controllers\BlogCategoryController;
use App\Modules\Blog\Controllers\BlogController;
use App\Modules\Blog\Controllers\BlogTagController;
use App\Modules\Search\Controllers\SearchController;
use App\Modules\Navigation\Controllers\NavigationController;
use App\Modules\FriendLink\Controllers\FriendLinkController;
use App\Modules\Photo\Controllers\PictureController;
use App\Modules\Photo\Controllers\AlbumController;
use App\Modules\Setting\Controllers\LandPageController;
use App\Modules\Download\Controllers\DownloadController;
use App\Modules\Download\Controllers\DownloadCategoryController;
use App\Modules\Inquiry\Controllers\NewsLetterController;
use App\Modules\Translate\Controllers\TranslateJobController;
use App\Modules\Report\Controllers\DataManagerController;
use App\Modules\Admin\Controllers\ManagerController;
use App\Modules\Url\Controllers\UrlController;
use App\Modules\Product\Controllers\ProductTempController;
use App\Modules\Blog\Controllers\BlogTempController;
use App\Modules\Article\Controllers\ArticleTempController;
use App\Modules\Page\Controllers\PageTempController;
use App\Modules\Product\Controllers\ProductDraftController;
use App\Modules\Blog\Controllers\BlogDraftController;
use App\Modules\Article\Controllers\ArticleDraftController;
use App\Modules\Product\Controllers\ProductVideoController;
use App\Modules\Product\Controllers\ProductVideoCategoryController;
use App\Modules\Product\Controllers\FaqController;
use App\Modules\Product\Controllers\ProductFaqController;
use App\Modules\Product\Controllers\FaqGroupController;
use App\Modules\Product\Controllers\CustomerReviewController;

Route::group(['middleware' => ['guest']], function () {

    // Authentication...
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('admin.login');

    $limiter = config('fortify.limiters.login');

    Route::post('/login', [AuthenticatedController::class, 'login'])
        ->middleware(array_filter([
            $limiter ? 'throttle:' . $limiter : null,
        ]));

    Route::post('/wechatLogin', [AdminUserController::class, 'wechatLogin']);


    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('admin.register');

    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/logout', [AuthenticatedController::class, 'destroy'])
        ->name('admin.logout');

    Route::get('/password', [PasswordUserController::class, 'index'])
        ->name('admin.password');

    Route::put('/password', [PasswordUserController::class, 'update']);

    Route::resource('/upload', FileInfoController::class)
        ->names('admin.file');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/keeplive', [DashboardController::class, 'keeplive']);

    Route::get('/globalcolor/{color}', [DashboardController::class, 'globalcolor']);


    Route::get('/changePassword', [DashboardController::class, 'changePassword']);
    Route::put('/changePassword', [DashboardController::class, 'changePasswordUpdate']);
    Route::get('/photoAlbum/{id}/photo', [AlbumController::class, 'photo'])
        ->name('admin.photoAlbum.photo');
    Route::get('/openLanguage', [DashboardController::class, 'openLanguage']);

    Route::post('/syncLocale', [DashboardController::class, 'syncLocale']);

    Route::get('/getSizeContent', [DashboardController::class, 'getSizeContent']);


    Route::post('/productCategory/exist', [ProductTempController::class, 'existCategory']);

    Route::post('/product/attribute/{id}/bindValues', [ProductAttributeController::class, 'bindValues'])
        ->name('admin.product.attribute.bindValues');


    Route::post('/tempProduct/{id}/preview', [ProductTempController::class, 'preview']);
    Route::delete('/tempProduct/{id}/delete', [ProductTempController::class, 'delete']);

    Route::post('/tempBlog/{id}/preview', [BlogTempController::class, 'preview']);
    Route::delete('/tempBlog/{id}/delete', [BlogTempController::class, 'delete']);

    Route::post('/tempArticle/{id}/preview', [ArticleTempController::class, 'preview']);
    Route::delete('/tempArticle/{id}/delete', [ArticleTempController::class, 'delete']);

    Route::post('/tempPage/{id}/preview', [PageTempController::class, 'preview']);
    Route::delete('/tempPage/{id}/delete', [PageTempController::class, 'delete']);
    Route::post('/newsletter/export', [NewsLetterController::class, 'export'])->name('admin.newsletter.export');
    Route::get('/multilingual/translations', [DashboardController::class, 'translationsJs']);

    Route::put('/page/change_property/{id}', [PageController::class, 'changeProperty'])
        ->name('admin.page.changeProperty');
    Route::put('/blog/change_property/{id}', [BlogController::class, 'changeProperty'])
        ->name('admin.blog.changeProperty');
    Route::post('/download/reset_download_key', [DownloadController::class, 'resetDownloadKey']);
    Route::get('/download/{id}/download_record', [DownloadController::class, 'downloadRecord']);
    Route::post('/inquiry/setValidInquiry', [InquiryController::class, 'setValidInquiry'])->name('admin.inquiry.setValidInquiry');
    Route::post('/inquiry/setSpamInquiry', [InquiryController::class, 'setSpamInquiry'])->name('admin.inquiry.setSpamInquiry');
});


Route::group(['middleware' => ['auth', 'admin.permission']], function () {

    Route::get('/search', [SearchController::class, 'index'])
        ->name('admin.search');
    // 管理员管理模块
    Route::resource('/user', AdminUserController::class)
        ->except(['show'])
        ->names('admin.user');

    // 管理员管理模块
    Route::resource('/manager', ManagerController::class)
        ->except(['show'])
        ->names('admin.manager');
    Route::post('/dataManager/productCategoryRate', [DataManagerController::class, 'productCategoryRate'])->name('admin.dataManager.productCategoryRate');

    Route::get('/dataManager', [DataManagerController::class, 'index'])->name('admin.dataManager.index');

    Route::post('/dataManager', [DataManagerController::class, 'chartData'])->name('admin.dataManager.data');

    //    Route::post('/keywordRank/export', [KeywordRankController::class, 'export'])->name('admin.keywordsRank.export');
    //    Route::get('/keywordRank', [KeywordRankController::class, 'index'])->name('admin.keywordsRank.index');

    Route::get('/getNotice/{id}', [SettingController::class, 'getNotice'])->name('admin.setting.getNotice');

    Route::get('/getAllPermissions', [PermissionController::class, 'allPermissions'])
        ->name('admin.allPermissions');

    Route::get('/role/{id}/permissions', [RoleController::class, 'roleHasPermission'])
        ->name('admin.roleHasPermission');

    Route::get('admin/log', [\App\Modules\Admin\Controllers\AdminLogController::class, 'index'])
        ->name('admin.log.index');

    Route::get('databaseBackup/{id}/download', [\App\Modules\Admin\Controllers\DatabaseBackupController::class, 'download'])
        ->name('admin.databaseBackup.download');
    Route::post('databaseBackup/{id}/restore', [\App\Modules\Admin\Controllers\DatabaseBackupController::class, 'restore'])
        ->name('admin.databaseBackup.restore');
    Route::resource('/databaseBackup', \App\Modules\Admin\Controllers\DatabaseBackupController::class)
        ->only(['index', 'store', 'destroy'])
        ->names('admin.databaseBackup');

    Route::resource('/role', RoleController::class)
        ->names('admin.role');

    Route::resource('/permission-group', PermissionGroupController::class)
        ->names('admin.permissionGroup');

    Route::resource('/permission', PermissionController::class)
        ->names('admin.permission');

    Route::get('/product/draft', [ProductDraftController::class, 'index'])->name('admin.product.draft.index');
    Route::get('/product/draft/{id}/edit', [ProductDraftController::class, 'edit'])->name('admin.product.draft.edit');
    Route::put('/product/draft/{id}', [ProductDraftController::class, 'update'])->name('admin.product.draft.update');
    Route::post('/product/draft/destroy/{id}', [ProductDraftController::class, 'destroy'])->name('admin.product.draft.destroy');
    Route::post('/product/draft/schedule/{id}', [ProductDraftController::class, 'setSchedule'])->name('admin.product.draft.schedule');
    Route::delete('/product/draft/schedule/{id}', [ProductDraftController::class, 'deleteSchedule'])->name('admin.product.draft.schedule.delete');


    Route::get('product/keywords', [ProductController::class, 'keywords'])->name('admin.product.keywords');

    Route::get('/product/category/getAllCategories/{id}', [ProductCategoryController::class, 'getAllCategories'])
        ->name('admin.product.category.getAllCategories');

    Route::put('/product/category/change_property/{id}', [ProductCategoryController::class, 'changeProperty'])
        ->name('admin.product.category.changeProperty');
    Route::post('/product/getAttribute/{attributeCategoryId}', [ProductController::class, 'getAttribute'])
        ->name('admin.product.getAttribute');
    Route::resource('/product/category', ProductCategoryController::class)
        ->names('admin.product.category');

    Route::resource('/product/brand', ProductBrandController::class)
        ->names('admin.product.brand');


    Route::get('/url', [UrlController::class, 'index'])
        ->name('admin.url.index');

    Route::delete('/url/{id}', [UrlController::class, 'destroy'])
        ->name('admin.url.destroy');

    Route::get('/translateJob', [TranslateJobController::class, 'index'])
        ->name('admin.translateJob.index');

    //    Route::get('/product/attribute/category/getAllCategories/{id}',[\App\Modules\Product\Controllers\ProductAttributeCategoryController::class,'getAllCategories'])
    //        ->name('admin.product.attributeCategory.getAllCategories');

    Route::resource('/product/attribute/category', \App\Modules\Product\Controllers\ProductAttributeCategoryController::class)
        ->names('admin.product.attributeCategory');

    Route::resource('/product/attribute', ProductAttributeController::class)
        ->names('admin.product.attribute');


    Route::post('/product/tag/removes', [ProductTagController::class, 'removes'])
        ->name('admin.product.tag.removes');

    Route::put('/product/tag/detach', [ProductTagController::class, 'detachTag'])
        ->name('admin.product.tag.detach');

    Route::put('/product/tag/change_property/{id}', [ProductTagController::class, 'changeProperty'])
        ->name('admin.product.tag.changeProperty');

    Route::post('/product/tag/export', [ProductTagController::class, 'export'])->name('admin.product.tag.export');

    Route::resource('/product/tag', ProductTagController::class)
        ->names('admin.product.tag');
    Route::get('/getAllProductTags', [ProductTagController::class, 'allProductTags'])
        ->name('admin.allProductTags');

    Route::get('/product/trash', [ProductController::class, 'trash'])
        ->name('admin.product.trash');

    Route::get('/product/restore/{id}', [ProductController::class, 'restore'])
        ->name('admin.product.restore');

    Route::put('/product/change_property/{id}', [ProductController::class, 'changeProperty'])
        ->name('admin.product.changeProperty');
    Route::post('/product/remove', [ProductController::class, 'remove'])->name('admin.product.remove');

    Route::get('/product/multipleMoveCategory', [ProductController::class, 'multipleMoveCategoryShow'])
        ->name('admin.product.multipleMoveCategoryShow');

    Route::post('/product/multipleMoveCategory', [ProductController::class, 'multipleMoveCategory'])
        ->name('admin.product.multipleMoveCategory');

    Route::post('/product/multipleMoveTrash', [ProductController::class, 'multipleMoveTrash'])
        ->name('admin.product.multipleMoveTrash');

    Route::post('/product/multipleRestore', [ProductController::class, 'multipleRestore'])
        ->name('admin.product.multipleRestore');

    Route::post('/product/multipleDestroy', [ProductController::class, 'multipleDestroy'])
        ->name('admin.product.multipleDestroy');

    Route::get('/product/multipleMoveBrand', [ProductController::class, 'multipleMoveBrandShow'])
        ->name('admin.product.multipleMoveBrandShow');

    Route::post('/product/multipleMoveBrand', [ProductController::class, 'multipleMoveBrand'])
        ->name('admin.product.multipleMoveBrand');

    Route::get('/product/multipleMoveUser', [ProductController::class, 'multipleMoveUserShow'])
        ->name('admin.product.multipleMoveUserShow');

    Route::post('/product/multipleMoveUser', [ProductController::class, 'multipleMoveUser'])
        ->name('admin.product.multipleMoveUser');

    Route::get('/product/{id}/copy', [ProductController::class, 'copy'])->name('admin.product.copy');

    Route::get('/productVideo/searchProducts', [ProductVideoController::class, 'searchProducts'])
        ->name('admin.productVideo.searchProducts');

    Route::resource('/productVideo', ProductVideoController::class)
        ->names('admin.productVideo');
    Route::resource('/productVideoCategory', ProductVideoCategoryController::class)
        ->names('admin.productVideoCategory');

    Route::resource('/brandSolution', BrandSolutionController::class)
        ->names('admin.brandSolution');

    Route::resource('/customService', CustomServiceController::class)
        ->names('admin.customService');

    Route::resource('/homeProductCategory', HomeProductCategoryController::class)
        ->names('admin.homeProductCategory');

    Route::get('/hotStyleTab/products-by-category', [HotStyleTabController::class, 'productsByCategory'])
        ->name('admin.hotStyleTab.productsByCategory');

    Route::resource('/hotStyleTab', HotStyleTabController::class)
        ->names('admin.hotStyleTab');

    Route::resource('/excitingUpdate', ExcitingUpdateController::class)
        ->names('admin.excitingUpdate');

    Route::get('/whyChooseCard/center', [WhyChooseCardController::class, 'editCenter'])
        ->name('admin.whyChooseCard.center');
    Route::put('/whyChooseCard/center', [WhyChooseCardController::class, 'updateCenter'])
        ->name('admin.whyChooseCard.center.update');

    Route::resource('/whyChooseCard', WhyChooseCardController::class)
        ->names('admin.whyChooseCard');

    Route::resource('/sectionTitle', SectionTitleController::class)
        ->only(['index', 'edit', 'update'])
        ->names('admin.sectionTitle');

    Route::post('/snsIcon/{id}/toggleStatus', [SnsIconController::class, 'toggleStatus'])
        ->name('admin.snsIcon.toggleStatus');
    Route::resource('/snsIcon', SnsIconController::class)
        ->names('admin.snsIcon');

    Route::resource('/faq', FaqController::class)
        ->names('admin.faq');
    Route::post('/faq/batchDestroy', [FaqController::class, 'batchDestroy'])
        ->name('admin.faq.batchDestroy');
    Route::post('/faq/{id}/updateSort', [FaqController::class, 'updateSort'])
        ->name('admin.faq.updateSort');

    Route::post('/productFaq/syncFromFaqs', [ProductFaqController::class, 'syncFromFaqs'])
        ->name('admin.productFaq.syncFromFaqs');
    Route::post('/productFaq/export', [ProductFaqController::class, 'export'])
        ->name('admin.productFaq.export');
    Route::post('/productFaq/import', [ProductFaqController::class, 'import'])
        ->name('admin.productFaq.import');
    Route::post('/productFaq/batchDestroy', [ProductFaqController::class, 'batchDestroy'])
        ->name('admin.productFaq.batchDestroy');
    Route::post('/productFaq/{id}/updateSort', [ProductFaqController::class, 'updateSort'])
        ->name('admin.productFaq.updateSort');
    Route::get('/productFaq/searchProducts', [ProductFaqController::class, 'searchProducts'])
        ->name('admin.productFaq.searchProducts');
    Route::get('/productFaq/categoryTree', [ProductFaqController::class, 'categoryTree'])
        ->name('admin.productFaq.categoryTree');
    Route::post('/productFaq/{id}/syncRelations', [ProductFaqController::class, 'syncRelations'])
        ->name('admin.productFaq.syncRelations');
    Route::resource('/productFaq', ProductFaqController::class)
        ->names('admin.productFaq');

    Route::resource('/faqGroup', FaqGroupController::class)
        ->names('admin.faqGroup');

    Route::resource('/customerReview', CustomerReviewController::class)
        ->names('admin.customerReview');

    Route::resource('/product', ProductController::class)
        ->names('admin.product');

    Route::resource('/blog/category', BlogCategoryController::class)
        ->names('admin.blog.category');

    Route::post('/blog/multipleMoveTrash', [BlogController::class, 'multipleMoveTrash'])
        ->name('admin.blog.multipleMoveTrash');
    Route::post('/blog/multipleRestore', [BlogController::class, 'multipleRestore'])
        ->name('admin.blog.multipleRestore');
    Route::post('/blog/multipleDestroy', [BlogController::class, 'multipleDestroy'])
        ->name('admin.blog.multipleDestroy');

    Route::post('/blog/remove', [BlogController::class, 'remove'])->name('admin.blog.remove');

    Route::get('/blog/trash', [BlogController::class, 'trash'])
        ->name('admin.blog.trash');

    Route::get('/blog/restore/{id}', [BlogController::class, 'restore'])
        ->name('admin.blog.restore');

    Route::get('/blog/draft', [BlogDraftController::class, 'index'])->name('admin.blog.draft.index');
    Route::get('/blog/draft/{id}/edit', [BlogDraftController::class, 'edit'])->name('admin.blog.draft.edit');
    Route::put('/blog/draft/{id}', [BlogDraftController::class, 'update'])->name('admin.blog.draft.update');
    Route::post('/blog/draft/destroy/{id}', [BlogDraftController::class, 'destroy'])->name('admin.blog.draft.destroy');
    Route::post('/blog/draft/schedule/{id}', [BlogDraftController::class, 'setSchedule'])->name('admin.blog.draft.schedule');
    Route::delete('/blog/draft/schedule/{id}', [BlogDraftController::class, 'deleteSchedule'])->name('admin.blog.draft.schedule.delete');

    Route::post('/blog/tag/removes', [BlogTagController::class, 'removes'])
        ->name('admin.blog.tag.removes');

    Route::put('/blog/tag/detach', [BlogTagController::class, 'detachTag'])->name('admin.blog.tag.detach');
    Route::post('/blog/tag/export', [BlogTagController::class, 'export'])->name('admin.blog.tag.export');
    Route::resource('/blog/tag', BlogTagController::class)->names('admin.blog.tag');
    Route::resource('/blog', BlogController::class)
        ->names('admin.blog');

    Route::get('/getAllBlogTags', [BlogTagController::class, 'allBlogTags'])
        ->name('admin.allBlogTags');

    Route::resource('/article/category', ArticleCategoryController::class)
        ->names('admin.article.category');

    Route::get('/article/draft', [ArticleDraftController::class, 'index'])->name('admin.article.draft.index');
    Route::get('/article/draft/{id}/edit', [ArticleDraftController::class, 'edit'])->name('admin.article.draft.edit');
    Route::put('/article/draft/{id}', [ArticleDraftController::class, 'update'])->name('admin.article.draft.update');
    Route::post('/article/draft/destroy/{id}', [ArticleDraftController::class, 'destroy'])->name('admin.article.draft.destroy');
    Route::post('/article/draft/schedule/{id}', [ArticleDraftController::class, 'setSchedule'])->name('admin.article.draft.schedule');
    Route::delete('/article/draft/schedule/{id}', [ArticleDraftController::class, 'deleteSchedule'])->name('admin.article.draft.schedule.delete');


    Route::post('/article/multipleMoveTrash', [ArticleController::class, 'multipleMoveTrash'])
        ->name('admin.article.multipleMoveTrash');
    Route::post('/article/multipleRestore', [ArticleController::class, 'multipleRestore'])
        ->name('admin.article.multipleRestore');
    Route::post('/article/multipleDestroy', [ArticleController::class, 'multipleDestroy'])
        ->name('admin.article.multipleDestroy');

    Route::post('/article/remove', [ArticleController::class, 'remove'])->name('admin.article.remove');

    Route::get('/article/trash', [ArticleController::class, 'trash'])
        ->name('admin.article.trash');

    Route::put('/article/change_property/{id}', [ArticleController::class, 'changeProperty'])
        ->name('admin.article.changeProperty');

    Route::get('/article/restore/{id}', [ArticleController::class, 'restore'])
        ->name('admin.article.restore');

    Route::get('/article/getAllArticles/{id}', [ArticleController::class, 'getAllArticles'])
        ->name('admin.article.getAllArticles');

    Route::resource('/article', ArticleController::class)
        ->names('admin.article');

    Route::get('/page/trash', [PageController::class, 'trash'])
        ->name('admin.page.trash');



    Route::post('/page/remove', [PageController::class, 'remove'])->name('admin.page.remove');

    Route::get('/page/restore/{id}', [PageController::class, 'restore'])
        ->name('admin.page.restore');

    Route::resource('/page', PageController::class)
        ->names('admin.page');

    Route::get('/frontPageList', [FrontPageListController::class, 'index'])->name('admin.frontPageList.index');
    Route::post('/frontPageList/batch', [FrontPageListController::class, 'batch'])->name('admin.frontPageList.batch');
    Route::post('/frontPageList/toggle', [FrontPageListController::class, 'toggle'])->name('admin.frontPageList.toggle');
    Route::post('/frontPageList/sitemap', [FrontPageListController::class, 'sitemap'])->name('admin.frontPageList.sitemap');

    Route::resource('/staticBlock', StaticBlockController::class)
        ->except(['show'])
        ->names('admin.staticBlock');

    Route::resource('/setting/banner', BannerController::class)
        ->names('admin.setting.banner');

    Route::resource('/menu', MenuController::class)
        ->names('admin.menu');

    Route::resource('/setting/locale', LocaleController::class)
        ->except(['show'])
        ->names('admin.setting.locale');


    Route::resource('/setting/slogan', SloganController::class)
        ->except(['show'])
        ->names('admin.setting.slogan');

    Route::get('/setting/clear-cache', [SettingController::class, 'clearCache'])
        ->name('admin.setting.clearCache');

    Route::get('/setting/index', [SettingController::class, 'index'])
        ->name('admin.setting.index');
    Route::put('/setting', [SettingController::class, 'reload'])
        ->name('admin.setting.update');



    Route::get('/extension-market/index', [AddonsMarketController::class, 'index'])
        ->name('admin.extensionMarket.index');

    Route::put('/extension-market/{id}', [AddonsMarketController::class, 'update'])
        ->name('admin.extensionMarket.update');

    Route::get('/extension-market/{id}/edit', [AddonsMarketController::class, 'edit'])
        ->name('admin.extensionMarket.edit');

    Route::get('/extension-market/login', [AddonsMarketController::class, 'login'])
        ->name('admin.extensionMarket.login');

    Route::post('/extension-market/doLogin', [AddonsMarketController::class, 'doLogin'])
        ->name('admin.extensionMarket.doLogin');

    Route::post('/extension-market/install', [AddonsMarketController::class, 'install'])
        ->name('admin.extensionMarket.install');

    Route::post('/extension-market/upgrade', [AddonsMarketController::class, 'upgrade'])
        ->name('admin.extensionMarket.upgrade');

    Route::post('/extension-market/uninstall', [AddonsMarketController::class, 'uninstall'])
        ->name('admin.extensionMarket.uninstall');

    Route::get('/listing', [InquiryController::class, 'listing'])
        ->name('admin.listing.index');


    Route::post('/inquiry/remove', [InquiryController::class, 'remove'])->name('admin.inquiry.remove');
    Route::get('/inquiry/restore/{id}', [InquiryController::class, 'restore'])
        ->name('admin.inquiry.restore');

    Route::get('/inquiry/trash', [InquiryController::class, 'trash'])->name('admin.inquiry.trash');
    Route::post('/inquiry/multipleMoveTrash', [InquiryController::class, 'multipleMoveTrash'])->name('admin.inquiry.multipleMoveTrash');
    Route::post('/inquiry/multipleDestroy', [InquiryController::class, 'multipleDestroy'])
        ->name('admin.inquiry.multipleDestroy');


    Route::post('/inquiry/multipleRestore', [InquiryController::class, 'multipleRestore'])
        ->name('admin.inquiry.multipleRestore');

    Route::post('/inquiry/export', [InquiryController::class, 'export'])->name('admin.inquiry.export');

    Route::get('/inquiry/editUser/{inquiry}', [InquiryController::class, 'editUser'])->name('admin.inquiry.editUser');
    Route::put('/inquiry/updateUser/{inquiry}', [InquiryController::class, 'updateUser'])->name('admin.inquiry.updateUser');
    Route::delete('/inquiry/multipleRemove', [InquiryController::class, 'multipleRemove'])->name('admin.inquiry.multipleRemove');


    Route::post('/inquiry/remark', [InquiryController::class, 'remark'])->name('admin.inquiry.remark');
    Route::get('/inquiry/attachment/{attachment}/download', [InquiryController::class, 'downloadAttachment'])
        ->name('admin.inquiry.attachment.download');

    Route::resource('/inquiry', InquiryController::class)
        ->only(['index', 'show', 'destroy'])
        ->names('admin.inquiry');




    Route::resource('/newsletter', NewsLetterController::class)
        ->only(['index', 'destroy'])
        ->names('admin.newsletter');

    Route::put('/navigation/change_property/{id}', [NavigationController::class, 'changeProperty'])
        ->name('admin.navigation.changeProperty');
    Route::resource('/navigation', NavigationController::class)
        ->except(['show'])
        ->names('admin.navigation');


    Route::resource('/friendLink', FriendLinkController::class)
        ->except(['show'])
        ->names('admin.friendLink');

    Route::resource('download/category', DownloadCategoryController::class)->except(['show'])->names('admin.download.category');
    Route::resource('download', DownloadController::class)->except(['show'])->names('admin.download');
    Route::resource('landPage', LandPageController::class)->except(['show'])->names('admin.landPage');


    Route::get('/photoAlbum/{id}/upload', [AlbumController::class, 'uploadShow'])
        ->name('admin.photoAlbum.uploadShow');
    Route::post('/photoAlbum/upload', [AlbumController::class, 'upload'])
        ->name('admin.photoAlbum.upload');
    Route::resource('photoAlbum', AlbumController::class)->except(['show'])->names('admin.photoAlbum');

    Route::get('/picture/pop', [PictureController::class, 'pop'])
        ->name('admin.picture.pop');

    Route::get('/picture/multipleMoveAlbum', [PictureController::class, 'multipleMoveAlbumShow'])
        ->name('admin.picture.multipleMoveAlbumShow');
    Route::post('/picture/multipleMoveAlbum', [PictureController::class, 'multipleMoveAlbum'])
        ->name('admin.picture.multipleMoveAlbum');


    Route::post('/picture/multipleMoveRemove', [PictureController::class, 'multipleMoveRemove'])
        ->name('admin.picture.multipleMoveRemove');
    Route::get('picture', [PictureController::class, 'index'])->name('admin.picture.index');
    Route::delete('picture/{picture}', [PictureController::class, 'destroy'])->name('admin.picture.destroy');
});


Route::group(['middleware' => ['web', 'auth', 'admin.permission']], function () {
    Route::get('/report/index', [ReportController::class, 'index'])->name('admin.report.index');
    Route::get('/report/show/{id}', [ReportController::class, 'show'])->name('admin.report.show');
    Route::post('/report/getStatistics', [ReportController::class, 'getStatistics'])->name('admin.report.getStatistics');
});
