<?php

namespace App\src\Catalog\Application\Product\UseCases;

use App\src\Catalog\Application\Product\DTOs\ProductOutput;
use App\src\Catalog\Domain\Product\Contracts\ProductRepositoryInterface;
use App\src\Catalog\Domain\Product\Exceptions\ProductNotFoundException;

class GetProductUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {
    }

    public function execute(int $id): ProductOutput
    {
        $product = $this->productRepository->findById($id);

        if (! $product) {
            throw new ProductNotFoundException('Produto não encontrado.');
        }

        return new ProductOutput(
            id: $product->id,
            categoryId: $product->categoryId,
            categoryName: $product->categoryName,
            name: $product->name,
            description: $product->description,
            price: $product->price,
            createdAt: $product->createdAt,
            updatedAt: $product->updatedAt,
        );
    }
}