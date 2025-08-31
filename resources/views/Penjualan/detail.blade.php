@extends('layoutbootstrap')

@section('konten')

<div class="content-wrapper px-3 py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-secondary text-white rounded-top-4">
                        <h4 class="mb-0 fw-semibold">📄 Detail Penjualan</h4>
                    </div>
                    <div class="card-body px-4 py-4">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th style="width: 35%;">Kode Penjualan</th>
                                    <td>{{ $penjualan->kode_penjualan }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Kode Produk</th>
                                    <td>{{ $penjualan->produk->kode_produk }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Produk</th>
                                    <td>{{ $penjualan->produk->nama_produk }}</td>
                                </tr>
                                <tr>
                                    <th>Harga Satuan</th>
                                    <td>Rp {{ number_format($penjualan->harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>{{ $penjualan->jumlah }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td class="fw-bold text-success">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4 text-end">
                            <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
