<?php

namespace App\src\Auth\Domain\Contracts;

interface PasswordHasherInterface
{
    public function hash(string $plainPassword): string;

    public function check(string $plainPassword, string $hashedPassword): bool;
}