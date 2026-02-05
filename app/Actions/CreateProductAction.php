<?php

namespace App\Actions;

use App\Services\ProductService;

class CreateProductAction
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function handle(array $data)
    {
        return $this->service->create($data);
    }
}
