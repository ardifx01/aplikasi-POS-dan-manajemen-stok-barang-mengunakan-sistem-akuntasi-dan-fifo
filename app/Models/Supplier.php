<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;

    protected $table = 'supplier';

    // Daftar kolom yang bisa diisi
    protected $fillable = ['kode_supplier', 'nama_supplier', 'alamat', 'no_telpon', 'email',  'status'];

    /**
     * Mengambil kode supplier otomatis berdasarkan kode terakhir di database.
     */
    public function getKodesupplier()
    {
        // Ambil kode supplier terakhir dan tambahkan 1 pada digit terakhir
        $sql = "SELECT IFNULL(MAX(kode_supplier), 'SR-000') as kode_supplier FROM supplier";
        $kodesupplier = DB::select($sql);

        // Mengambil kode terakhir
        $kd = $kodesupplier[0]->kode_supplier;
        
        // Ambil tiga digit akhir dari kode terakhir, tambahkan 1
        $noawal = substr($kd, -3);
        $noakhir = str_pad($noawal + 1, 3, "0", STR_PAD_LEFT); // Format menjadi SR-001, SR-002, dst.

        // Mengembalikan kode baru
        return 'SR-' . $noakhir;
    }

}
