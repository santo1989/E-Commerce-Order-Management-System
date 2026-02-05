<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\OrderService;

class OrderServiceTest extends TestCase
{
    public function test_constants_exist()
    {
        $this->assertTrue(defined('\App\Models\Order::STATUS_PENDING'));
    }
}
