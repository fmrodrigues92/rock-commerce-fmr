<?php

namespace App\src\Catalog\Domain\Category\Contracts;

use App\src\Catalog\Domain\Category\Entities\CategoryEntity;

interface CategoryRepositoryInterface
{
    /**
     * @return CategoryEntity[]
     */
    public function all(): array;
}