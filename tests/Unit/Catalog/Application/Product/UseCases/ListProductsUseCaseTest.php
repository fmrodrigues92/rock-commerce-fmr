<?php

namespace Tests\Unit\Catalog\Application\Product\UseCases;

use App\src\Catalog\Application\Product\DTOs\ListProductsInput;
use App\src\Catalog\Application\Product\Services\ProductService;
use App\src\Catalog\Application\Product\UseCases\ListProductsUseCase;
use App\src\Catalog\Domain\Product\Entities\ProductEntity;
use PHPUnit\Framework\TestCase;

class ListProductsUseCaseTest extends TestCase
{
    public function test_it_returns_paginated_products_output(): void
    {
        $service = $this->createMock(ProductService::class);

        $service->method('list')->willReturn([
            'data' => [
                new ProductEntity(
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
                new ProductEntity(
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
            'meta' => [
                'current_page' => 1,
                'per_page' => 15,
                'total' => 2,
                'last_page' => 1,
            ],
        ]);

        $useCase = new ListProductsUseCase($service);

        $input = new ListProductsInput(
            category: null,
            search: null,
            page: 1,
            perPage: 15,
        );

        $result = $useCase->execute($input);

        $this->assertCount(2, $result->data);
        $this->assertSame(1, $result->meta['current_page']);
        $this->assertSame(15, $result->meta['per_page']);
        $this->assertSame(2, $result->meta['total']);
        $this->assertSame(1, $result->meta['last_page']);

        $this->assertSame('Controle Xbox', $result->data[0]->name);
        $this->assertSame('399.90', $result->data[0]->price);
        $this->assertSame('https://example.com/controle.jpg', $result->data[0]->imageUrl);

        $this->assertSame('Soundbar', $result->data[1]->name);
        $this->assertSame('Eletrônicos', $result->data[1]->categoryName);
    }

    public function test_it_returns_empty_paginated_products_output(): void
    {
        $service = $this->createMock(ProductService::class);

        $service->method('list')->willReturn([
            'data' => [],
            'meta' => [
                'current_page' => 1,
                'per_page' => 15,
                'total' => 0,
                'last_page' => 1,
            ],
        ]);

        $useCase = new ListProductsUseCase($service);

        $input = new ListProductsInput(
            category: null,
            search: null,
            page: 1,
            perPage: 15,
        );

        $result = $useCase->execute($input);

        $this->assertIsArray($result->data);
        $this->assertCount(0, $result->data);
        $this->assertSame(0, $result->meta['total']);
    }
}