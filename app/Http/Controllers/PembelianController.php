<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\JurnalUmumController;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelian = Pembelian::with(['produk', 'supplier'])->get();
        return view('pembelian.view', compact('pembelian'));
    }

    public function create()
    {
        $supplier = Supplier::all();
        $noFaktur = (new Pembelian)->generateKodePembelian();

        return view('pembelian.create', compact('supplier', 'noFaktur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_supplier'      => 'required',
            'nama_produk'        => 'required|max:100',
            'kategori'           => 'required|max:50',
            'satuan'             => 'required|max:20',
            'ukuran'             => 'required|max:20',
            'jumlah'             => 'required|integer|min:1',
            'harga'              => 'required|numeric|min:1',
            'tanggal_pembelian'  => 'required|date',
            'gambar'             => 'nullable|image|max:5000'
        ]);

        DB::transaction(function () use ($request) {
            $jumlah     = $request->jumlah;
            $harga      = (float) str_replace(['Rp.', '.', ','], '', $request->harga);
            $totalHarga = $jumlah * $harga;
            $noFaktur   = (new Pembelian())->generateKodePembelian();
            $coa        = Coa::all();

            $persediaan = $coa->firstWhere('nama_coa', 'Persediaan Barang Dagang');
            $kas        = $coa->firstWhere('nama_coa', 'Kas');

            // Validasi jika akun COA belum lengkap
            if (!$persediaan || !$kas) {
                abort(500, "Data akun COA belum lengkap. Pastikan akun 'Persediaan Barang Dagang' dan 'Kas' sudah dibuat.");
            }

            // Cek apakah produk sudah ada berdasarkan nama + kategori + ukuran
            $produk = Produk::where('nama_produk', $request->nama_produk)
                ->where('kategori', $request->kategori)
                ->where('ukuran', $request->ukuran)
                ->first();

            if ($produk) {
                $produk->stok += $jumlah;
                $produk->harga = $harga;
                $produk->status = 'ada';

                if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
                    $file = $request->file('gambar');
                    $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                    $file->move(public_path('storage/produk'), $filename);
                    $produk->gambar = $filename;
                }

                $produk->save();
            } else {
                $produk = new Produk();
                $produk->kode_produk = $produk->generateKodeProduk();
                $produk->nama_produk = $request->nama_produk;
                $produk->kategori    = $request->kategori;
                $produk->satuan      = $request->satuan;
                $produk->ukuran      = $request->ukuran;
                $produk->harga       = $harga;
                $produk->harga_beli  = $harga;
                $produk->stok        = $jumlah;
                $produk->status      = 'ada';

                if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
                    $file = $request->file('gambar');
                    $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                    $file->move(public_path('storage/produk'), $filename);
                    $produk->gambar = $filename;
                }

                $produk->save();
            }

            // Simpan pembelian
            Pembelian::create([
                'no_faktur'     => $noFaktur,
                'kode_supplier' => $request->kode_supplier,
                'kode_produk'   => $produk->kode_produk,
                'total_barang'  => $jumlah,
                'harga'         => $harga,
                'total_harga'   => $totalHarga,
                'tanggal'       => $request->tanggal_pembelian,
            ]);

            // Jurnal: Persediaan (debit)
            JurnalUmumController::simpanJurnal([
                'tanggal'   => $request->tanggal_pembelian,
                'kode_coa'  => $persediaan->kode_coa,
                'deskripsi' => $persediaan->nama_coa . ' ' . $produk->nama_produk,
                'debit'     => $totalHarga,
                'kredit'    => 0,
            ]);

            // Jurnal: Kas (kredit)
            JurnalUmumController::simpanJurnal([
                'tanggal'   => $request->tanggal_pembelian,
                'kode_coa'  => $kas->kode_coa,
                'deskripsi' => $kas->nama_coa . ' ' . $produk->nama_produk,
                'debit'     => 0,
                'kredit'    => $totalHarga,
            ]);
        });

        return redirect()->route('pembelian.index')->with('success', 'Pembelian dan jurnal berhasil disimpan!');
    }
}
