<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Barang Tahunan</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; page-break-inside: avoid; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        th { background-color: #f2c94c; }
        h3 { text-align: center; margin-bottom: 0; }
        .periode { text-align: center; margin-top: 2px; margin-bottom: 20px; font-size: 12px; }
        /* Hilangkan page break */
        .page-break { page-break-after: auto; }
        .bulan-section { margin-bottom: 40px; }
    </style>
</head>
<body>
@php
    use Carbon\Carbon;

    $tahunSelected = request('tahun', now()->year);
    // Kelompokkan tanggalPeriode per bulan (format: "01", "02", ...)
    $groupedBulan = collect($tanggalPeriode)
        ->groupBy(fn($tgl) => Carbon::parse($tgl)->format('m'));

    // Mapping nama bulan
    $namaBulan = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];
@endphp

<h3>Laporan Stok Barang Tahun {{ $tahunSelected }}</h3>

@foreach ($groupedBulan as $bulan => $tanggalBulan)
    @php
        // Ambil maksimal 28 hari (4 minggu)
        $maxTanggal = collect($tanggalBulan)->take(28);
        $mingguanTanggal = $maxTanggal->chunk(7);
    @endphp

    <div class="bulan-section">
        <p class="periode">
            Periode: 
            {{ Carbon::parse($maxTanggal->first())->translatedFormat('d F Y') }} - 
            {{ Carbon::parse($maxTanggal->last())->translatedFormat('d F Y') }}
            <br>
            Bulan: {{ $namaBulan[$bulan] ?? $bulan }}
        </p>

        <table>
            <thead>
                <tr>
                    <th rowspan="2">Kode</th>
                    <th rowspan="2">Nama Barang</th>
                    <th rowspan="2">Satuan</th>
                    <th rowspan="2">Harga Beli</th>
                    <th rowspan="2">Harga Jual</th>
                    <th rowspan="2">Stok Awal</th>
                    @foreach ($mingguanTanggal as $i => $minggu)
                        <th colspan="2">Minggu {{ $i + 1 }}</th>
                    @endforeach
                    <th rowspan="2">Stok Akhir</th>
                </tr>
                <tr>
                    @foreach ($mingguanTanggal as $minggu)
                        <th>Masuk</th>
                        <th>Keluar</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $item)
                    @php
                        $stokAwal = $item['stok_awal'] ?? 0;
                        $totalMasukTahun = 0;
                        $totalKeluarTahun = 0;
                    @endphp
                    <tr>
                        <td>{{ $item['produk']->kode_produk }}</td>
                        <td>{{ $item['produk']->nama_produk }}</td>
                        <td>{{ $item['produk']->satuan ?? 'Pcs' }}</td>
                        <td class="text-end">{{ number_format($item['produk']->harga_beli ?? 0) }}</td>
                        <td class="text-end">{{ number_format($item['produk']->harga ?? 0) }}</td>
                        <td class="text-center">{{ $stokAwal }}</td>

                        @foreach ($mingguanTanggal as $minggu)
                            @php
                                $totalMasuk = 0;
                                $totalKeluar = 0;
                                foreach ($minggu as $tgl) {
                                    $totalMasuk += $item['per_tanggal'][$tgl]['masuk'] ?? 0;
                                    $totalKeluar += $item['per_tanggal'][$tgl]['keluar'] ?? 0;
                                }
                                // Total untuk bulan ini
                                $totalMasukTahun += $totalMasuk;
                                $totalKeluarTahun += $totalKeluar;
                            @endphp
                            <td class="text-center">{{ $totalMasuk }}</td>
                            <td class="text-center">{{ $totalKeluar }}</td>
                        @endforeach

                        @php
                            $stokAkhir = $stokAwal + $totalMasukTahun - $totalKeluarTahun;
                        @endphp
                        <td class="text-center">{{ $stokAkhir }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endforeach

</body>
</html>
