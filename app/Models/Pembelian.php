<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';

    protected $fillable = [
        'no_faktur',
        'kode_supplier',
        'kode_produk',
        'total_barang',
        'harga',
        'total_harga',
        'tanggal',
    ];

    /**
     * Relasi ke model Produk (berdasarkan kode_produk).
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk');
    }

    /**
     * Relasi ke model Supplier (berdasarkan kode_supplier).
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kode_supplier', 'kode_supplier');
    }

    /**
     * Generate nomor faktur pembelian otomatis (format PB-XXX).
     */
    public function generateKodePembelian()
    {
        $last = self::orderByDesc('id')->first();
        $num = $last ? ((int) substr($last->no_faktur, 3)) + 1 : 1;
        return 'PB-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }
}
