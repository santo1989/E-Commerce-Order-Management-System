<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class GenerateInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        // Render invoice view (stub) and store as PDF
        $pdf = Pdf::loadView('invoices.invoice', ['order' => $this->order]);
        $path = 'invoices/invoice-' . $this->order->id . '.pdf';
        Storage::put($path, $pdf->output());
    }
}
