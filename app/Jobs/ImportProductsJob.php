<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;
use App\Repositories\ProductRepository;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function handle(ProductRepository $repository)
    {
        $csv = Reader::createFromPath($this->path, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv->getRecords() as $record) {
            // map columns and create product using repository
            $data = [
                'sku' => $record['sku'] ?? null,
                'name' => $record['name'] ?? null,
                'description' => $record['description'] ?? null,
                'price' => $record['price'] ?? 0,
                'stock' => $record['stock'] ?? 0,
            ];

            $repository->create($data);
        }
    }
}
