<?php

namespace App\src\Auth\Domain\Contracts;

use App\src\Auth\Domain\Entities\UserEntity;

interface TokenIssuerInterface
{
    public function issue(UserEntity $user): string;
}