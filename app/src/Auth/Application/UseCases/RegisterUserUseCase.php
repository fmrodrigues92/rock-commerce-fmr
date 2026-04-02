<?php

namespace App\src\Auth\Application\UseCases;

use App\src\Auth\Application\DTOs\AuthOutput;
use App\src\Auth\Application\DTOs\RegisterInput;
use App\src\Auth\Application\Services\AuthenticatorService;

class RegisterUserUseCase
{
    public function __construct(
        private AuthenticatorService $authenticatorService
    ) {
    }

    public function execute(RegisterInput $input): AuthOutput
    {
        [$user, $token] = $this->authenticatorService->register(
            name: $input->name,
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