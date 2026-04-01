<?php

namespace Tests\Unit\Auth\ValueObjects;

use App\src\Auth\Domain\ValueObjects\Email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function test_it_creates_a_valid_email(): void
    {
        $email = new Email('Fernando@Email.com ');

        $this->assertSame('fernando@email.com', $email->value());
    }

    public function test_it_throws_exception_for_invalid_email(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('E-mail inválido.');

        new Email('email-invalido');
    }

    public function test_it_compares_two_equal_emails(): void
    {
        $email1 = new Email('teste@email.com');
        $email2 = new Email('teste@email.com');

        $this->assertTrue($email1->equals($email2));
    }

    public function test_it_returns_string_representation(): void
    {
        $email = new Email('teste@email.com');

        $this->assertSame('teste@email.com', (string) $email);
    }
}