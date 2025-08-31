<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();

        if ($produk->isEmpty()) {
            session()->flash('warning', 'Data produk belum tersedia.');
        }

        return view('produk.view', ['produk' => $produk]);
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }
}
