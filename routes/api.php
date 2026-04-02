<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\MeController;
use App\Http\Controllers\Api\Catalog\CategoriesController;
use App\Http\Controllers\Api\Catalog\ProductController;

Route::group([
        'as' => '',
        'prefix' => '',
        'middleware' => [],
    ], function () {
        
        Route::middleware('guest:sanctum')->group(function () {
            Route::post('/register', RegisterController::class);
            Route::post('/login', LoginController::class);
        });

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', LogoutController::class);
            Route::get('/me', MeController::class);
        });
});

Route::group([
    'as' => 'api.',
    'prefix' => '',
    'middleware' => ['auth:sanctum'],
], function () {
    // Rotas protegidas por autenticação

    //lista de categorias
    Route::get('/categories', [CategoriesController::class, 'index']);

    //lista de produtos
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
});