<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CheckPromotionController;
use App\Http\Controllers\API\PromotionController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin')->as('admin.')->group(function () {
        Route::apiResource('promotions', PromotionController::class);
    });
    Route::post('promotions/check', [CheckPromotionController::class, 'checkCode']);
});
