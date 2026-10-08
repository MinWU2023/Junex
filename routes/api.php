<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\AddonsMarket\Controllers\AddonsMarketController;
use App\Modules\Admin\Controllers\AdminUserController;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/installCloud', [AddonsMarketController::class, 'installCloud']);

Route::post('/tagManagerCodePull', [AddonsMarketController::class, 'tagManagerCodePull']);

Route::post('/pullUserName', [AdminUserController::class, 'pullUserName']);
Route::post('/syncWebsiteId', [AdminUserController::class, 'syncWebsiteId']);
Route::post('/loginCrm', [AdminUserController::class, 'loginCrm']);

Route::get('/category', [ApiController::class, 'category']);
Route::get('/product', [ApiController::class, 'product']);
Route::get('/lastProduct', [ApiController::class, 'lastProduct']);

Route::post('/googleVerify', [ApiController::class, 'googleVerify']);
Route::post('/data', [ApiController::class, 'websiteData']);

Route::post('/failEmail', [ApiController::class, 'failEmail']);

Route::post('/operation/log', [ApiController::class, 'operationLog']);
Route::get('/website/size', [ApiController::class, 'websiteSize']);


Route::post('/addedService', [ApiController::class, 'addedService']);

