@extends('layoutbootstrap')

@section('konten')
<div class="content-wrapper px-3 px-md-3 px-lg-3">
    <main>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-body">
                            <h5 class="custom-card-title mb-3 text-center">Laporan Buku Besar</h5>
                            <span class="d-block text-center">Detail Transaksi Akun Bulanan</span>

                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('laporan.bukubesar') }}" class="row g-3 mb-4 mt-4">
                                <div class="col-md-3">
                                    <label for="bulan">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-control">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ $i == $bulan ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="tahun">Tahun</label>
                                    <input type="number" name="tahun" id="tahun" class="form-control" value="{{ $tahun }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="keterangan">Keterangan (Kode/Nama Akun)</label>
                                    <input type="text" name="keterangan" id="keterangan" class="form-control"
                                        value="{{ request('keterangan') }}" placeholder="Misal: 111 atau Kas">
                                </div>
                                <div class="col-md-2 align-self-end">
                                    <button class="btn btn-primary w-100">Tampilkan</button>
                                </div>
                            </form>

                            @php
                                $kodeAkun = request('keterangan'); // ambil kode akun dari input
                            @endphp

                            <!-- Tabel Buku Besar -->
                            @if ($jurnalGabung->isNotEmpty())
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered table-hover text-center align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th rowspan="2">Tanggal</th>
                                                <th rowspan="2">Keterangan</th>
                                                <th rowspan="2">Debit</th>
                                                <th rowspan="2">Kredit</th>
                                                <th colspan="2">Saldo</th>
                                            </tr>
                                            <tr>
                                                <th>Debit</th>
                                                <th>Kredit</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-end">
                                            @php $saldo = $saldo_awal; @endphp

                                            <!-- Baris Saldo Awal -->
                                            <tr class="table-secondary fw-bold">
                                                <td colspan="4" class="text-start">Saldo Awal</td>
                                                <td>
                                                    @if ($saldo >= 0)
                                                        Rp {{ number_format($saldo, 0, ',', '.') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($saldo < 0)
                                                        @if ($kodeAkun == '411')
                                                            Rp {{ number_format(abs($saldo), 0, ',', '.') }}
                                                        @else
                                                            (Rp {{ number_format(abs($saldo), 0, ',', '.') }})
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Baris Transaksi -->
                                            @foreach ($jurnalGabung as $item)
                                                @php
                                                    $saldo += $item->debit - $item->kredit;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}</td>
                                                    <td class="text-start">{{ $item->deskripsi }}</td>
                                                    <td>Rp {{ number_format($item->debit, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($item->kredit, 0, ',', '.') }}</td>
                                                    <td>
                                                        @if ($saldo >= 0)
                                                            Rp {{ number_format($saldo, 0, ',', '.') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($saldo < 0)
                                                            @if ($kodeAkun == '411')
                                                                Rp {{ number_format(abs($saldo), 0, ',', '.') }}
                                                            @else
                                                                (Rp {{ number_format(abs($saldo), 0, ',', '.') }})
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <!-- Baris Saldo Akhir -->
                                            <tr class="table-primary fw-bold">
                                                <td colspan="4" class="text-start">Saldo Akhir</td>
                                                <td>
                                                    @if ($saldo >= 0)
                                                        Rp {{ number_format($saldo, 0, ',', '.') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($saldo < 0)
                                                        @if ($kodeAkun == '411')
                                                            Rp {{ number_format(abs($saldo), 0, ',', '.') }}
                                                        @else
                                                            (Rp {{ number_format(abs($saldo), 0, ',', '.') }})
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-warning text-center mt-3">
                                    Tidak ada data buku besar ditemukan untuk filter yang dipilih.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
