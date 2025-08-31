<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk', 10)->unique();       // Contoh: PK-001
            $table->string('nama_produk', 100);                // Nama lengkap produk
            $table->string('kategori', 50);                    // Kategori produk
            $table->string('satuan', 20)->nullable();          // ✅ satuan produk, seperti pcs/lusin
            $table->string('ukuran', 20);                      // Ukuran produk
            $table->decimal('harga', 10, 2);                   // Harga jual
            $table->decimal('harga_beli', 10, 2)->nullable();  // ✅ Harga beli produk
            $table->integer('stok')->default(0);               // Stok saat ini
            $table->integer('stok_awal')->default(0);          // ✅ Stok awal ketika produk dibuat
            $table->string('gambar')->nullable();              // Path gambar
            $table->enum('status', ['ada', 'tidak ada'])->default('tidak ada'); // Status stok
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
