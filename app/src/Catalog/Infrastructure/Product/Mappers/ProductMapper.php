<?php

namespace App\src\Catalog\Infrastructure\Product\Mappers;

use App\Models\Product;
use App\src\Catalog\Domain\Product\Entities\ProductEntity;

class ProductMapper
{
    public static function toEntity(Product $product): ProductEntity
    {
        return new ProductEntity(
            id: $product->id,
            categoryId: $product->category_id,
            categoryName: $product->category?->name ?? '',
            name: $product->name,
            description: $product->description,
            price: (string) $product->price,
            createdAt: $product->created_at?->toDateTimeString() ?? '',
            updatedAt: $product->updated_at?->toDateTimeString() ?? '',
        );
    }
}