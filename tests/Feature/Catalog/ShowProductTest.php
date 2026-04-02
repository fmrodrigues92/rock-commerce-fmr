<?php

namespace Tests\Feature\Catalog;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_a_specific_product(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $category = Category::query()->create([
            'name' => 'Games',
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Controle Xbox',
            'description' => 'Controle sem fio',
            'price' => 399.90,
        ]);

        $response = $this->getJson('/api/products/' . $product->id, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Produto carregado com sucesso.',
                'data' => [
                    'id' => $product->id,
                    'category_id' => $category->id,
                    'category_name' => 'Games',
                    'name' => 'Controle Xbox',
                    'description' => 'Controle sem fio',
                    'price' => '399.90',
                    'image_url' => null,
                ],
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'category_id',
                    'category_name',
                    'name',
                    'description',
                    'price',
                    'image_url',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function test_it_returns_404_when_product_is_not_found(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->getJson('/api/products/999', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Produto não encontrado.',
                'data' => null,
            ]);
    }
}