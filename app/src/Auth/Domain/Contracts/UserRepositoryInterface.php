<?php

namespace App\src\Auth\Domain\Contracts;

use App\src\Auth\Domain\Entities\UserEntity;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?UserEntity;

    public function create(UserEntity $user): UserEntity;
}