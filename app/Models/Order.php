<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'farmer_id',
        'kode_pesanan',
        'alamat_pengiriman',
        'no_telepon',
        'catatan',
        'subtotal',
        'ongkir',
        'total_harga',
        'metode_pembayaran',
        'status_pesanan',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'ongkir' => 'decimal:2',
            'total_harga' => 'decimal:2',
        ];
    }

    // Pembeli yang melakukan pesanan
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Petani yang menerima pesanan
    public function farmer(): BelongsTo
    {
        return $this->belongsTo(Farmer::class);
    }

    // Daftar produk dalam pesanan
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Informasi pembayaran
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    // Informasi pengiriman
    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }
}
