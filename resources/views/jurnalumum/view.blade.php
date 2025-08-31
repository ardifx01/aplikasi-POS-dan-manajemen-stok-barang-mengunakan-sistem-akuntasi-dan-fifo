@extends('layoutbootstrap')

@section('konten')
<div class="content-wrapper">
    <main>
        <div class="container-fluid" style="padding-left: 30px; padding-right: 30px;"> {{-- ✅ Jarak kiri-kanan pas --}}
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-body">
                            <h5 class="custom-card-title mb-3 text-center">Laporan Jurnal Umum</h5>
                            <span class="d-block text-center">Data Jurnal Perbulan</span>

                            <!-- Filter Bulan dan Tahun -->
                            <form method="GET" action="{{ route('jurnalumum.index') }}" class="my-4">
                                <div class="d-flex flex-wrap align-items-end justify-content-end" style="gap: 2rem;">
                                    @php
                                        $selectedBulan = request()->filled('bulan') ? (int)request('bulan') : now()->month;
                                        $selectedTahun = request()->filled('tahun') ? (int)request('tahun') : now()->year;
                                    @endphp

                                    <div class="form-group">
                                        <label for="bulan" class="form-label mb-1"><strong>Bulan:</strong></label>
                                        <select name="bulan" id="bulan" class="form-select" style="min-width: 180px;">
                                            <option value="">-- Semua Bulan --</option>
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}" {{ $selectedBulan == $m ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="tahun" class="form-label mb-1"><strong>Tahun:</strong></label>
                                        <input type="number" name="tahun" id="tahun" class="form-control" style="min-width: 180px;"
                                            placeholder="Contoh: 2025" value="{{ $selectedTahun }}">
                                    </div>

                                    <div class="form-group mt-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Tabel -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle text-center">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Ref (Kode COA)</th>
                                            <th>Deskripsi</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $lastTanggal = null; @endphp
                                        @forelse ($jurnal as $item)
                                            <tr>
                                                <td>
                                                    @if ($lastTanggal != $item->tanggal)
                                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}
                                                        @php $lastTanggal = $item->tanggal; @endphp
                                                    @endif
                                                </td>
                                                <td>{{ $item->kode_coa }}</td>
                                                <td style="text-align: left;">
                                                    @if ($item->kredit > 0 && $item->debit == 0)
                                                        &nbsp;&nbsp;&nbsp;&nbsp;{{ $item->deskripsi }}
                                                    @else
                                                        {{ $item->deskripsi }}
                                                    @endif
                                                </td>
                                                <td class="text-end">Rp {{ number_format($item->debit, 2, ',', '.') }}</td>
                                                <td class="text-end">Rp {{ number_format($item->kredit, 2, ',', '.') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Data jurnal belum tersedia untuk periode ini.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    @if (count($jurnal) > 0)
                                        <tfoot class="table-light fw-bold">
                                            <tr>
                                                <td colspan="3" class="text-end">Total</td>
                                                <td class="text-end">Rp {{ number_format($totalDebit, 2, ',', '.') }}</td>
                                                <td class="text-end">Rp {{ number_format($totalKredit, 2, ',', '.') }}</td>
                                            </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
