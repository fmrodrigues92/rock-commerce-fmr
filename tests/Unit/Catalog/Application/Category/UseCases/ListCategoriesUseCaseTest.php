<?php

namespace Tests\Unit\Catalog\Application\Category\UseCases;

use App\src\Catalog\Application\Category\Services\CategoryService;
use App\src\Catalog\Application\Category\UseCases\ListCategoriesUseCase;
use App\src\Catalog\Domain\Category\Entities\CategoryEntity;
use PHPUnit\Framework\TestCase;

class ListCategoriesUseCaseTest extends TestCase
{
    public function test_it_returns_a_list_of_category_outputs(): void
    {
        $service = $this->createMock(CategoryService::class);

        $service->method('list')->willReturn([
            new CategoryEntity(
                id: 1,
                name: 'Eletrônicos',
                createdAt: '2026-04-02 10:00:00',
                updatedAt: '2026-04-02 10:00:00',
            ),
            new CategoryEntity(
                id: 2,
                name: 'Games',
                createdAt: '2026-04-02 11:00:00',
                updatedAt: '2026-04-02 11:00:00',
            ),
        ]);

        $useCase = new ListCategoriesUseCase($service);

        $result = $useCase->execute();

        $this->assertCount(2, $result);
        $this->assertSame(1, $result[0]->id);
        $this->assertSame('Eletrônicos', $result[0]->name);
        $this->assertSame('2026-04-02 10:00:00', $result[0]->createdAt);
        $this->assertSame('2026-04-02 10:00:00', $result[0]->updatedAt);

        $this->assertSame(2, $result[1]->id);
        $this->assertSame('Games', $result[1]->name);
    }

    public function test_it_returns_an_empty_array_when_there_are_no_categories(): void
    {
        $service = $this->createMock(CategoryService::class);

        $service->method('list')->willReturn([]);

        $useCase = new ListCategoriesUseCase($service);

        $result = $useCase->execute();

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }
}