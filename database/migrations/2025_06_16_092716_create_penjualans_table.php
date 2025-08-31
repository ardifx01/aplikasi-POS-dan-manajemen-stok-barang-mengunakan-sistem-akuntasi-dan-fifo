<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id(); // Primary key

            $table->string('kode_penjualan', 10); // Kode invoice/transaksi
            $table->string('kode_produk', 50);    // Kode produk (relasi ke produk)
            $table->decimal('harga', 15, 2);      // Harga jual per item
            $table->integer('stok')->nullable();  // Opsional: stok saat transaksi (tidak wajib)
            $table->integer('jumlah');            // Jumlah item terjual
            $table->decimal('total', 15, 2);      // Total penjualan = harga * jumlah
            $table->date('tanggal');              // Tanggal transaksi

            $table->unsignedBigInteger('user_id')->nullable(); // (opsional) User kasir
            $table->text('catatan')->nullable();               // Catatan transaksi (opsional)

            $table->timestamps(); // created_at dan updated_at

            // Foreign key ke produk (kode_produk harus sudah unique di tabel produk)
            $table->foreign('kode_produk')
                  ->references('kode_produk')
                  ->on('produk')
                  ->onDelete('restrict');

            // Foreign key ke users (jika ada)
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            // Optional engine & charset
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
