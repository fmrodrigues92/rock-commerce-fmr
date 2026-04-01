<?php

namespace App\src\Auth\Application\UseCases;

use App\Models\User;
use App\src\Auth\Application\Services\AuthenticatorService;

class LogoutUserUseCase
{
    public function __construct(
        private AuthenticatorService $authenticatorService
    ) {
    }

    public function execute(User $user): void
    {
        $this->authenticatorService->logout($user);
    }
}