<?php

namespace App\src\Catalog\Infrastructure\Category\Persistence;

use App\Models\Category;
use App\src\Catalog\Domain\Category\Contracts\CategoryRepositoryInterface;
use App\src\Catalog\Domain\Category\Entities\CategoryEntity;
use App\src\Catalog\Infrastructure\Category\Mappers\CategoryMapper;

class EloquentCategoryRepository implements CategoryRepositoryInterface
{
    public function all(): array
    {
        return Category::query()
            ->orderBy('id')
            ->get()
            ->map(fn (Category $category) => CategoryMapper::toEntity($category))
            ->all();
    }
}