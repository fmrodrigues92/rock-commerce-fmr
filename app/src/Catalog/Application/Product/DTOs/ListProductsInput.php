<?php

namespace App\src\Catalog\Application\Product\DTOs;

class ListProductsInput
{
    public function __construct(
        public readonly ?int $category,
        public readonly ?string $search,
        public readonly int $page,
        public readonly int $perPage,
    ) {
    }
}