<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'rating',
        'komentar',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    // Ulasan dimiliki oleh satu pembeli
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Ulasan terhubung dengan satu produk
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Ulasan terhubung dengan satu pesanan
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
