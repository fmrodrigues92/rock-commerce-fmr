<?php

namespace App\Providers;

use App\src\Auth\Domain\Contracts\PasswordHasherInterface;
use App\src\Auth\Domain\Contracts\TokenIssuerInterface;
use App\src\Auth\Domain\Contracts\UserRepositoryInterface;
use App\src\Auth\Infrastructure\Persistence\EloquentUserRepository;
use App\src\Auth\Infrastructure\Security\LaravelPasswordHasher;
use App\src\Auth\Infrastructure\Security\SanctumTokenIssuer;
use App\src\Catalog\Domain\Category\Contracts\CategoryRepositoryInterface;
use App\src\Catalog\Infrastructure\Category\Persistence\EloquentCategoryRepository;
use App\src\Catalog\Domain\Product\Contracts\ProductRepositoryInterface;
use App\src\Catalog\Infrastructure\Product\Persistence\EloquentProductRepository;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(PasswordHasherInterface::class, LaravelPasswordHasher::class);
        $this->app->bind(TokenIssuerInterface::class, SanctumTokenIssuer::class);

        $this->app->bind(CategoryRepositoryInterface::class, EloquentCategoryRepository::class);

        $this->app->bind(ProductRepositoryInterface::class, EloquentProductRepository::class);
    }

    public function boot(): void
    {
    }
}