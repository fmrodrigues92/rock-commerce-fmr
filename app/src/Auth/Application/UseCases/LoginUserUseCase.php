<?php

namespace App\src\Auth\Application\UseCases;

use App\src\Auth\Application\DTOs\AuthOutput;
use App\src\Auth\Application\DTOs\LoginInput;
use App\src\Auth\Application\Services\AuthenticatorService;

class LoginUserUseCase
{
    public function __construct(
        private AuthenticatorService $authenticatorService
    ) {
    }

    public function execute(LoginInput $input): AuthOutput
    {
        [$user, $token] = $this->authenticatorService->login(
            email: $input->email,
            password: $input->password,
        );

        return new AuthOutput(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            token: $token,
        );
    }
}