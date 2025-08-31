<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'kategori',
        'satuan',
        'ukuran',
        'harga',
        'stok',
        'gambar',
        'status'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];

    /**
     * Generate kode produk otomatis (digunakan saat input manual).
     */
    public function getKodeProduk()
    {
        $sql = "SELECT IFNULL(MAX(kode_produk), 'PK-000') as kode_produk FROM produk";
        $kodeproduk = DB::select($sql);

        foreach ($kodeproduk as $kdprd) {
            $kd = $kdprd->kode_produk;
        }

        $noawal = substr($kd, -3);
        $noakhir = (int) $noawal + 1;
        return 'PK-' . str_pad($noakhir, 3, "0", STR_PAD_LEFT);
    }

    /**
     * Generate kode produk otomatis (digunakan saat pembelian).
     */
    public function generateKodeProduk()
    {
        $lastProduk = Produk::orderBy('kode_produk', 'desc')->first();
        if (!$lastProduk) {
            return 'PK-001';
        }

        $lastNumber = (int) substr($lastProduk->kode_produk, -3);
        $newNumber = $lastNumber + 1;

        return 'PK-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Relasi ke pembelian berdasarkan kode_produk.
     */
    public function pembelian()
    {
        return $this->hasMany(\App\Models\Pembelian::class, 'kode_produk', 'kode_produk');
    }

    /**
     * Relasi ke penjualan berdasarkan kode_produk.
     */
    public function penjualan()
    {
        return $this->hasMany(\App\Models\Penjualan::class, 'kode_produk', 'kode_produk');
    }

    /**
     * Relasi ke return barang berdasarkan kode_produk.
     */
    public function returnbarang()
    {
        return $this->hasMany(\App\Models\ReturnBarang::class, 'kode_produk', 'kode_produk');
    }
}
