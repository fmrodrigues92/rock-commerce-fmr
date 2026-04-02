<?php

namespace App\src\Auth\Presentation\Transformers;

use App\src\Auth\Application\DTOs\AuthOutput;

class AuthResponseTransformer
{
    public static function transform(AuthOutput $output): array
    {
        return [
            'user' => [
                'id' => $output->id,
                'name' => $output->name,
                'email' => $output->email,
            ],
            'token' => $output->token,
        ];
    }
}