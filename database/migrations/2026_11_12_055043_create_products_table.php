
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Petani yang memiliki produk
            $table->foreignId('farmer_id')
                ->constrained('farmers')
                ->cascadeOnDelete();

            // Kategori produk
            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            // Informasi produk
            $table->string('nama_produk');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2);
            $table->unsignedInteger('stok')->default(0);
            $table->string('satuan', 30);
            $table->string('gambar')->nullable();

            // Status produk
            $table->enum('status', [
                'aktif',
                'nonaktif',
                'habis'
            ])->default('aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
