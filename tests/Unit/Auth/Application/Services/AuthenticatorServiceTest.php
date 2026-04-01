<?php

namespace Tests\Unit\Auth\Application\Services;

use App\src\Auth\Application\Services\AuthenticatorService;
use App\src\Auth\Domain\Contracts\PasswordHasherInterface;
use App\src\Auth\Domain\Contracts\TokenIssuerInterface;
use App\src\Auth\Domain\Contracts\UserRepositoryInterface;
use App\src\Auth\Domain\Entities\UserEntity;
use App\src\Auth\Domain\Exceptions\EmailAlreadyInUseException;
use App\src\Auth\Domain\Exceptions\InvalidCredentialsException;
use PHPUnit\Framework\TestCase;

class AuthenticatorServiceTest extends TestCase
{
    public function test_it_registers_a_user_successfully(): void
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);
        $tokenIssuer = $this->createMock(TokenIssuerInterface::class);

        $service = new AuthenticatorService($repository, $hasher, $tokenIssuer);

        $repository->method('findByEmail')
            ->with('fernando@email.com')
            ->willReturn(null);

        $hasher->method('hash')
            ->with('123456')
            ->willReturn('hashed_password');

        $createdUser = new UserEntity(
            id: 1,
            name: 'Fernando',
            email: 'fernando@email.com',
            password: 'hashed_password'
        );

        $repository->method('create')
            ->willReturn($createdUser);

        $tokenIssuer->method('issue')
            ->with($createdUser)
            ->willReturn('token_123');

        [$user, $token] = $service->register(
            name: 'Fernando',
            email: 'fernando@email.com',
            password: '123456'
        );

        $this->assertSame(1, $user->id);
        $this->assertSame('Fernando', $user->name);
        $this->assertSame('fernando@email.com', $user->email);
        $this->assertSame('token_123', $token);
    }

    public function test_it_throws_exception_when_registering_with_existing_email(): void
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);
        $tokenIssuer = $this->createMock(TokenIssuerInterface::class);

        $service = new AuthenticatorService($repository, $hasher, $tokenIssuer);

        $existingUser = new UserEntity(
            id: 1,
            name: 'Fernando',
            email: 'fernando@email.com',
            password: 'hashed_password'
        );

        $repository->method('findByEmail')
            ->willReturn($existingUser);

        $this->expectException(EmailAlreadyInUseException::class);
        $this->expectExceptionMessage('E-mail já está em uso.');

        $service->register(
            name: 'Fernando',
            email: 'fernando@email.com',
            password: '123456'
        );
    }

    public function test_it_logs_in_successfully(): void
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);
        $tokenIssuer = $this->createMock(TokenIssuerInterface::class);

        $service = new AuthenticatorService($repository, $hasher, $tokenIssuer);

        $user = new UserEntity(
            id: 1,
            name: 'Fernando',
            email: 'fernando@email.com',
            password: 'hashed_password'
        );

        $repository->method('findByEmail')
            ->with('fernando@email.com')
            ->willReturn($user);

        $hasher->method('check')
            ->with('123456', 'hashed_password')
            ->willReturn(true);

        $tokenIssuer->method('issue')
            ->with($user)
            ->willReturn('token_123');

        [$loggedUser, $token] = $service->login(
            email: 'fernando@email.com',
            password: '123456'
        );

        $this->assertSame(1, $loggedUser->id);
        $this->assertSame('token_123', $token);
    }

    public function test_it_throws_exception_when_user_is_not_found_on_login(): void
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);
        $tokenIssuer = $this->createMock(TokenIssuerInterface::class);

        $service = new AuthenticatorService($repository, $hasher, $tokenIssuer);

        $repository->method('findByEmail')
            ->willReturn(null);

        $this->expectException(InvalidCredentialsException::class);
        $this->expectExceptionMessage('Credenciais inválidas.');

        $service->login(
            email: 'fernando@email.com',
            password: '123456'
        );
    }

    public function test_it_throws_exception_when_password_is_invalid(): void
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);
        $tokenIssuer = $this->createMock(TokenIssuerInterface::class);

        $service = new AuthenticatorService($repository, $hasher, $tokenIssuer);

        $user = new UserEntity(
            id: 1,
            name: 'Fernando',
            email: 'fernando@email.com',
            password: 'hashed_password'
        );

        $repository->method('findByEmail')
            ->willReturn($user);

        $hasher->method('check')
            ->with('123456', 'hashed_password')
            ->willReturn(false);

        $this->expectException(InvalidCredentialsException::class);
        $this->expectExceptionMessage('Credenciais inválidas.');

        $service->login(
            email: 'fernando@email.com',
            password: '123456'
        );
    }

    public function test_it_returns_authenticated_user_data(): void
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $hasher = $this->createMock(PasswordHasherInterface::class);
        $tokenIssuer = $this->createMock(TokenIssuerInterface::class);

        $service = new AuthenticatorService($repository, $hasher, $tokenIssuer);

        $user = new \App\Models\User();
        $user->id = 1;
        $user->name = 'Fernando';
        $user->email = 'fernando@email.com';

        $output = $service->me($user);

        $this->assertSame(1, $output->id);
        $this->assertSame('Fernando', $output->name);
        $this->assertSame('fernando@email.com', $output->email);
    }
}