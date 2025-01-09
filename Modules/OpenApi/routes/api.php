<?php

use Illuminate\Support\Facades\Route;
use Modules\OpenApi\Http\Controllers\TranslationController;
use Modules\OpenApi\Http\Middleware\ProjectTokenAuth;

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

//Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//
//});


Route::middleware(['formatApiResponse', ProjectTokenAuth::class])->prefix('v1')->group(function () {
	Route::prefix('translation')->group(function () {
		Route::post('collect', [TranslationController::class, 'collect']);
		Route::post('get', [TranslationController::class, 'get']);
	});
});
