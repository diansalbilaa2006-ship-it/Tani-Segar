
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Pesanan yang dibayar
            $table->foreignId('order_id')
                ->unique()
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->enum('metode_pembayaran', [
                'transfer',
                'cod'
            ]);

            $table->decimal('jumlah_bayar', 12, 2);

            // Lokasi file bukti transfer
            $table->string('bukti_pembayaran')->nullable();

            // Status pembayaran
            $table->enum('status_pembayaran', [
                'menunggu',
                'menunggu_verifikasi',
                'berhasil',
                'ditolak'
            ])->default('menunggu');

            $table->timestamp('tanggal_bayar')->nullable();
            $table->text('catatan_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
