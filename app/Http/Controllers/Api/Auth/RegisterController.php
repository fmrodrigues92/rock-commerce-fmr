<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\src\Auth\Application\DTOs\RegisterInput;
use App\src\Auth\Application\UseCases\RegisterUserUseCase;
use App\src\Auth\Presentation\Transformers\AuthResponseTransformer;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(
        RegisterRequest $request,
        RegisterUserUseCase $useCase
    ): JsonResponse {
        $input = new RegisterInput(
            name: $request->string('name')->toString(),
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString(),
        );

        $output = $useCase->execute($input);

        return response()->json([
            'success' => true,
            'message' => 'Usuário cadastrado com sucesso.',
            'data' => AuthResponseTransformer::transform($output),
        ], 201);
    }
}