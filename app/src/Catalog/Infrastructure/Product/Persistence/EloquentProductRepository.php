<?php

namespace App\src\Catalog\Infrastructure\Product\Persistence;

use App\Models\Product;
use App\src\Catalog\Domain\Product\Contracts\ProductRepositoryInterface;
use App\src\Catalog\Domain\Product\Entities\ProductEntity;
use App\src\Catalog\Infrastructure\Product\Mappers\ProductMapper;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function paginate(array $filters): array
    {
        $query = Product::query()
            ->with('category')
            ->orderBy('id');

        if (! empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (! empty($filters['search'])) {
            $search = trim($filters['search']);

            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $paginated = $query->paginate(
            perPage: $filters['per_page'] ?? 15,
            page: $filters['page'] ?? 1
        );

        return [
            'data' => $paginated->getCollection()
                ->map(fn (Product $product) => ProductMapper::toEntity($product))
                ->all(),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
                'last_page' => $paginated->lastPage(),
            ],
        ];
    }

    public function findById(int $id): ?ProductEntity
    {
        $product = Product::query()
            ->with('category')
            ->find($id);

        if (! $product) {
            return null;
        }

        return ProductMapper::toEntity($product);
    }
}