<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logs_out_the_authenticated_user_and_deletes_current_token(): void
    {
        $user = User::factory()->create();

        $plainTextToken = $user->createToken('auth_token')->plainTextToken;
        $tokenId = explode('|', $plainTextToken)[0];

        $this->assertDatabaseHas('personal_access_tokens', [
            'id' => $tokenId,
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $plainTextToken)
            ->postJson('/api/logout');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Logout realizado com sucesso.',
                'data' => null,
            ]);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $tokenId,
        ]);
    }

    public function test_it_blocks_unauthenticated_access_to_logout(): void
    {
        $response = $this->postJson('/api/logout');

        $response->assertUnauthorized();
    }
}