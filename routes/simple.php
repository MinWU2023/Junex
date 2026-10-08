<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Admin\Controllers\UEditorController;

Route::group(['middleware' => ['web','auth']], function () {
    Route::any('/ueditor/server',[UEditorController::class, 'serve']);

});
