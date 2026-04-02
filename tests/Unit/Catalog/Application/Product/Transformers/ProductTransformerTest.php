<?php

namespace Tests\Unit\Catalog\Presentation\Product\Transformers;

use App\src\Catalog\Application\Product\DTOs\PaginatedProductsOutput;
use App\src\Catalog\Application\Product\DTOs\ProductListItemOutput;
use App\src\Catalog\Application\Product\DTOs\ProductOutput;
use App\src\Catalog\Presentation\Product\Transformers\ProductTransformer;
use PHPUnit\Framework\TestCase;

class ProductTransformerTest extends TestCase
{
    public function test_it_transforms_a_product_output(): void
    {
        $output = new ProductOutput(
            id: 1,
            categoryId: 1,
            categoryName: 'Games',
            name: 'Controle Xbox',
            description: 'Controle sem fio',
            price: '399.90',
            imageUrl: 'https://example.com/controle.jpg',
            createdAt: '2026-04-02 10:00:00',
            updatedAt: '2026-04-02 10:00:00',
        );

        $result = ProductTransformer::transform($output);

        $this->assertSame([
            'id' => 1,
            'category_id' => 1,
            'category_name' => 'Games',
            'name' => 'Controle Xbox',
            'description' => 'Controle sem fio',
            'price' => '399.90',
            'image_url' => 'https://example.com/controle.jpg',
            'created_at' => '2026-04-02 10:00:00',
            'updated_at' => '2026-04-02 10:00:00',
        ], $result);
    }

    public function test_it_transforms_paginated_products_output(): void
    {
        $output = new PaginatedProductsOutput(
            data: [
                new ProductListItemOutput(
                    id: 1,
                    categoryId: 1,
                    categoryName: 'Games',
                    name: 'Controle Xbox',
                    description: 'Controle sem fio',
                    price: '399.90',
                    imageUrl: 'https://example.com/controle.jpg',
                    createdAt: '2026-04-02 10:00:00',
                    updatedAt: '2026-04-02 10:00:00',
                ),
                new ProductListItemOutput(
                    id: 2,
                    categoryId: 2,
                    categoryName: 'Eletrônicos',
                    name: 'Soundbar',
                    description: 'Som potente',
                    price: '899.90',
                    imageUrl: 'https://example.com/soundbar.jpg',
                    createdAt: '2026-04-02 11:00:00',
                    updatedAt: '2026-04-02 11:00:00',
                ),
            ],
            meta: [
                'current_page' => 1,
                'per_page' => 15,
                'total' => 2,
                'last_page' => 1,
            ],
        );

        $result = ProductTransformer::transformPaginated($output);

        $this->assertCount(2, $result['data']);
        $this->assertSame(1, $result['meta']['current_page']);
        $this->assertSame(2, $result['meta']['total']);

        $this->assertSame([
            'id' => 1,
            'category_id' => 1,
            'category_name' => 'Games',
            'name' => 'Controle Xbox',
            'description' => 'Controle sem fio',
            'price' => '399.90',
            'image_url' => 'https://example.com/controle.jpg',
            'created_at' => '2026-04-02 10:00:00',
            'updated_at' => '2026-04-02 10:00:00',
        ], $result['data'][0]);

        $this->assertSame([
            'id' => 2,
            'category_id' => 2,
            'category_name' => 'Eletrônicos',
            'name' => 'Soundbar',
            'description' => 'Som potente',
            'price' => '899.90',
            'image_url' => 'https://example.com/soundbar.jpg',
            'created_at' => '2026-04-02 11:00:00',
            'updated_at' => '2026-04-02 11:00:00',
        ], $result['data'][1]);
    }

    public function test_it_returns_empty_data_when_paginated_output_is_empty(): void
    {
        $output = new PaginatedProductsOutput(
            data: [],
            meta: [
                'current_page' => 1,
                'per_page' => 15,
                'total' => 0,
                'last_page' => 1,
            ],
        );

        $result = ProductTransformer::transformPaginated($output);

        $this->assertSame([], $result['data']);
        $this->assertSame(0, $result['meta']['total']);
    }
}