<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Eletrônicos'],
            ['name' => 'Informática'],
            ['name' => 'Celulares'],
            ['name' => 'Acessórios'],
            ['name' => 'Games'],
        ];

        foreach ($categories as $category) {
            Category::query()->firstOrCreate([
                'name' => $category['name'],
            ]);
        }
    }
}
