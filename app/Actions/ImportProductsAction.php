<?php

namespace App\Actions;

use App\Jobs\ImportProductsJob;
use Illuminate\Support\Facades\Storage;

class ImportProductsAction
{
    public function handle(string $path)
    {
        // Push a job to process CSV import asynchronously
        ImportProductsJob::dispatch($path);
    }
}
