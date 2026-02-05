<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use App\Services\OrderService;
use App\Repositories\EloquentBaseRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ProductRepository::class, function ($app) {
            return new ProductRepository(new Product());
        });

        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepository::class));
        });

        $this->app->singleton(OrderService::class, function ($app) {
            return new OrderService($app->make(EloquentBaseRepository::class), $app->make(ProductRepository::class));
        });
    }

    public function boot(): void
    {
        //
    }
}
