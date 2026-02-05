<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->repository->create($data);
        });
    }

    public function updateStock(int $productId, int $delta): bool
    {
        return DB::transaction(function () use ($productId, $delta) {
            $product = $this->repository->find($productId);
            if (! $product) {
                return false;
            }

            $product->stock = max(0, $product->stock + $delta);
            return (bool) $product->save();
        });
    }
}
