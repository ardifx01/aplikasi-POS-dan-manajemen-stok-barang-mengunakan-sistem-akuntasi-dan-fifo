<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
           Schema::create('jurnalumum', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('kode_coa', 10);
            $table->string('deskripsi');
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('kredit', 15, 2)->default(0);
            $table->timestamps(); // untuk created_at dan updated_at
        });

    }

    /**
     * Batalkan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurnalumum');
    }
};

