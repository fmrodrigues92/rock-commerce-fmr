<?php

namespace App\src\Auth\Domain\ValueObjects;

use InvalidArgumentException;

class PlainPassword
{
    private readonly string $value;

    public function __construct(string $value)
    {
        if (mb_strlen($value) < 6) {
            throw new InvalidArgumentException('A senha deve ter no mínimo 6 caracteres.');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}