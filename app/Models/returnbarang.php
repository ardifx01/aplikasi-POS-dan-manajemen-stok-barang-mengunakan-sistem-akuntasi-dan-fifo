<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReturnBarang extends Model
{
    use HasFactory;

    protected $table = 'returnbarang';

    protected $fillable = [
        'kode_returnbarang',
        'kode_produk',
        'kode_supplier',
        'jumlah',
        'harga',
        'total_harga',
        'alasan',
        'tanggal_returnbarang',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate kode otomatis jika belum diisi
            if (empty($model->kode_returnbarang)) {
                $model->kode_returnbarang = $model->generateKodeReturnbarang();
            }

            // Hitung total_harga otomatis jika belum diisi
            if (empty($model->total_harga)) {
                $model->total_harga = $model->jumlah * $model->harga;
            }
        });

        static::updating(function ($model) {
            // Update total_harga juga jika harga/jumlah berubah
            $model->total_harga = $model->jumlah * $model->harga;
        });
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kode_supplier', 'kode_supplier');
    }

    public function generateKodeReturnbarang()
    {
        $lastCode = DB::table($this->table)
            ->select('kode_returnbarang')
            ->orderByDesc('id')
            ->value('kode_returnbarang');

        if (!$lastCode) {
            return 'RB-001';
        }

        $number = (int) substr($lastCode, 3);
        $newNumber = str_pad($number + 1, 3, '0', STR_PAD_LEFT);

        return 'RB-' . $newNumber;
    }
}
