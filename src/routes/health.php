<?php
use Illuminate\Support\Facades\Route;
use Inventcorp\LaravelBasePackage\HealthCheck\HealthController;

// health check endpoints
Route::group(['prefix' => 'web/health', 'as' => 'health.'], function () {
    Route::get('', [HealthController::class, 'webCheck'])->name('web');
    Route::get('throwException', [HealthController::class, 'throwException'])
        ->name('throw-exception')
        ->middleware('access-control');
});
