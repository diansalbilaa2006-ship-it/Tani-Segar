<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'farmer_id',
        'category_id',
        'nama_produk',
        'slug',
        'deskripsi',
        'harga',
        'stok',
        'satuan',
        'gambar',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'stok' => 'integer',
        ];
    }

    // Produk dimiliki oleh satu petani
    public function farmer(): BelongsTo
    {
        return $this->belongsTo(Farmer::class);
    }

    // Produk memiliki satu kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Produk dapat masuk ke banyak keranjang
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // Produk dapat muncul dalam banyak detail pesanan
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Produk memiliki banyak ulasan
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
