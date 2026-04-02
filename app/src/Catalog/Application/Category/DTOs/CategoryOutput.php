<?php

namespace App\src\Catalog\Application\Category\DTOs;

class CategoryOutput
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}