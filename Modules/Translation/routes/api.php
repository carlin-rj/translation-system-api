<?php

use Illuminate\Support\Facades\Route;
use Modules\Translation\Http\Controllers\TranslationController;
use Modules\Translation\Http\Controllers\LanguageController;
use Modules\Translation\Http\Controllers\ProjectController;

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


Route::middleware(['formatApiResponse'])->prefix('translation')->group(function () {
    Route::post('list', [TranslationController::class, 'list']);
    Route::post('create', [TranslationController::class, 'create']);
    Route::post('update', [TranslationController::class, 'update']);
    Route::post('destroy', [TranslationController::class, 'destroy']);
    Route::post('executeTranslation', [TranslationController::class, 'executeTranslation']);
    Route::post('statusCounts', [TranslationController::class, 'statusCounts']);
    Route::post('nextPendingTranslation', [TranslationController::class, 'nextPendingTranslation']);
    Route::post('export', [TranslationController::class, 'export']);

    Route::prefix('project')->group(function () {
        Route::post('all', [ProjectController::class, 'all']);
        Route::post('create', [ProjectController::class, 'create']);
        Route::post('update', [ProjectController::class, 'update']);
        Route::post('destroy', [ProjectController::class, 'destroy']);
    });

	Route::prefix('language')->group(function () {
		Route::post('all', [LanguageController::class, 'all']);
		Route::post('list', [LanguageController::class, 'list']);
		Route::post('create', [LanguageController::class, 'create']);
		Route::post('update', [LanguageController::class, 'update']);
		Route::post('destroy', [LanguageController::class, 'destroy']);
	});
});





