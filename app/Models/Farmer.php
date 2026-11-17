<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Farmer extends Model
{
    protected $fillable = [
        'user_id',
        'nama_usaha',
        'no_telepon',
        'alamat',
        'deskripsi',
        'status_verifikasi',
        'alasan_penolakan',
    ];

    // Relasi dengan akun pengguna
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan produk milik petani
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Relasi dengan pesanan yang diterima petani
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Memeriksa apakah petani sudah diverifikasi
    public function isVerified(): bool
    {
        return $this->status_verifikasi === 'diterima';
    }
}

