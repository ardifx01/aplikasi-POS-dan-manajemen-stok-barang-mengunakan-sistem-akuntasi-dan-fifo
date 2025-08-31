<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\ReturnBarang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total stok hanya berdasarkan kolom 'stok'
        $totalStok         = Produk::sum('stok');
        $totalBarangMasuk  = Pembelian::sum('total_barang');
        $totalBarangKeluar = Penjualan::sum('jumlah');
        $totalUangPenjualan = Penjualan::sum('total');
        $totalProduk       = Produk::count();
        $totalRetur        = ReturnBarang::sum('jumlah');

        // Tambahan dua statistik untuk melengkapi 8 box
        $totalKategori     = Produk::distinct('kategori')->count('kategori');
        $totalTransaksi    = Pembelian::count() + Penjualan::count() + ReturnBarang::count();

        // Produk terlaris
        $barangSeringDibeli = Penjualan::select('kode_produk', DB::raw('SUM(jumlah) as total_dibeli'))
            ->groupBy('kode_produk')
            ->orderByDesc('total_dibeli')
            ->take(5)
            ->get();

        $kodeProduks = $barangSeringDibeli->pluck('kode_produk');
        $produkData  = Produk::whereIn('kode_produk', $kodeProduks)->pluck('nama_produk', 'kode_produk');

        foreach ($barangSeringDibeli as $item) {
            $item->nama_produk = $produkData[$item->kode_produk] ?? '-';
        }

        // Data grafik penjualan bulanan (12 bulan terakhir)
        $labelsBulanan = [];
        $dataBulanan   = [];

        for ($i = 0; $i < 12; $i++) {
            $bulan = Carbon::now()->subMonths(11 - $i);
            $labelsBulanan[] = $bulan->format('M Y');

            $total = Penjualan::whereYear('tanggal', $bulan->year)
                              ->whereMonth('tanggal', $bulan->month)
                              ->sum('total');

            $dataBulanan[] = $total;
        }

        return view('dashboardbootstrap', compact(
            'totalStok',
            'totalBarangMasuk',
            'totalBarangKeluar',
            'totalUangPenjualan',
            'totalProduk',
            'totalRetur',
            'barangSeringDibeli',
            'labelsBulanan',
            'dataBulanan',
            'totalKategori',
            'totalTransaksi'
        ));
    }

    // AJAX: Notifikasi Dropdown di Navbar
    public function getNotifikasi()
    {
        $notifikasi = [];

        // Notifikasi Pembelian
        $pembelian = Pembelian::latest()->first();
        if ($pembelian) {
            $notifikasi[] = [
                'icon' => 'fas fa-cart-plus',
                'text' => 'Barang masuk dari pembelian',
                'time' => $pembelian->created_at->diffForHumans()
            ];
        }

        // Notifikasi Penjualan
        $penjualan = Penjualan::latest()->first();
        if ($penjualan) {
            $notifikasi[] = [
                'icon' => 'fas fa-shopping-bag',
                'text' => 'Transaksi penjualan baru',
                'time' => $penjualan->created_at->diffForHumans()
            ];
        }

        // Notifikasi Return Barang
        $retur = ReturnBarang::latest()->first();
        if ($retur) {
            $notifikasi[] = [
                'icon' => 'fas fa-undo',
                'text' => 'Return barang diterima',
                'time' => $retur->created_at->diffForHumans()
            ];
        }

        return response()->json($notifikasi);
    }
}
