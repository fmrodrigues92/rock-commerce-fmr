<?php

namespace Tests\Unit\Auth\ValueObjects;

use App\src\Auth\Domain\ValueObjects\PlainPassword;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PlainPasswordTest extends TestCase
{
    public function test_it_creates_a_valid_password(): void
    {
        $password = new PlainPassword('123456');

        $this->assertSame('123456', $password->value());
    }

    public function test_it_throws_exception_when_password_is_too_short(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('A senha deve ter no mínimo 6 caracteres.');

        new PlainPassword('123');
    }

    public function test_it_returns_string_representation(): void
    {
        $password = new PlainPassword('123456');

        $this->assertSame('123456', (string) $password);
    }
}