<?php

use Illuminate\Support\Facades\Route;
use Modules\Common\Http\Controllers\DictController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/
Route::middleware(['formatApiResponse'])->group(function () {
    Route::any('/common/dict/all', [DictController::class, 'all']);
    Route::any('/common/dict/openApi', [DictController::class, 'openApi']);
});

