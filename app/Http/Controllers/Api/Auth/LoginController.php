<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\src\Auth\Application\DTOs\LoginInput;
use App\src\Auth\Application\UseCases\LoginUserUseCase;
use App\src\Auth\Presentation\Transformers\AuthResponseTransformer;
use Illuminate\Http\JsonResponse;
use Dedoc\Scramble\Attributes\Group;

#[Group('Auth')]
class LoginController extends Controller
{
    public function __invoke(
        LoginRequest $request,
        LoginUserUseCase $useCase
    ): JsonResponse {
        $input = new LoginInput(
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString(),
        );

        $output = $useCase->execute($input);

        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso.',
            'data' => AuthResponseTransformer::transform($output),
        ]);
    }
}