<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    protected $fillable = [
        'order_id',
        'nama_kurir',
        'nomor_resi',
        'alamat_pengiriman',
        'status_pengiriman',
        'tanggal_kirim',
        'tanggal_diterima',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kirim' => 'datetime',
            'tanggal_diterima' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
