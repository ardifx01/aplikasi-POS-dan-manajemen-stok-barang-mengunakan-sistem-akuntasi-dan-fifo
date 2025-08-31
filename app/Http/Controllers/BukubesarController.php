<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnalumum;

class BukuBesarController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter bulan, tahun, dan keterangan (kode akun atau deskripsi)
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));
        $keterangan = $request->keterangan;

        // Hitung Saldo Awal: semua transaksi sebelum bulan dan tahun yang dipilih
        $saldo_awal = Jurnalumum::query()
            ->where(function ($query) use ($tahun, $bulan) {
                $query->whereYear('tanggal', '<', $tahun)
                      ->orWhere(function ($q) use ($tahun, $bulan) {
                          $q->whereYear('tanggal', $tahun)
                            ->whereMonth('tanggal', '<', $bulan);
                      });
            })
            ->when($keterangan, function ($query) use ($keterangan) {
                $query->where(function ($q) use ($keterangan) {
                    $q->where('kode_coa', 'like', "%{$keterangan}%")
                      ->orWhere('deskripsi', 'like', "%{$keterangan}%");
                });
            })
            ->get()
            ->reduce(function ($carry, $item) {
                return $carry + ($item->debit - $item->kredit);
            }, 0);

        // Ambil transaksi jurnal untuk bulan dan tahun yang dipilih
        $jurnalGabung = Jurnalumum::query()
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->when($keterangan, function ($query) use ($keterangan) {
                $query->where(function ($q) use ($keterangan) {
                    $q->where('kode_coa', 'like', "%{$keterangan}%")
                      ->orWhere('deskripsi', 'like', "%{$keterangan}%");
                });
            })
            ->orderBy('tanggal')
            ->orderBy('id') // tambahan jika ada transaksi tanggal sama
            ->get();

        // Hitung saldo berjalan
        $saldo = $saldo_awal;
        $transaksi = [];

        foreach ($jurnalGabung as $item) {
            $saldo += ($item->debit - $item->kredit);
            $transaksi[] = [
                'tanggal' => $item->tanggal,
                'deskripsi' => $item->deskripsi,
                'debit' => $item->debit,
                'kredit' => $item->kredit,
                'saldo' => $saldo,
            ];
        }

        // Kirim ke view
        return view('laporan.bukubesar', [
            'transaksi' => $transaksi,
            'saldo_awal' => $saldo_awal,
            'saldo_akhir' => $saldo,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'keterangan' => $keterangan,
            'jurnalGabung' => $jurnalGabung,
        ]);
    }
}
