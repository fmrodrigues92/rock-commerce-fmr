<?php

namespace Tests\Unit\Catalog\Application\Category\UseCases;

use App\src\Catalog\Application\Category\UseCases\ListCategoriesUseCase;
use App\src\Catalog\Domain\Category\Contracts\CategoryRepositoryInterface;
use App\src\Catalog\Domain\Category\Entities\CategoryEntity;
use PHPUnit\Framework\TestCase;

class ListCategoriesUseCaseTest extends TestCase
{
    public function test_it_returns_a_list_of_category_outputs(): void
    {
        $repository = $this->createMock(CategoryRepositoryInterface::class);

        $repository->method('all')->willReturn([
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

        $useCase = new ListCategoriesUseCase($repository);

        $result = $useCase->execute();

        $this->assertCount(2, $result);
        $this->assertSame('Eletrônicos', $result[0]->name);
        $this->assertSame('Games', $result[1]->name);
    }
}