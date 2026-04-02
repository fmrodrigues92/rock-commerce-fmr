<?php

namespace App\src\Catalog\Presentation\Product\Transformers;

use App\src\Catalog\Application\Product\DTOs\PaginatedProductsOutput;
use App\src\Catalog\Application\Product\DTOs\ProductOutput;

class ProductTransformer
{
    public static function transform(ProductOutput $product): array
    {
        return [
            'id' => $product->id,
            'category_id' => $product->categoryId,
            'category_name' => $product->categoryName,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'created_at' => $product->createdAt,
            'updated_at' => $product->updatedAt,
        ];
    }

    public static function transformPaginated(PaginatedProductsOutput $output): array
    {
        return [
            'data' => array_map(
                fn ($product) => [
                    'id' => $product->id,
                    'category_id' => $product->categoryId,
                    'category_name' => $product->categoryName,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'created_at' => $product->createdAt,
                    'updated_at' => $product->updatedAt,
                ],
                $output->data
            ),
            'meta' => $output->meta,
        ];
    }
}