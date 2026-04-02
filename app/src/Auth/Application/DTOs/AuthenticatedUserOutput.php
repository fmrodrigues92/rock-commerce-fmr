<?php

namespace App\src\Auth\Application\DTOs;

class AuthenticatedUserOutput
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
    ) {
    }
}