<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::query()->pluck('id', 'name');

        if ($categories->isEmpty()) {
            return;
        }

        $products = [
            [
                'category_name' => 'Eletrônicos',
                'name' => 'Monitor 27"',
                'description' => 'Monitor IPS 27 polegadas Full HD.',
                'price' => 1299.90,
            ],
            [
                'category_name' => 'Eletrônicos',
                'name' => 'Soundbar',
                'description' => 'Soundbar com conexão Bluetooth.',
                'price' => 899.90,
            ],
            [
                'category_name' => 'Informática',
                'name' => 'Notebook i5',
                'description' => 'Notebook com 16GB RAM e SSD de 512GB.',
                'price' => 3899.90,
            ],
            [
                'category_name' => 'Informática',
                'name' => 'Teclado Mecânico',
                'description' => 'Teclado mecânico com iluminação RGB.',
                'price' => 499.90,
            ],
            [
                'category_name' => 'Celulares',
                'name' => 'Smartphone 256GB',
                'description' => 'Smartphone com 256GB de armazenamento.',
                'price' => 2499.90,
            ],
            [
                'category_name' => 'Celulares',
                'name' => 'Carregador Turbo',
                'description' => 'Carregador rápido USB-C 45W.',
                'price' => 149.90,
            ],
            [
                'category_name' => 'Acessórios',
                'name' => 'Mouse sem fio',
                'description' => 'Mouse ergonômico com conexão sem fio.',
                'price' => 129.90,
            ],
            [
                'category_name' => 'Acessórios',
                'name' => 'Headset Bluetooth',
                'description' => 'Headset com cancelamento de ruído.',
                'price' => 349.90,
            ],
            [
                'category_name' => 'Games',
                'name' => 'Controle Xbox',
                'description' => 'Controle sem fio para Xbox e PC.',
                'price' => 399.90,
            ],
            [
                'category_name' => 'Games',
                'name' => 'Console Gamer',
                'description' => 'Console de última geração com SSD.',
                'price' => 4499.90,
            ],
        ];

        foreach ($products as $product) {
            $categoryId = $categories->get($product['category_name']);

            if (! $categoryId) {
                continue;
            }

            Product::query()->firstOrCreate(
                [
                    'category_id' => $categoryId,
                    'name' => $product['name'],
                ],
                [
                    'description' => $product['description'],
                    'price' => $product['price'],
                ]
            );
        }
    }
}