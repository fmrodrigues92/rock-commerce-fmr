<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\ListCategoriesRequest;
use App\src\Catalog\Application\Category\UseCases\ListCategoriesUseCase;
use App\src\Catalog\Presentation\Category\Transformers\CategoryTransformer;
use Illuminate\Http\JsonResponse;

class CategoriesController extends Controller
{
    public function index(
        ListCategoriesRequest $request,
        ListCategoriesUseCase $useCase
    ): JsonResponse {
        $filters = $request->filters();

        $output = $useCase->execute($filters);

        return response()->json([
            'success' => true,
            'message' => 'Categorias listadas com sucesso.',
            'data' => CategoryTransformer::transformCollection($output),
        ]);
    }
}
