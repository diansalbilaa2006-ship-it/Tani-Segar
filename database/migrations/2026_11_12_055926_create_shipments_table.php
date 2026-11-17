
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();

            // Pesanan yang dikirim
            $table->foreignId('order_id')
                ->unique()
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->string('nama_kurir')->nullable();
            $table->string('nomor_resi')->nullable();
            $table->text('alamat_pengiriman');

            $table->enum('status_pengiriman', [
                'menunggu',
                'diproses',
                'dikirim',
                'dalam_perjalanan',
                'diterima'
            ])->default('menunggu');

            $table->timestamp('tanggal_kirim')->nullable();
            $table->timestamp('tanggal_diterima')->nullable();

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
