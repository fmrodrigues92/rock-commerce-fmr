<?php

namespace App\src\Catalog\Application\Product\DTOs;

class ProductOutput
{
    public function __construct(
        public readonly int $id,
        public readonly int $categoryId,
        public readonly string $categoryName,
        public readonly string $name,
        public readonly ?string $description,
        public readonly string $price,
        public readonly ?string $imageUrl,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}