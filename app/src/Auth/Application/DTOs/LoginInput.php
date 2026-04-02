<?php

namespace App\src\Auth\Application\DTOs;

class LoginInput
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}
}