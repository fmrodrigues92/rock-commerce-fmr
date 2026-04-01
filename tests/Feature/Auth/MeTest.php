<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_the_authenticated_user(): void
    {
        $user = User::factory()->create([
            'name' => 'Fernando',
            'email' => 'fernando@email.com',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/auth/me');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Usuário autenticado carregado com sucesso.',
                'data' => [
                    'id' => $user->id,
                    'name' => 'Fernando',
                    'email' => 'fernando@email.com',
                ],
            ]);
    }

    public function test_it_blocks_unauthenticated_access_to_me(): void
    {
        $response = $this->getJson('/api/auth/me');

        $response->assertUnauthorized();
    }
}