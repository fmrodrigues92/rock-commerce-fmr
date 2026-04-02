<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\MeController;
use App\Http\Controllers\Api\Catalog\CategoriesController;
use App\Http\Controllers\Api\Catalog\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//======================================================
//======================================================
//======================================================

Route::group([
        'as' => '',
        'prefix' => 'auth',
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

    Route::get('/protected', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Rota protegida acessada com sucesso.',
            'data' => [
                'user_id' => $request->user()->id,
                'email' => $request->user()->email,
            ],
        ]);        
    }); // Rota de exemplo para testar autenticação

    //lista de categorias
    Route::get('/categories', [CategoriesController::class, 'index']);

    //lista de produtos
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
});