<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logs_in_successfully(): void
    {
        User::factory()->create([
            'name' => 'Fernando',
            'email' => 'fernando@email.com',
            'password' => Hash::make('123456'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'fernando@email.com',
            'password' => '123456',
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Login realizado com sucesso.',
                'data' => [
                    'user' => [
                        'name' => 'Fernando',
                        'email' => 'fernando@email.com',
                    ],
                ],
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user' => ['id', 'name', 'email'],
                    'token',
                ],
            ]);
    }

    public function test_it_returns_error_for_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'fernando@email.com',
            'password' => Hash::make('123456'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'fernando@email.com',
            'password' => 'senha_errada',
        ]);

        $response->assertStatus(401);
    }

    public function test_it_validates_required_fields_on_login(): void
    {
        $response = $this->postJson('/api/auth/login', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }
}