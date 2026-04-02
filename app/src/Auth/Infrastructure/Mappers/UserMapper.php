<?php

namespace App\src\Auth\Infrastructure\Mappers;

use App\Models\User;
use App\src\Auth\Domain\Entities\UserEntity;

class UserMapper
{
    public static function toEntity(User $user): UserEntity
    {
        return new UserEntity(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            password: $user->password,
        );
    }
}