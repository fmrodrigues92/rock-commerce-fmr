<?php

namespace Tests\Unit\Auth\Presentation;

use App\src\Auth\Application\DTOs\AuthOutput;
use App\src\Auth\Presentation\Transformers\AuthResponseTransformer;
use PHPUnit\Framework\TestCase;

class AuthResponseTransformerTest extends TestCase
{
    public function test_it_transforms_auth_output_to_array(): void
    {
        $output = new AuthOutput(
            id: 1,
            name: 'Fernando',
            email: 'fernando@email.com',
            token: 'token_123'
        );

        $result = AuthResponseTransformer::transform($output);

        $this->assertSame([
            'user' => [
                'id' => 1,
                'name' => 'Fernando',
                'email' => 'fernando@email.com',
            ],
            'token' => 'token_123',
        ], $result);
    }

}