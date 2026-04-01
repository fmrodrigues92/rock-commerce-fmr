<?php

namespace App\src\Auth\Application\Services;

use App\Models\User;
use App\src\Auth\Domain\Contracts\PasswordHasherInterface;
use App\src\Auth\Domain\Contracts\TokenIssuerInterface;
use App\src\Auth\Domain\Contracts\UserRepositoryInterface;
use App\src\Auth\Domain\Entities\UserEntity;
use App\src\Auth\Domain\Exceptions\EmailAlreadyInUseException;
use App\src\Auth\Domain\Exceptions\InvalidCredentialsException;
use App\src\Auth\Domain\ValueObjects\Email;
use App\src\Auth\Domain\ValueObjects\PlainPassword;
use Laravel\Sanctum\PersonalAccessToken;
use App\src\Auth\Application\DTOs\AuthenticatedUserOutput;

class AuthenticatorService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHasherInterface $passwordHasher,
        private TokenIssuerInterface $tokenIssuer,
    ) {
    }

    public function register(string $name, string $email, string $password): array
    {
        $emailVO = new Email($email);
        $passwordVO = new PlainPassword($password);

        $existingUser = $this->userRepository->findByEmail($emailVO->value());

        if ($existingUser) {
            throw new EmailAlreadyInUseException('E-mail já está em uso.');
        }

        $user = new UserEntity(
            id: null,
            name: $name,
            email: $emailVO->value(),
            password: $this->passwordHasher->hash($passwordVO->value()),
        );

        $createdUser = $this->userRepository->create($user);
        $token = $this->tokenIssuer->issue($createdUser);

        return [$createdUser, $token];
    }

    public function login(string $email, string $password): array
    {
        $emailVO = new Email($email);
        $passwordVO = new PlainPassword($password);

        $user = $this->userRepository->findByEmail($emailVO->value());

        if (! $user) {
            throw new InvalidCredentialsException('Credenciais inválidas.');
        }

        if (! $this->passwordHasher->check($passwordVO->value(), $user->password)) {
            throw new InvalidCredentialsException('Credenciais inválidas.');
        }

        $token = $this->tokenIssuer->issue($user);

        return [$user, $token];
    }

    public function me(User $user): AuthenticatedUserOutput
    {
        return new AuthenticatedUserOutput(
            id: $user->id,
            name: $user->name,
            email: $user->email,
        );
    }

    public function logout(User $user): void
    {
        $token = $user->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }
    }
}