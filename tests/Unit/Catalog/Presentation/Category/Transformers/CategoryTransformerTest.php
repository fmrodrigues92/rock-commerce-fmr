<?php

namespace Tests\Unit\Catalog\Presentation\Category\Transformers;

use App\src\Catalog\Application\Category\DTOs\CategoryOutput;
use App\src\Catalog\Presentation\Category\Transformers\CategoryTransformer;
use PHPUnit\Framework\TestCase;

class CategoryTransformerTest extends TestCase
{
    public function test_it_transforms_a_category_output(): void
    {
        $output = new CategoryOutput(
            id: 1,
            name: 'Eletrônicos',
            createdAt: '2026-04-02 10:00:00',
            updatedAt: '2026-04-02 10:00:00',
        );

        $result = CategoryTransformer::transform($output);

        $this->assertSame([
            'id' => 1,
            'name' => 'Eletrônicos',
            'created_at' => '2026-04-02 10:00:00',
            'updated_at' => '2026-04-02 10:00:00',
        ], $result);
    }

    public function test_it_transforms_a_category_collection(): void
    {
        $categories = [
            new CategoryOutput(
                id: 1,
                name: 'Eletrônicos',
                createdAt: '2026-04-02 10:00:00',
                updatedAt: '2026-04-02 10:00:00',
            ),
            new CategoryOutput(
                id: 2,
                name: 'Games',
                createdAt: '2026-04-02 11:00:00',
                updatedAt: '2026-04-02 11:00:00',
            ),
        ];

        $result = CategoryTransformer::transformCollection($categories);

        $this->assertCount(2, $result);
        $this->assertSame('Eletrônicos', $result[0]['name']);
        $this->assertSame('Games', $result[1]['name']);
    }
}