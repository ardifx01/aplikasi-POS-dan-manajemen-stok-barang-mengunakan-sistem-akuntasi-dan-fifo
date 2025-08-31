<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Coa extends Model
{
    use HasFactory;
    
    protected $table = 'coa';

    // List kolom yang bisa diisi
    protected $fillable = ['tanggal', 'kode_coa', 'nama_coa', 'header', 'saldo'];

    /**
     * Generate kode COA otomatis.
     *
     * @return string
     */
    
}
