<?php

namespace App\src\Catalog\Domain\Category\Entities;

class CategoryEntity
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}