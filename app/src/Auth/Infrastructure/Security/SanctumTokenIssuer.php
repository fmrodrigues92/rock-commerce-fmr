<?php

namespace App\src\Auth\Infrastructure\Security;

use App\Models\User;
use App\src\Auth\Domain\Contracts\TokenIssuerInterface;
use App\src\Auth\Domain\Entities\UserEntity;

class SanctumTokenIssuer implements TokenIssuerInterface
{
    public function issue(UserEntity $user): string
    {
        $eloquentUser = User::query()->findOrFail($user->id);

        return $eloquentUser->createToken('auth_token')->plainTextToken;
    }
}