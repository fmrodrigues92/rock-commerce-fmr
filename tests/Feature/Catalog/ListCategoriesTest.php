<?php

namespace Tests\Feature\Catalog;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_categories(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        Category::query()->create(['name' => 'Eletrônicos']);
        Category::query()->create(['name' => 'Games']);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/categories');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Categorias listadas com sucesso.',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }
}