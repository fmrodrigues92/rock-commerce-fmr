<?php

namespace App\src\Catalog\Application\Category\UseCases;

use App\src\Catalog\Application\Category\DTOs\CategoryOutput;
use App\src\Catalog\Domain\Category\Contracts\CategoryRepositoryInterface;

class ListCategoriesUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * @return CategoryOutput[]
     */
    public function execute(array $filters = []): array
    {
        $categories = $this->categoryRepository->all();

        return array_map(
            fn ($category) => new CategoryOutput(
                id: $category->id,
                name: $category->name,
                createdAt: $category->createdAt,
                updatedAt: $category->updatedAt,
            ),
            $categories
        );
    }
}