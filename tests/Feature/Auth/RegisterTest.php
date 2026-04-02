<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_registers_a_user_successfully(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Fernando',
            'email' => 'fernando@email.com',
            'password' => '123456',
        ]);

        $response->assertCreated()
            ->assertJson([
                'success' => true,
                'message' => 'Usuário cadastrado com sucesso.',
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

        $this->assertDatabaseHas('users', [
            'email' => 'fernando@email.com',
            'name' => 'Fernando',
        ]);
    }

    public function test_it_validates_required_fields_on_register(): void
    {
        $response = $this->postJson('/api/auth/register', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_it_does_not_register_with_duplicated_email(): void
    {
        User::factory()->create([
            'email' => 'fernando@email.com',
        ]);

        $response = $this->postJson('/api/auth/register', [
            'name' => 'Fernando',
            'email' => 'fernando@email.com',
            'password' => '123456',
        ]);

        $response->assertStatus(400);
    }
}