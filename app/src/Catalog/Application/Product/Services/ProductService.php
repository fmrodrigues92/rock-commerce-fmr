<?php

namespace App\src\Catalog\Application\Product\Services;

use App\src\Catalog\Domain\Product\Contracts\ProductRepositoryInterface;
use App\src\Catalog\Domain\Product\Entities\ProductEntity;

class ProductService
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {
    }

    public function list(array $filters): array
    {
        return $this->productRepository->paginate($filters);
    }

    public function findById(int $id): ?ProductEntity
    {
        return $this->productRepository->findById($id);
    }
}