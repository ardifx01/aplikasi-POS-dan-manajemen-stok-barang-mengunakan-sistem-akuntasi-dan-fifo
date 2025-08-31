<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Coa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\JurnalUmumController;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with('produk')->get();
        return view('penjualan.view', compact('penjualan'));
    }

    public function create()
    {
        $produkList = Produk::where('status', 'Ada')->get();
        $penjualan = new Penjualan();
        $kode_penjualan = $penjualan->generateKodePenjualan();

        return view('penjualan.create', compact('produkList', 'kode_penjualan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_penjualan' => 'required|max:10|unique:penjualan,kode_penjualan',
            'kode_produk'    => 'required|exists:produk,kode_produk',
            'harga'          => 'required|numeric|min:0',
            'jumlah'         => 'required|integer|min:1',
            'tanggal'        => 'required|date',
        ]);

        $produk = Produk::where('kode_produk', $request->kode_produk)->firstOrFail();

        if ($produk->stok < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi. Sisa stok: ' . $produk->stok])->withInput();
        }

        $jumlah        = $request->jumlah;
        $harga_jual    = $request->harga;
        $harga_beli    = $produk->harga_beli ?? 0;
        $total_jual    = $harga_jual * $jumlah;
        $total_hpp     = $harga_beli * $jumlah;

        try {
            DB::transaction(function () use ($request, $produk, $jumlah, $harga_jual, $total_jual, $harga_beli, $total_hpp) {
                // Ambil akun COA
                $coa               = Coa::all();
                $akun_kas          = $coa->firstWhere('nama_coa', 'Kas');
                $akun_pendapatan   = $coa->firstWhere('nama_coa', 'Penjualan');
                $akun_hpp          = $coa->firstWhere('nama_coa', 'Harga Pokok Penjualan');
                $akun_persediaan   = $coa->firstWhere('nama_coa', 'Persediaan Barang Dagang');

                // Validasi akun wajib ada
                if (!$akun_kas || !$akun_pendapatan || !$akun_hpp || !$akun_persediaan) {
                    throw new \Exception("Data akun COA belum lengkap. Pastikan akun 'Kas', 'Pendapatan', 'Harga Pokok Penjualan', dan 'Persediaan Barang Dagang' sudah dibuat.");
                }

                // Simpan data penjualan
                Penjualan::create([
                    'kode_penjualan' => $request->kode_penjualan,
                    'kode_produk'    => $produk->kode_produk,
                    'harga'          => $harga_jual,
                    'stok'           => $produk->stok,
                    'jumlah'         => $jumlah,
                    'total'          => $total_jual,
                    'tanggal'        => $request->tanggal,
                ]);

                // Update stok produk
                $produk->stok -= $jumlah;
                $produk->save();

                // Simpan Jurnal
                $tanggal = $request->tanggal;

                JurnalUmumController::simpanJurnal([
                    'tanggal'   => $tanggal,
                    'kode_coa'  => $akun_kas->kode_coa,
                    'deskripsi' => "Kas " . $produk->nama_produk,
                    'debit'     => $total_jual,
                    'kredit'    => 0,
                ]);

                JurnalUmumController::simpanJurnal([
                    'tanggal'   => $tanggal,
                    'kode_coa'  => $akun_pendapatan->kode_coa,
                    'deskripsi' => "Penjualan " . $produk->nama_produk,
                    'debit'     => 0,
                    'kredit'    => $total_jual,
                ]);

                JurnalUmumController::simpanJurnal([
                    'tanggal'   => $tanggal,
                    'kode_coa'  => $akun_hpp->kode_coa,
                    'deskripsi' => "Harga Pokok Penjualan " . $produk->nama_produk,
                    'debit'     => $total_hpp,
                    'kredit'    => 0,
                ]);

                JurnalUmumController::simpanJurnal([
                    'tanggal'   => $tanggal,
                    'kode_coa'  => $akun_persediaan->kode_coa,
                    'deskripsi' => "Persediaan Barang Dagang" . $produk->nama_produk,
                    'debit'     => 0,
                    'kredit'    => $total_hpp,
                ]);
            });

            return redirect()->route('penjualan.index')->with('success', 'Penjualan dan jurnal berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $penjualan = Penjualan::with('produk')->findOrFail($id);
        return view('penjualan.detail', compact('penjualan'));
    }
}
