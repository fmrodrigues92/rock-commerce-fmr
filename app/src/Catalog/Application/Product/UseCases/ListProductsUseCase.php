<?php

namespace App\src\Catalog\Application\Product\UseCases;

use App\src\Catalog\Application\Product\DTOs\ListProductsInput;
use App\src\Catalog\Application\Product\DTOs\PaginatedProductsOutput;
use App\src\Catalog\Application\Product\DTOs\ProductListItemOutput;
use App\src\Catalog\Domain\Product\Contracts\ProductRepositoryInterface;

class ListProductsUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {
    }

    public function execute(ListProductsInput $input): PaginatedProductsOutput
    {
        $result = $this->productRepository->paginate([
            'category' => $input->category,
            'search' => $input->search,
            'page' => $input->page,
            'per_page' => $input->perPage,
        ]);

        $items = array_map(
            fn ($product) => new ProductListItemOutput(
                id: $product->id,
                categoryId: $product->categoryId,
                categoryName: $product->categoryName,
                name: $product->name,
                description: $product->description,
                price: $product->price,
                imageUrl: $product->imageUrl,
                createdAt: $product->createdAt,
                updatedAt: $product->updatedAt,
            ),
            $result['data']
        );

        return new PaginatedProductsOutput(
            data: $items,
            meta: $result['meta'],
        );
    }
}