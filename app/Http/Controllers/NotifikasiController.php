<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\ReturnBarang;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class NotifikasiController extends Controller
{
    public function index()
    {
        // Ambil data pembelian terbaru
        $pembelian = Pembelian::with('produk', 'supplier')
            ->orderByDesc('tanggal')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => 'pembelian_' . $item->id,
                    'icon' => 'fas fa-truck',
                    'text' => "Barang masuk: {$item->produk->nama_produk} dari {$item->supplier->nama_supplier}",
                    'time' => Carbon::parse($item->tanggal)->toDateTimeString(), // waktu asli
                ];
            });

        // Ambil data penjualan terbaru
        $penjualan = Penjualan::with('produk')
            ->orderByDesc('tanggal')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => 'penjualan_' . $item->id,
                    'icon' => 'fas fa-shopping-cart',
                    'text' => "Penjualan: {$item->produk->nama_produk} sebanyak {$item->jumlah}",
                    'time' => Carbon::parse($item->tanggal)->toDateTimeString(),
                ];
            });

        // Ambil data retur barang terbaru
        $retur = ReturnBarang::with('produk', 'supplier')
            ->orderByDesc('tanggal_returnbarang')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => 'retur_' . $item->id,
                    'icon' => 'fas fa-undo',
                    'text' => "Return: {$item->produk->nama_produk} ke {$item->supplier->nama_supplier}",
                    'time' => Carbon::parse($item->tanggal_returnbarang)->toDateTimeString(),
                ];
            });

        // Gabungkan dan sort berdasarkan waktu terbaru
        $all = collect()
            ->merge($pembelian)
            ->merge($penjualan)
            ->merge($retur)
            ->sortByDesc('time')
            ->take(15)
            ->values();

        return response()->json($all);
    }
}
