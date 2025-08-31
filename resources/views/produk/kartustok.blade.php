@extends('layoutbootstrap')

@section('konten')   
<div class="content-wrapper px-3">
    <main>
        <div class="container-fluid px-2 px-md-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-body">
                            {{-- ✅ Judul Header --}}
                            <div class="text-center mb-4">
                                <h5 class="fw-bold mb-1">📦 Laporan Kartu Stok</h5>
                                <p class="text-muted small">Transaksi Per Produk (FIFO)</p>
                            </div>

                            {{-- ✅ FORM FILTER --}}
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('produk.kartustok') }}" method="GET" class="row g-3 mb-3">
                                        <div class="col-md-2">
                                            <label class="form-label">Bulan</label>
                                            <select name="bulan" class="form-select">
                                                @php
                                                    $bulanList = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
                                                    $selectedBulan = (int) request('bulan', date('m'));
                                                @endphp
                                                @foreach ($bulanList as $num => $nama)
                                                    <option value="{{ $num }}" {{ $selectedBulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label">Tahun</label>
                                            <input type="number" name="tahun" class="form-control" min="2000" value="{{ request('tahun', date('Y')) }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Ketik Produk</label>
                                            <input list="produkList" name="produk" id="produk" class="form-control" required value="{{ request('produk') }}" placeholder="Ketik kode atau nama produk">
                                            <datalist id="produkList">
                                                @foreach ($produk as $item)
                                                    <option value="{{ $item->kode_produk }}">{{ $item->nama_produk }}</option>
                                                @endforeach
                                            </datalist>
                                        </div>

                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                                        </div>
                                    </form>

                                    {{-- ✅ TABEL KARTU STOK --}}
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered align-middle table-hover">
                                            <thead class="table-dark text-center">
                                                <tr>
                                                    <th rowspan="2">Tanggal</th>
                                                    <th colspan="3">Pembelian</th>
                                                    <th colspan="3">Harga Pokok Penjualan<br>(termasuk Return Barang)</th>
                                                    <th colspan="3">Persediaan</th>
                                                </tr>
                                                <tr>
                                                    <th>Unit</th>
                                                    <th>Harga/Unit</th>
                                                    <th>Total</th>
                                                    <th>Unit</th>
                                                    <th>Harga/Unit</th>
                                                    <th>Total</th>
                                                    <th>Unit</th>
                                                    <th>Harga/Unit</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($kartu_stock as $item)
                                                    <tr>
                                                        <td class="text-center">
                                                            @if (!empty($item['tanggal']) && $item['tanggal'] !== '-')
                                                                {{ \Carbon\Carbon::parse($item['tanggal'])->format('d-m-Y') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>

                                                        {{-- Pembelian --}}
                                                        @if (!empty($item['pembelian']))
                                                            <td class="text-center">{{ $item['pembelian']['jumlah'] }}</td>
                                                            <td class="text-end">{{ number_format($item['pembelian']['harga'], 2) }}</td>
                                                            <td class="text-end">{{ number_format($item['pembelian']['total'], 2) }}</td>
                                                        @else
                                                            <td colspan="3" class="text-center">-</td>
                                                        @endif

                                                        {{-- Penjualan + Return --}}
                                                        @if (!empty($item['penjualan']) || !empty($item['return']))
                                                            <td class="text-center">
                                                                @if (!empty($item['penjualan']))
                                                                    @foreach ($item['penjualan'] as $jual)
                                                                        {{ $jual['jumlah'] }}<br>
                                                                    @endforeach
                                                                @endif
                                                                @if (!empty($item['return']))
                                                                    @foreach ($item['return'] as $ret)
                                                                        <span class="text-danger">{{ $ret['jumlah'] }} (Ret)</span><br>
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td class="text-end">
                                                                @if (!empty($item['penjualan']))
                                                                    @foreach ($item['penjualan'] as $jual)
                                                                        {{ number_format($jual['harga'], 2) }}<br>
                                                                    @endforeach
                                                                @endif
                                                                @if (!empty($item['return']))
                                                                    @foreach ($item['return'] as $ret)
                                                                        {{ number_format($ret['harga'], 2) }}<br>
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td class="text-end">
                                                                @if (!empty($item['penjualan']))
                                                                    @foreach ($item['penjualan'] as $jual)
                                                                        {{ number_format($jual['total'], 2) }}<br>
                                                                    @endforeach
                                                                @endif
                                                                @if (!empty($item['return']))
                                                                    @foreach ($item['return'] as $ret)
                                                                        {{ number_format($ret['total'], 2) }}<br>
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                        @else
                                                            <td colspan="3" class="text-center">-</td>
                                                        @endif

                                                        {{-- Persediaan --}}
                                                        @if (!empty($item['stock']))
                                                            <td class="text-center">
                                                                @foreach ($item['stock'] as $stok)
                                                                    {{ $stok['jumlah'] }}<br>
                                                                @endforeach
                                                            </td>
                                                            <td class="text-end">
                                                                @foreach ($item['stock'] as $stok)
                                                                    {{ number_format($stok['harga'], 2) }}<br>
                                                                @endforeach
                                                            </td>
                                                            <td class="text-end">
                                                                @foreach ($item['stock'] as $stok)
                                                                    {{ number_format($stok['jumlah'] * $stok['harga'], 2) }}<br>
                                                                @endforeach
                                                            </td>
                                                        @else
                                                            <td colspan="3" class="text-center">-</td>
                                                        @endif
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="10" class="text-center text-muted">Tidak ada data ditampilkan.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr class="text-center fw-bold">
                                                    <td>Total</td>
                                                    <td>{{ number_format($total_item_beli) }}</td>
                                                    <td></td>
                                                    <td class="text-end">{{ number_format($total_beli, 2) }}</td>
                                                    <td>{{ number_format($total_item_jual + $total_item_return) }}</td>
                                                    <td></td>
                                                    <td class="text-end">{{ number_format($total_jual + $total_return, 2) }}</td>
                                                    <td>{{ number_format($total_item_stok) }}</td>
                                                    <td></td>
                                                    <td class="text-end">{{ number_format($total_stok, 2) }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
