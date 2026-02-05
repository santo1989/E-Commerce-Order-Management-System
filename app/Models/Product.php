<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factory\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'stock',
        'vendor_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];
}
