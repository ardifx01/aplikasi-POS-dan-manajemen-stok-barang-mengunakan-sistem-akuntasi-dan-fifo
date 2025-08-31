<?php

namespace App\Http\Controllers;

use App\Models\ReturnBarang;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Coa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\JurnalUmumController;

class ReturnBarangController extends Controller
{
    public function index()
    {
        $returnbarang = ReturnBarang::with(['produk', 'supplier'])
            ->orderByDesc('tanggal_returnbarang')
            ->paginate(10);

        return view('returnbarang.view', compact('returnbarang'));
    }

    public function create()
    {
        $produks = Produk::all();
        $suppliers = Supplier::all();

        return view('returnbarang.create', compact('produks', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk'           => 'required|exists:produk,kode_produk',
            'kode_supplier'         => 'required|exists:supplier,kode_supplier',
            'jumlah'                => 'required|integer|min:1',
            'harga'                 => 'required|numeric|min:0',
            'alasan'                => 'required|string|max:255',
            'tanggal_returnbarang' => 'required|date',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $produk = Produk::where('kode_produk', $request->kode_produk)->firstOrFail();
                $jumlah = $request->jumlah;
                $harga  = $request->harga;
                $total  = $jumlah * $harga;

                // Validasi stok
                if ($produk->stok < $jumlah) {
                    throw new \Exception('Jumlah return melebihi stok produk yang tersedia.');
                }

                // Ambil akun COA
                $coa        = Coa::all();
                $akun_kas   = $coa->firstWhere('nama_coa', 'Kas');
                $akun_pers  = $coa->firstWhere('nama_coa', 'Persediaan Barang Dagang');

                if (!$akun_kas || !$akun_pers) {
                    throw new \Exception("Data akun COA belum lengkap. Pastikan akun 'Kas' dan 'Persediaan Barang Dagang' sudah dibuat di menu COA.");
                }

                // Simpan data retur
                ReturnBarang::create([
                    'kode_produk'           => $request->kode_produk,
                    'kode_supplier'         => $request->kode_supplier,
                    'jumlah'                => $jumlah,
                    'harga'                 => $harga,
                    'total_harga'           => $total,
                    'alasan'                => $request->alasan,
                    'tanggal_returnbarang'  => $request->tanggal_returnbarang,
                ]);

                // Kurangi stok
                $produk->stok -= $jumlah;
                $produk->save();

                // Simpan jurnal
                JurnalUmumController::simpanJurnal([
                    'tanggal'   => $request->tanggal_returnbarang,
                    'kode_coa'  => $akun_kas->kode_coa,
                    'deskripsi' => "Kas" . $produk->nama_produk,
                    'debit'     => $total,
                    'kredit'    => 0,
                ]);

                JurnalUmumController::simpanJurnal([
                    'tanggal'   => $request->tanggal_returnbarang,
                    'kode_coa'  => $akun_pers->kode_coa,
                    'deskripsi' => "Persediaan Barang Dagang " . $produk->nama_produk,
                    'debit'     => 0,
                    'kredit'    => $total,
                ]);
            });

            return redirect()->route('returnbarang.index')->with('success', 'Data retur barang berhasil disimpan dan jurnal dicatat.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }
}
