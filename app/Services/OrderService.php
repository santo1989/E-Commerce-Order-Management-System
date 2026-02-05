<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\EloquentBaseRepository;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Jobs\GenerateInvoiceJob;
use App\Jobs\SendOrderEmailJob;

class OrderService
{
    protected EloquentBaseRepository $orderRepo;
    protected ProductRepository $productRepo;

    public function __construct(EloquentBaseRepository $orderRepo, ProductRepository $productRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->productRepo = $productRepo;
    }

    public function createOrder(array $payload): Order
    {
        return DB::transaction(function () use ($payload) {
            $order = Order::create([
                'user_id' => $payload['user_id'],
                'status' => Order::STATUS_PENDING,
                'total' => 0,
                'address' => $payload['address'] ?? null,
            ]);

            $total = 0;
            foreach ($payload['items'] as $item) {
                $product = $this->productRepo->find($item['product_id']);
                if (! $product) {
                    throw new \Exception('Product not found');
                }

                // Deduct inventory immediately
                $this->productRepo->model->decrement('stock', $item['quantity']);

                $price = $product->price;
                $total += $price * $item['quantity'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'variant_id' => $item['variant_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                ]);
            }

            $order->total = $total;
            $order->status = Order::STATUS_PROCESSING;
            $order->save();

            // Dispatch invoice generation and email
            GenerateInvoiceJob::dispatch($order);
            SendOrderEmailJob::dispatch($order);

            return $order;
        });
    }

    public function cancelOrder(Order $order): bool
    {
        return DB::transaction(function () use ($order) {
            if ($order->status === Order::STATUS_CANCELLED) {
                return true;
            }

            // restore inventory
            foreach ($order->items as $item) {
                $this->productRepo->model->where('id', $item->product_id)->increment('stock', $item->quantity);
            }

            $order->status = Order::STATUS_CANCELLED;
            return (bool) $order->save();
        });
    }
}
