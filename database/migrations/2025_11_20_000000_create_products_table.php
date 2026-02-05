<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku')->unique()->index();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->index();
            $table->integer('stock')->default(0)->index();
            $table->unsignedBigInteger('vendor_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
