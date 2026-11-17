<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'jumlah',
        'harga',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
            'harga' => 'decimal:2',
        ];
    }

    // Item terhubung dengan keranjang
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    // Item terhubung dengan produk
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Menghitung subtotal item
    public function getSubtotalAttribute(): float
    {
        return (float) $this->harga * $this->jumlah;
    }
}
