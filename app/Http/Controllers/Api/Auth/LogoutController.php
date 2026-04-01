<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\src\Auth\Application\UseCases\LogoutUserUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(
        Request $request,
        LogoutUserUseCase $useCase
    ): JsonResponse {
        $useCase->execute($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Logout realizado com sucesso.',
            'data' => null,
        ]);
    }
}