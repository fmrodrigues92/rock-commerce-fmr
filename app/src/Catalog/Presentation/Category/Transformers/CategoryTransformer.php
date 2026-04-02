<?php

namespace App\src\Catalog\Presentation\Category\Transformers;

use App\src\Catalog\Application\Category\DTOs\CategoryOutput;

class CategoryTransformer
{
    public static function transform(CategoryOutput $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'created_at' => $category->createdAt,
            'updated_at' => $category->updatedAt,
        ];
    }

    public static function transformCollection(array $categories): array
    {
        return array_map(
            fn (CategoryOutput $category) => self::transform($category),
            $categories
        );
    }
}