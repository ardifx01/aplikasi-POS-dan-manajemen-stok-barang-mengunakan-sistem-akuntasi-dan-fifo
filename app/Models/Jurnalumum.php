<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JurnalUmum extends Model
{
    use HasFactory;

    protected $table = 'jurnalumum';

    protected $fillable = [
        'tanggal',
        'kode_coa',
        'deskripsi',
        'debit',
        'kredit',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'debit' => 'float',
        'kredit' => 'float',
    ];

    /**
     * Relasi ke COA berdasarkan kode_coa
     */
    public function coa()
    {
        return $this->belongsTo(Coa::class, 'kode_coa', 'kode_coa');
    }
}
