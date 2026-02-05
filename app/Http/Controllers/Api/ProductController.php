<?php

namespace App\Http\Controllers\Api;

use App\Actions\CreateProductAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    protected CreateProductAction $createAction;

    public function __construct(CreateProductAction $createAction)
    {
        $this->createAction = $createAction;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sku' => 'required|string|unique:products,sku',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = $this->createAction->handle($data);

        return response()->json($product, Response::HTTP_CREATED);
    }
}
