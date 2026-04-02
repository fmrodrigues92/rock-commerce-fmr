<?php

namespace App\src\Auth\Application\UseCases;

use App\Models\User;
use App\src\Auth\Application\DTOs\AuthenticatedUserOutput;
use App\src\Auth\Application\Services\AuthenticatorService;

class GetAuthenticatedUserUseCase
{
    public function __construct(
        private AuthenticatorService $authenticatorService
    ) {
    }

    public function execute(User $user): AuthenticatedUserOutput
    {
        return $this->authenticatorService->me($user);
    }
}