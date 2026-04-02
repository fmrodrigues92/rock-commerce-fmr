<?php

namespace App\src\Catalog\Application\Category\Services;

use App\src\Catalog\Domain\Category\Contracts\CategoryRepositoryInterface;
use App\src\Catalog\Domain\Category\Entities\CategoryEntity;

class CategoryService
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * @return CategoryEntity[]
     */
    public function list(): array
    {
        return $this->categoryRepository->all();
    }
}