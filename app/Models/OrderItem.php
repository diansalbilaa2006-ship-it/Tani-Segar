<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'nama_produk',
        'harga',
        'jumlah',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'jumlah' => 'integer',
            'subtotal' => 'decimal:2',
        ];
    }

    // Detail pesanan terhubung dengan pesanan
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Produk yang dibeli
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
