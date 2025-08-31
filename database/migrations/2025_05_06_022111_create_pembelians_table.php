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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis
            $table->string('no_faktur')->unique(); // Ganti dari 'kode_pembelian'
            $table->string('kode_supplier'); // Kode supplier (foreign key)
            $table->string('kode_produk'); // Kode produk (foreign key)
            $table->integer('total_barang'); // Ganti dari 'jumlah'
            $table->decimal('harga', 10, 2); // Harga per unit
            $table->decimal('total_harga', 10, 2); // Total harga (jumlah * harga)
            $table->date('tanggal'); // Ganti dari 'tanggal_pembelian'
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('kode_supplier')->references('kode_supplier')->on('supplier')->onDelete('cascade');
            $table->foreign('kode_produk')->references('kode_produk')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
