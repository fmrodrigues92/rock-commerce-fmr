<?php

namespace App\src\Auth\Presentation\Transformers;

use App\src\Auth\Application\DTOs\AuthenticatedUserOutput;

class AuthenticatedUserTransformer
{
    public static function transform(AuthenticatedUserOutput $output): array
    {
        return [
            'id' => $output->id,
            'name' => $output->name,
            'email' => $output->email,
        ];
    }
}