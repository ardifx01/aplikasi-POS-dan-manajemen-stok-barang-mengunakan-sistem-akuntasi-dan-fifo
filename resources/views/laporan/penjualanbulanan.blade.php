@extends('layoutbootstrap')

@section('konten')

<div class="content-wrapper px-3 px-md-3 px-lg-3">
    <main>
        <div class="container-fluid px-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card my-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="custom-card-title text-center mb-2">🧾 Laporan Penjualan Bulanan</h5>
                            <p class="text-center text-muted mb-4">Menampilkan laporan bulan {{ \Carbon\Carbon::createFromFormat('m', request('bulan', date('m')))->translatedFormat('F') }} {{ request('tahun', date('Y')) }}</p>

                            {{-- Filter Bulan dan Tahun --}}
                            <form method="GET" action="{{ url('laporan/penjualanbulanan') }}" class="row g-2 mb-3 justify-content-end">
                                <div class="col-md-auto">
                                    <select name="tahun" class="form-select form-select-sm">
                                        @for ($i = now()->year; $i >= 2020; $i--)
                                            <option value="{{ $i }}" {{ request('tahun', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-auto">
                                    <select name="bulan" class="form-select form-select-sm">
                                        @foreach ([
                                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                        ] as $num => $name)
                                            <option value="{{ $num }}" {{ request('bulan', date('m')) == $num ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-auto">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-filter me-1"></i> Tampilkan
                                    </button>
                                </div>
                            </form>

                            {{-- Tabel Penjualan --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm align-middle table-hover">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Barang</th>
                                            <th>Bukti trx</th>
                                            <th>Jumlah</th>
                                            <th>Harga Jual</th>
                                            <th>Penerimaan Penjualan</th>
                                            <th>HPP</th>
                                            <th>Laba</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_penjualan = 0;
                                            $total_hpp = 0;
                                            $total_untung = 0;
                                        @endphp

                                        @forelse ($laporan as $item)
                                            @php
                                                $tanggal = \Carbon\Carbon::parse($item['tanggal'])->format('d-m-Y');
                                                $harga_jual = $item['harga'];
                                                $jumlah = $item['jumlah'];
                                                $pembayaran = $harga_jual * $jumlah;
                                                $hpp = $item['hpp'] ?? 0;
                                                $untung = $pembayaran - $hpp;

                                                $total_penjualan += $pembayaran;
                                                $total_hpp += $hpp;
                                                $total_untung += $untung;
                                            @endphp

                                            <tr>
                                                <td class="text-center">{{ $tanggal }}</td>
                                                <td>{{ $item['produk']->nama_produk ?? '-' }}</td>
                                                <td class="text-center">{{ $item['kode_penjualan'] }}</td>
                                                <td class="text-center">{{ $jumlah }}</td>
                                                <td class="text-end">Rp {{ number_format($harga_jual) }}</td>
                                                <td class="text-end">Rp {{ number_format($pembayaran) }}</td>
                                                <td class="text-end">Rp {{ number_format($hpp) }}</td>
                                                <td class="text-end">Rp {{ number_format($untung) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">Tidak ada data penjualan bulan ini</td>
                                            </tr>
                                        @endforelse

                                        {{-- Total --}}
                                        <tr class="table-secondary fw-bold text-end">
                                            <td colspan="5" class="text-center">Total Penjualan</td>
                                            <td>Rp {{ number_format($total_penjualan) }}</td>
                                            <td>Rp {{ number_format($total_hpp) }}</td>
                                            <td>Rp {{ number_format($total_untung) }}</td>
                                        </tr>
                                    </tbody>
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
