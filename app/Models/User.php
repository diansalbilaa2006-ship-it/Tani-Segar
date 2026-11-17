<?php

namespace App\Models;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi profil petani
    public function farmer(): HasOne
    {
        return $this->hasOne(Farmer::class);
    }

    // Relasi keranjang pembeli
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    // Relasi pesanan pembeli
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Relasi ulasan pembeli
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Memeriksa jenis akun
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetani(): bool
    {
        return $this->role === 'petani';
    }

    public function isPembeli(): bool
    {
        return $this->role === 'pembeli';
    }

    public function isCalonPetani(): bool
    {
        return $this->role === 'calon_petani';
    }
}
