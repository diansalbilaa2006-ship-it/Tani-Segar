<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Pembeli yang melakukan pemesanan
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Petani yang menerima pesanan
            $table->foreignId('farmer_id')
                ->constrained('farmers')
                ->restrictOnDelete();

            $table->string('kode_pesanan')->unique();

            // Informasi pengiriman
            $table->text('alamat_pengiriman');
            $table->string('no_telepon', 20);
            $table->text('catatan')->nullable();

            // Informasi pembayaran
            $table->decimal('subtotal', 12, 2);
            $table->decimal('ongkir', 12, 2)->default(0);
            $table->decimal('total_harga', 12, 2);

            $table->enum('metode_pembayaran', [
                'transfer',
                'cod'
            ])->nullable();

            // Status pesanan
            $table->enum('status_pesanan', [
                'menunggu_pembayaran',
                'diproses',
                'dikirim',
                'selesai',
                'dibatalkan'
            ])->default('menunggu_pembayaran');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
