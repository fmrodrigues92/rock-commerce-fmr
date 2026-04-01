<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\src\Auth\Application\UseCases\GetAuthenticatedUserUseCase;
use App\src\Auth\Presentation\Transformers\AuthenticatedUserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __invoke(
        Request $request,
        GetAuthenticatedUserUseCase $useCase
    ): JsonResponse {
        $output = $useCase->execute($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Usuário autenticado carregado com sucesso.',
            'data' => AuthenticatedUserTransformer::transform($output),
        ]);
    }
}