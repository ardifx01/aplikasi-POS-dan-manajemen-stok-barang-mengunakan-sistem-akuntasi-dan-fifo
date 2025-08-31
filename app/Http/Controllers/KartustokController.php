<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Produk, Pembelian, Penjualan, ReturnBarang};

class KartuStokController extends Controller
{
    public function index(Request $request)
    {
        $produk = Produk::all();

        $kartu_stock = [];
        $total_item_beli = 0;
        $total_beli = 0;
        $total_item_jual = 0;
        $total_jual = 0;
        $total_item_return = 0;
        $total_return = 0;
        $total_item_stok = 0;
        $total_stok = 0;

        $kode_produk = $request->produk;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if ($kode_produk && $bulan && $tahun) {
            $data_produk = Produk::where('kode_produk', $kode_produk)->first();

            if ($data_produk) {
                $tanggal_akhir_bulan_lalu = date('Y-m-d', strtotime("last day of previous month", strtotime("$tahun-$bulan-01")));

                // Hitung stok awal
                $total_beli = Pembelian::where('kode_produk', $kode_produk)
                    ->where('tanggal', '<=', $tanggal_akhir_bulan_lalu)
                    ->sum('total_barang');

                $total_jual = Penjualan::where('kode_produk', $kode_produk)
                    ->where('tanggal', '<=', $tanggal_akhir_bulan_lalu)
                    ->sum('jumlah');

                $total_return = ReturnBarang::where('kode_produk', $kode_produk)
                    ->where('tanggal_returnbarang', '<=', $tanggal_akhir_bulan_lalu)
                    ->sum('jumlah');

                $stok_awal = $total_beli - $total_jual - $total_return;

                $harga_awal = Pembelian::where('kode_produk', $kode_produk)
                    ->where('tanggal', '<=', $tanggal_akhir_bulan_lalu)
                    ->orderBy('tanggal', 'desc')
                    ->value('harga') ?? $data_produk->harga;

                $stock_layer = [];

                if ($stok_awal > 0) {
                    $stock_layer[] = [
                        'jumlah' => $stok_awal,
                        'harga' => $harga_awal
                    ];

                    $kartu_stock[] = [
                        'tanggal' => date('Y-m-d', strtotime("first day of $tahun-$bulan")),
                        'pembelian' => null,
                        'return' => null,
                        'penjualan' => null,
                        'stock' => $stock_layer
                    ];
                }

                // Ambil transaksi bulan ini
                $pembelian = Pembelian::where('kode_produk', $kode_produk)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->orderBy('tanggal')
                    ->get();

                $penjualan = Penjualan::where('kode_produk', $kode_produk)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->orderBy('tanggal')
                    ->get();

                $return_barang = ReturnBarang::where('kode_produk', $kode_produk)
                    ->whereMonth('tanggal_returnbarang', $bulan)
                    ->whereYear('tanggal_returnbarang', $tahun)
                    ->orderBy('tanggal_returnbarang')
                    ->get();

                $data_transaksi = [];

                foreach ($pembelian as $p) {
                    $data_transaksi[] = [
                        'tanggal' => $p->tanggal,
                        'tipe' => 'pembelian',
                        'jumlah' => $p->total_barang,
                        'harga' => $p->harga
                    ];
                }

                foreach ($penjualan as $j) {
                    $data_transaksi[] = [
                        'tanggal' => $j->tanggal,
                        'tipe' => 'penjualan',
                        'jumlah' => $j->jumlah,
                        'harga' => $j->harga
                    ];
                }

                foreach ($return_barang as $r) {
                    $data_transaksi[] = [
                        'tanggal' => $r->tanggal_returnbarang,
                        'tipe' => 'return',
                        'jumlah' => $r->jumlah,
                        'harga' => $r->harga
                    ];
                }

                usort($data_transaksi, fn($a, $b) => strtotime($a['tanggal']) - strtotime($b['tanggal']));

                foreach ($data_transaksi as $transaksi) {
                    $tanggal = $transaksi['tanggal'];

                    if ($transaksi['tipe'] === 'pembelian') {
                        $jumlah = $transaksi['jumlah'];
                        $harga = $transaksi['harga'];
                        $total = $jumlah * $harga;

                        $stock_layer[] = [
                            'jumlah' => $jumlah,
                            'harga' => $harga
                        ];

                        $total_item_beli += $jumlah;
                        $total_beli += $total;

                        $kartu_stock[] = [
                            'tanggal' => $tanggal,
                            'pembelian' => [
                                'jumlah' => $jumlah,
                                'harga' => $harga,
                                'total' => $total
                            ],
                            'return' => null,
                            'penjualan' => null,
                            'stock' => $stock_layer
                        ];
                    }

                    elseif ($transaksi['tipe'] === 'penjualan') {
                        $jumlah_jual = $transaksi['jumlah'];
                        $penjualan_detail = [];

                        while ($jumlah_jual > 0 && count($stock_layer) > 0) {
                            $layer = array_shift($stock_layer);

                            if ($layer['jumlah'] <= $jumlah_jual) {
                                $penjualan_detail[] = [
                                    'jumlah' => $layer['jumlah'],
                                    'harga' => $layer['harga'],
                                    'total' => $layer['jumlah'] * $layer['harga']
                                ];
                                $jumlah_jual -= $layer['jumlah'];
                            } else {
                                $penjualan_detail[] = [
                                    'jumlah' => $jumlah_jual,
                                    'harga' => $layer['harga'],
                                    'total' => $jumlah_jual * $layer['harga']
                                ];
                                $layer['jumlah'] -= $jumlah_jual;
                                array_unshift($stock_layer, $layer);
                                $jumlah_jual = 0;
                            }
                        }

                        foreach ($penjualan_detail as $pd) {
                            $total_item_jual += $pd['jumlah'];
                            $total_jual += $pd['total'];
                        }

                        $kartu_stock[] = [
                            'tanggal' => $tanggal,
                            'pembelian' => null,
                            'return' => null,
                            'penjualan' => $penjualan_detail,
                            'stock' => $stock_layer
                        ];
                    }

                    elseif ($transaksi['tipe'] === 'return') {
                        $jumlah_return = $transaksi['jumlah'];
                        $return_detail = [];

                        while ($jumlah_return > 0 && count($stock_layer) > 0) {
                            $layer = array_shift($stock_layer);

                            if ($layer['jumlah'] <= $jumlah_return) {
                                $return_detail[] = [
                                    'jumlah' => $layer['jumlah'],
                                    'harga' => $layer['harga'],
                                    'total' => $layer['jumlah'] * $layer['harga']
                                ];
                                $jumlah_return -= $layer['jumlah'];
                            } else {
                                $return_detail[] = [
                                    'jumlah' => $jumlah_return,
                                    'harga' => $layer['harga'],
                                    'total' => $jumlah_return * $layer['harga']
                                ];
                                $layer['jumlah'] -= $jumlah_return;
                                array_unshift($stock_layer, $layer);
                                $jumlah_return = 0;
                            }
                        }

                        foreach ($return_detail as $rd) {
                            $total_item_return += $rd['jumlah'];
                            $total_return += $rd['total'];
                        }

                        $kartu_stock[] = [
                            'tanggal' => $tanggal,
                            'pembelian' => null,
                            'return' => $return_detail,
                            'penjualan' => null,
                            'stock' => $stock_layer
                        ];
                    }
                }

                foreach ($stock_layer as $s) {
                    $total_item_stok += $s['jumlah'];
                    $total_stok += $s['jumlah'] * $s['harga'];
                }
            }
        }

        return view('produk.kartustok', compact(
            'produk',
            'kartu_stock',
            'total_item_beli',
            'total_beli',
            'total_item_jual',
            'total_jual',
            'total_item_return',
            'total_return',
            'total_item_stok',
            'total_stok'
        ));
    }
}
