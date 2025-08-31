<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('returnbarang', function (Blueprint $table) {
            $table->id(); // ID otomatis
            $table->string('kode_returnbarang')->unique(); // Kode return unik
            $table->string('kode_produk'); // Kode produk (foreign key)
            $table->string('kode_supplier'); // Kode supplier (foreign key)
            $table->integer('jumlah'); // Jumlah barang yang dikembalikan
            $table->decimal('harga', 12, 2)->default(0); // Harga barang saat return

            $table->decimal('total_harga', 12, 2)->default(0); // ✅ Tambahkan kolom ini

            $table->text('alasan'); // Alasan pengembalian
            $table->date('tanggal_returnbarang'); // Tanggal returnbarang
            $table->timestamps(); // created_at & updated_at

            // Foreign key constraints
            $table->foreign('kode_produk')->references('kode_produk')->on('produk')->onDelete('cascade');
            $table->foreign('kode_supplier')->references('kode_supplier')->on('supplier')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('returnbarang');
    }
};
