<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\ListProductsRequest;
use App\src\Catalog\Application\Product\DTOs\ListProductsInput;
use App\src\Catalog\Application\Product\UseCases\GetProductUseCase;
use App\src\Catalog\Application\Product\UseCases\ListProductsUseCase;
use App\src\Catalog\Presentation\Product\Transformers\ProductTransformer;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(
        ListProductsRequest $request,
        ListProductsUseCase $useCase
    ): JsonResponse {
        $input = new ListProductsInput(
            category: $request->filled('category') ? (int) $request->input('category') : null,
            search: $request->filled('search') ? trim((string) $request->input('search')) : null,
            page: (int) $request->input('page', 1),
            perPage: (int) $request->input('per_page', 5),
        );

        $output = $useCase->execute($input);
        $transformed = ProductTransformer::transformPaginated($output);

        return response()->json([
            'success' => true,
            'message' => 'Produtos listados com sucesso.',
            'data' => $transformed['data'],
            'meta' => $transformed['meta'],
        ]);
    }

    public function show(
        int $id,
        GetProductUseCase $useCase
    ): JsonResponse {
        $output = $useCase->execute($id);

        return response()->json([
            'success' => true,
            'message' => 'Produto carregado com sucesso.',
            'data' => ProductTransformer::transform($output),
        ]);
    }
}