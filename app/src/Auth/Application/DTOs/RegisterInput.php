<?php

namespace App\src\Auth\Application\DTOs;

class RegisterInput
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {}
}