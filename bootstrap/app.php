<?php

use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\FinanceController;
use App\Http\Controllers\Api\V1\QuizController;
use App\Http\Controllers\Api\V1\RecipeController;
use App\Http\Controllers\Api\V1\TransportController;
use App\Http\Controllers\Api\V1\TravelController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('api/v1')->group(function () {
                // Travel routes
                Route::prefix('travel')->group(function () {
                    Route::get('/', [TravelController::class, 'index']);
                    Route::post('/', [TravelController::class, 'store']);
                    Route::get('/{id}', [TravelController::class, 'show']);
                    Route::put('/{id}', [TravelController::class, 'update']);
                    Route::delete('/{id}', [TravelController::class, 'destroy']);
                });

                // Event routes
                Route::prefix('events')->group(function () {
                    Route::get('/', [EventController::class, 'index']);
                    Route::post('/', [EventController::class, 'store']);
                    Route::get('/{id}', [EventController::class, 'show']);
                    Route::put('/{id}', [EventController::class, 'update']);
                    Route::delete('/{id}', [EventController::class, 'destroy']);
                });

                // Recipe routes
                Route::prefix('recipes')->group(function () {
                    Route::get('/', [RecipeController::class, 'index']);
                    Route::post('/', [RecipeController::class, 'store']);
                    Route::get('/{id}', [RecipeController::class, 'show']);
                    Route::put('/{id}', [RecipeController::class, 'update']);
                    Route::delete('/{id}', [RecipeController::class, 'destroy']);
                });

                // Transport routes
                Route::prefix('transport')->group(function () {
                    Route::get('/', [TransportController::class, 'index']);
                    Route::post('/', [TransportController::class, 'store']);
                    Route::get('/{id}', [TransportController::class, 'show']);
                    Route::put('/{id}', [TransportController::class, 'update']);
                    Route::delete('/{id}', [TransportController::class, 'destroy']);
                });

                // Quiz routes
                Route::prefix('quizzes')->group(function () {
                    Route::get('/', [QuizController::class, 'index']);
                    Route::post('/', [QuizController::class, 'store']);
                    Route::get('/{id}', [QuizController::class, 'show']);
                    Route::put('/{id}', [QuizController::class, 'update']);
                    Route::delete('/{id}', [QuizController::class, 'destroy']);
                });

                // Finance routes
                Route::prefix('finance')->group(function () {
                    Route::get('/', [FinanceController::class, 'index']);
                    Route::post('/', [FinanceController::class, 'store']);
                    Route::get('/{id}', [FinanceController::class, 'show']);
                    Route::put('/{id}', [FinanceController::class, 'update']);
                    Route::delete('/{id}', [FinanceController::class, 'destroy']);
                    Route::get('/gold/prices', [FinanceController::class, 'goldPrices']);
                    Route::get('/currency/rates', [FinanceController::class, 'currencyRates']);
                    Route::get('/fuel/prices', [FinanceController::class, 'fuelPrices']);
                });
            });
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
