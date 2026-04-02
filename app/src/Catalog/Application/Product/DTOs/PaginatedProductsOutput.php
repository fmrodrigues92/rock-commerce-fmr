<?php

namespace App\src\Catalog\Application\Product\DTOs;

class PaginatedProductsOutput
{
    /**
     * @param ProductListItemOutput[] $data
     */
    public function __construct(
        public readonly array $data,
        public readonly array $meta,
    ) {
    }
}