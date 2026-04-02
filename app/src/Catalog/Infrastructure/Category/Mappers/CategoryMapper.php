<?php

namespace App\src\Catalog\Infrastructure\Category\Mappers;

use App\Models\Category;
use App\src\Catalog\Domain\Category\Entities\CategoryEntity;

class CategoryMapper
{
    public static function toEntity(Category $category): CategoryEntity
    {
        return new CategoryEntity(
            id: $category->id,
            name: $category->name,
            createdAt: $category->created_at?->toDateTimeString() ?? '',
            updatedAt: $category->updated_at?->toDateTimeString() ?? '',
        );
    }
}