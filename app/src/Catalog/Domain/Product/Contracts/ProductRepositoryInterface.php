<?php

namespace App\src\Catalog\Domain\Product\Contracts;

use App\src\Catalog\Domain\Product\Entities\ProductEntity;

interface ProductRepositoryInterface
{
    /**
     * @return array{
     *     data: ProductEntity[],
     *     meta: array{
     *         current_page:int,
     *         per_page:int,
     *         total:int,
     *         last_page:int
     *     }
     * }
     */
    public function paginate(array $filters): array;

    public function findById(int $id): ?ProductEntity;
}