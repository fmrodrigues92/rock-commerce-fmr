<?php

namespace Tests\Unit\Catalog\Application\Category\Services;

use App\src\Catalog\Application\Category\Services\CategoryService;
use App\src\Catalog\Domain\Category\Contracts\CategoryRepositoryInterface;
use App\src\Catalog\Domain\Category\Entities\CategoryEntity;
use PHPUnit\Framework\TestCase;

class CategoryServiceTest extends TestCase
{
    public function test_it_returns_all_categories_from_repository(): void
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

        $service = new CategoryService($repository);

        $result = $service->list();

        $this->assertCount(2, $result);
        $this->assertSame('Eletrônicos', $result[0]->name);
        $this->assertSame('Games', $result[1]->name);
    }

    public function test_it_returns_an_empty_array_when_repository_has_no_categories(): void
    {
        $repository = $this->createMock(CategoryRepositoryInterface::class);

        $repository->method('all')->willReturn([]);

        $service = new CategoryService($repository);

        $result = $service->list();

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }
}