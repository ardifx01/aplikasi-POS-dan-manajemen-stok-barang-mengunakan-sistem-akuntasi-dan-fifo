<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pembelian; // <-- tambahkan
use Carbon\Carbon;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->tahun ?? now()->year;
        $bulan = $request->bulan ?? now()->format('m');

        $penjualanData = Penjualan::with('produk')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->orderBy('tanggal')
            ->get();

        $laporan = [];

        foreach ($penjualanData as $pj) {
            $kodeProduk = $pj->kode_produk;

            // Cari harga beli terakhir produk tersebut
            $hpp = Pembelian::where('kode_produk', $kodeProduk)
                ->orderByDesc('tanggal')
                ->value('harga') ?? 0;

            $laporan[] = [
                'kode_penjualan' => $pj->kode_penjualan,
                'produk'         => $pj->produk,
                'harga'          => $pj->harga,
                'jumlah'         => $pj->jumlah,
                'total'          => $pj->harga * $pj->jumlah,
                'hpp'            => $hpp * $pj->jumlah,
                'tanggal'        => $pj->tanggal,
                'created_at'     => $pj->created_at,
            ];
        }

        return view('laporan.penjualanbulanan', [
            'laporan' => $laporan,
            'tahun'   => $tahun,
            'bulan'   => $bulan
        ]);
    }
}
