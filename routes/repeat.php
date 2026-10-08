<?php

use App\Repeats\Controllers\PageController;
use App\Repeats\Controllers\ProductController;
use App\Repeats\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'admin.permission']], function () {

//    Route::resource('/product', ProductController::class)
//        ->names('admin.product');
//
//    Route::resource('/page', PageController::class)
//        ->names('admin.page');
//
//    Route::resource('/article', ArticleController::class)
//        ->names('admin.article');
});

