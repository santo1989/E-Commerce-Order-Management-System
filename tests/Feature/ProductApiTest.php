<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product()
    {
        $payload = [
            'sku' => 'TEST-001',
            'name' => 'Test Product',
            'price' => 9.99,
            'stock' => 100,
        ];

        $response = $this->postJson('/api/v1/products', $payload);

        $response->assertStatus(201)->assertJsonFragment(['sku' => 'TEST-001']);
    }
}
