<?php

namespace Tests\Unit\Catalog\Application\Product\Services;

use App\src\Catalog\Application\Product\Services\ProductService;
use App\src\Catalog\Domain\Product\Contracts\ProductRepositoryInterface;
use App\src\Catalog\Domain\Product\Entities\ProductEntity;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    public function test_it_returns_paginated_products_from_repository(): void
    {
        $repository = $this->createMock(ProductRepositoryInterface::class);

        $filters = [
            'category' => 1,
            'search' => 'controle',
            'page' => 1,
            'per_page' => 15,
        ];

        $repository->method('paginate')
            ->with($filters)
            ->willReturn([
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
                ],
                'meta' => [
                    'current_page' => 1,
                    'per_page' => 15,
                    'total' => 1,
                    'last_page' => 1,
                ],
            ]);

        $service = new ProductService($repository);

        $result = $service->list($filters);

        $this->assertCount(1, $result['data']);
        $this->assertSame('Controle Xbox', $result['data'][0]->name);
        $this->assertSame(1, $result['meta']['total']);
    }

    public function test_it_returns_a_product_by_id_from_repository(): void
    {
        $repository = $this->createMock(ProductRepositoryInterface::class);

        $repository->method('findById')
            ->with(1)
            ->willReturn(
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
                )
            );

        $service = new ProductService($repository);

        $result = $service->findById(1);

        $this->assertInstanceOf(ProductEntity::class, $result);
        $this->assertSame('Controle Xbox', $result->name);
    }

    public function test_it_returns_null_when_repository_does_not_find_product(): void
    {
        $repository = $this->createMock(ProductRepositoryInterface::class);

        $repository->method('findById')
            ->with(999)
            ->willReturn(null);

        $service = new ProductService($repository);

        $result = $service->findById(999);

        $this->assertNull($result);
    }
}