<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends EloquentBaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function findBySku(string $sku): ?Product
    {
        return $this->model->where('sku', $sku)->first();
    }
}
