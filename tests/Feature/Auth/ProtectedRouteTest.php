<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProtectedRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_allows_access_to_protected_route_with_valid_token(): void
    {
        $user = User::factory()->create([
            'email' => 'fernando@email.com',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/protected');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Rota protegida acessada com sucesso.',
                'data' => [
                    'user_id' => $user->id,
                    'email' => 'fernando@email.com',
                ],
            ]);
    }

    public function test_it_blocks_access_to_protected_route_without_token(): void
    {
        $response = $this->getJson('/api/protected');

        $response->assertUnauthorized();
    }

    public function test_it_blocks_access_with_invalid_token(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer token_invalido')
            ->getJson('/api/protected');

        $response->assertUnauthorized();
    }
}