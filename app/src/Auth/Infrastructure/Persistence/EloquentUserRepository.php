<?php

namespace App\src\Auth\Infrastructure\Persistence;

use App\Models\User;
use App\src\Auth\Domain\Contracts\UserRepositoryInterface;
use App\src\Auth\Domain\Entities\UserEntity;
use App\src\Auth\Infrastructure\Mappers\UserMapper;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?UserEntity
    {
        $user = User::query()->where('email', $email)->first();

        return $user ? UserMapper::toEntity($user) : null;
    }

    public function create(UserEntity $user): UserEntity
    {
        $eloquentUser = User::query()->create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ]);

        return UserMapper::toEntity($eloquentUser);
    }
}