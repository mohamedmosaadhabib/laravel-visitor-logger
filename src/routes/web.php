<?php

/*
|--------------------------------------------------------------------------
| Laravel Logger Web Routes
|--------------------------------------------------------------------------
|
*/

use Baas\LaravelVisitorLogger\App\Http\Controllers\LaravelVisitorLoggerController;

Route::group(['prefix' => 'visitoractivity', 'namespace' => 'Baas\LaravelVisitorLogger\App\Http\Controllers', 'middleware' => ['web', 'auth', 'visitoractivity']], function () {

    // Dashboards
    Route::get('/', [LaravelVisitorLoggerController::class,'showAccessLog'])->name('activity');
    Route::get('/cleared', [LaravelVisitorLoggerController::class,'showClearedActivityLog'])->name('cleared');

    // Drill Downs
    Route::get('/log/{id}', [LaravelVisitorLoggerController::class,'showAccessLogEntry']);
    Route::get('/cleared/log/{id}', [LaravelVisitorLoggerController::class,'showClearedAccessLogEntry']);

    // Forms
    Route::delete('/clear-activity', [LaravelVisitorLoggerController::class,'clearActivityLog'])->name('clear-activity');
    Route::delete('/destroy-activity', [LaravelVisitorLoggerController::class,'destroyActivityLog'])->name('destroy-activity');
    Route::post('/restore-log', [LaravelVisitorLoggerController::class,'restoreClearedActivityLog'])->name('restore-activity');
});
