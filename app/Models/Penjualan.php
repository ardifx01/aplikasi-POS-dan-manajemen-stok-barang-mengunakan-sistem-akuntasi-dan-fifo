<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'kode_penjualan',
        'kode_produk',
        'harga',
        'stok',
        'jumlah',
        'total',
        'tanggal',
        'user_id',
        'catatan',
    ];

    // Casting tipe data agar konsisten saat diakses
    protected $casts = [
        'harga'    => 'decimal:2',
        'total'    => 'decimal:2',
        'jumlah'   => 'integer',
        'stok'     => 'integer',
        'tanggal'  => 'date',
        'user_id'  => 'integer',
    ];

    /**
     * Relasi ke produk.
     * Setiap penjualan memiliki satu produk.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk');
    }

    /**
     * Generate kode penjualan otomatis dengan format PJ-001, PJ-002, ...
     */
    public function generateKodePenjualan()
    {
        $last = DB::table($this->table)
            ->select(DB::raw("MAX(kode_penjualan) AS kode"))
            ->first();

        $lastKode = $last->kode ?? 'PJ-000';

        $number = (int) substr($lastKode, -3);
        $newNumber = $number + 1;

        return 'PJ-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
