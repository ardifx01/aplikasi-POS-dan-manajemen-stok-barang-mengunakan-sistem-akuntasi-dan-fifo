<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JurnalUmum;
use App\Models\Coa;

class JurnalUmumController extends Controller
{
    private function getCOA($kode)
    {
        return Coa::where('kode_coa', $kode)->first();
    }

    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $jurnal = JurnalUmum::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        $totalDebit = $jurnal->sum('debit');
        $totalKredit = $jurnal->sum('kredit');

        return view('jurnalumum.view', compact('jurnal', 'totalDebit', 'totalKredit', 'bulan', 'tahun'));
    }

    public static function simpanJurnal($data)
    {
        $cekDuplikat = JurnalUmum::where('tanggal', $data['tanggal'])
            ->where('kode_coa', $data['kode_coa'])
            ->where('debit', $data['debit'])
            ->where('kredit', $data['kredit'])
            ->where('deskripsi', $data['deskripsi'])
            ->exists();

        if (!$cekDuplikat) {
            JurnalUmum::create($data);
        }
    }

    public static function hapusJurnal($data)
    {
        JurnalUmum::where('tanggal', $data['tanggal'])
            ->where('kode_coa', $data['kode_coa'])
            ->where('debit', $data['debit'])
            ->where('kredit', $data['kredit'])
            ->where('deskripsi', $data['deskripsi'])
            ->delete();
    }

    /**
     * ✅ Menyimpan jurnal otomatis saat akun modal sendiri ditambahkan ke COA.
     * Dipanggil oleh CoaController.
     *
     * @param \App\Models\Coa $coa
     * @return void
     */
    public static function simpanModalSendiri(Coa $coa)
    {
        if (strtolower(trim($coa->nama_coa)) === 'modal sendiri') {
            $tanggal = now()->toDateString();
            $saldo = $coa->saldo ?? 0;

            // 1. Debit - Kas (otomatis deteksi akun kas)
            $akunKas = Coa::where('header', 'Kas')->orWhere('kode_coa', '111')->first();
            if ($akunKas) {
                self::simpanJurnal([
                    'tanggal' => $tanggal,
                    'kode_coa' => $akunKas->kode_coa,
                    'debit' => $saldo,
                    'kredit' => 0,
                    'deskripsi' => 'Kas',
                ]);

            // 2. Kredit - Modal Sendiri
            self::simpanJurnal([
                'tanggal' => $tanggal,
                'kode_coa' => $coa->kode_coa,
                'debit' => 0,
                'kredit' => $saldo,
                'deskripsi' => 'Modal Sendiri',
            ]);
            }
        }
    }
}
