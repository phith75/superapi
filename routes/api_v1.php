<?php

use App\Http\Controllers\Api\V1\TravelController;
use Illuminate\Support\Facades\Route;

Route::prefix('travel')->group(function () {
    Route::get('/', [TravelController::class, 'index']);
    Route::post('/', [TravelController::class, 'store']);
    Route::get('/{id}', [TravelController::class, 'show']);
    Route::put('/{id}', [TravelController::class, 'update']);
    Route::delete('/{id}', [TravelController::class, 'destroy']);
});
