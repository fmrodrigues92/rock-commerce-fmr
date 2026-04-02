<?php

namespace Tests\Feature\Catalog;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ListProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_products_with_pagination(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $category = Category::query()->create([
            'name' => 'Games',
        ]);

        Product::factory()->count(3)->create([
            'category_id' => $category->id,
        ]);

        $response = $this->getJson('/api/products', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Produtos listados com sucesso.',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'category_id',
                        'category_name',
                        'name',
                        'description',
                        'price',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'meta' => [
                    'current_page',
                    'per_page',
                    'total',
                    'last_page',
                ],
            ])
            ->assertJsonPath('meta.total', 3)
            ->assertJsonPath('meta.current_page', 1);
    }

    public function test_it_filters_products_by_category(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $games = Category::query()->create(['name' => 'Games']);
        $electronics = Category::query()->create(['name' => 'Eletrônicos']);

        Product::query()->create([
            'category_id' => $games->id,
            'name' => 'Controle Xbox',
            'description' => 'Controle sem fio',
            'price' => 399.90,
        ]);

        Product::query()->create([
            'category_id' => $electronics->id,
            'name' => 'Monitor 27',
            'description' => 'Monitor IPS',
            'price' => 1299.90,
        ]);

        $response = $this->getJson('/api/products?category=' . $games->id, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.name', 'Controle Xbox')
            ->assertJsonPath('data.0.category_id', $games->id)
            ->assertJsonPath('data.0.category_name', 'Games');
    }

    public function test_it_searches_products_by_name(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $category = Category::query()->create(['name' => 'Games']);

        Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Controle Xbox',
            'description' => 'Controle sem fio',
            'price' => 399.90,
        ]);

        Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Teclado Mecânico',
            'description' => 'RGB',
            'price' => 499.90,
        ]);

        $response = $this->getJson('/api/products?search=Xbox', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.name', 'Controle Xbox');
    }

    public function test_it_searches_products_by_description(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $category = Category::query()->create(['name' => 'Games']);

        Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Controle Xbox',
            'description' => 'Controle sem fio preto',
            'price' => 399.90,
        ]);

        Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Headset Gamer',
            'description' => 'Som surround',
            'price' => 599.90,
        ]);

        $response = $this->getJson('/api/products?search=preto', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.name', 'Controle Xbox');
    }

    public function test_it_validates_category_filter_when_category_does_not_exist(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->getJson('/api/products?category=999', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['category']);
    }

    public function test_it_validates_per_page(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->getJson('/api/products?per_page=999', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['per_page']);
    }
}