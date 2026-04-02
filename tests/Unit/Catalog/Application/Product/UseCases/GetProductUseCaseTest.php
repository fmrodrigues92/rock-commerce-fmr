<?php

namespace Tests\Unit\Catalog\Application\Product\UseCases;

use App\src\Catalog\Application\Product\Services\ProductService;
use App\src\Catalog\Application\Product\UseCases\GetProductUseCase;
use App\src\Catalog\Domain\Product\Entities\ProductEntity;
use App\src\Catalog\Domain\Product\Exceptions\ProductNotFoundException;
use PHPUnit\Framework\TestCase;

class GetProductUseCaseTest extends TestCase
{
    public function test_it_returns_a_product_output(): void
    {
        $service = $this->createMock(ProductService::class);

        $service->method('findById')->with(1)->willReturn(
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

        $useCase = new GetProductUseCase($service);

        $result = $useCase->execute(1);

        $this->assertSame(1, $result->id);
        $this->assertSame(1, $result->categoryId);
        $this->assertSame('Games', $result->categoryName);
        $this->assertSame('Controle Xbox', $result->name);
        $this->assertSame('Controle sem fio', $result->description);
        $this->assertSame('399.90', $result->price);
        $this->assertSame('https://example.com/controle.jpg', $result->imageUrl);
    }

    public function test_it_throws_exception_when_product_is_not_found(): void
    {
        $service = $this->createMock(ProductService::class);

        $service->method('findById')->with(999)->willReturn(null);

        $useCase = new GetProductUseCase($service);

        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('Produto não encontrado.');

        $useCase->execute(999);
    }
}