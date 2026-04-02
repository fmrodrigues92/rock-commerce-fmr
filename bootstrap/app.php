<?php

use App\src\Auth\Domain\Exceptions\EmailAlreadyInUseException;
use App\src\Auth\Domain\Exceptions\InvalidCredentialsException;
use App\src\Catalog\Domain\Product\Exceptions\ProductNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (EmailAlreadyInUseException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'data' => null,
            ], 400);
        });

        $exceptions->render(function (InvalidCredentialsException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'data' => null,
            ], 401);
        });

        $exceptions->render(function (ProductNotFoundException $exception, $request) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'data' => null,
            ], 404);
        });
    })->create();
