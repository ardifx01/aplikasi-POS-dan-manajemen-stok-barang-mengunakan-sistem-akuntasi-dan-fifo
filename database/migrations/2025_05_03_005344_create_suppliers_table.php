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
        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->string('kode_supplier', 6)->unique(); // Kode supplier, maksimal 6 karakter
            $table->string('nama_supplier', 100); // Nama supplier lebih panjang
            $table->string('alamat', 255); // Alamat, memberikan ruang lebih panjang untuk alamat
            $table->string('no_telpon', 15); // Nomor telepon, maksimum 15 karakter
            $table->string('email', 100)->unique(); // Email, panjang lebih besar untuk alamat email lengkap
            $table->timestamps(); // Menambahkan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier');
    }
};
