
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();

            // Hubungan dengan akun pengguna
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            // Informasi usaha tani
            $table->string('nama_usaha');
            $table->string('no_telepon', 20);
            $table->text('alamat');
            $table->text('deskripsi')->nullable();

            // Status verifikasi admin
            $table->enum('status_verifikasi', [
                'menunggu',
                'diterima',
                'ditolak'
            ])->default('menunggu');

            $table->text('alasan_penolakan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farmers');
    }
};
