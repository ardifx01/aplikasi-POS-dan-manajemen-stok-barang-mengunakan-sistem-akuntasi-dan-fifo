@extends('layoutbootstrap')

@section('konten')   
<div class="content-wrapper">
<main>
    <div class="container-fluid px-3 px-md-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card my-4 border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <h5 class="text-center fw-bold mb-2">🧾 Manajemen Penjualan</h5>
                        <p class="text-center text-muted mb-3">Daftar Transaksi Penjualan</p>

                        {{-- Tombol Tambah --}}
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('penjualan.create') }}" class="btn btn-primary btn-sm">
                                <i class="ti ti-shopping-cart-plus me-1"></i> Tambah Penjualan
                            </a>
                        </div>

                        {{-- Notifikasi --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Tabel Penjualan --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Penjualan</th>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penjualan as $index => $pj)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pj->kode_penjualan }}</td>
                                            <td>{{ $pj->produk->nama_produk ?? '-' }}</td>
                                            <td class="text-end">Rp {{ number_format($pj->harga, 0, ',', '.') }}</td>
                                            <td>{{ $pj->jumlah }}</td>
                                            <td class="text-end">Rp {{ number_format($pj->total, 0, ',', '.') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pj->tanggal)->format('d-m-Y') }}</td>
                                            <td>
                                                <a href="{{ route('penjualan.show', $pj->id) }}" class="btn btn-info btn-sm">
                                                    <i class="ti ti-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">Belum ada data penjualan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="8" class="text-end pe-3">
                                            Total Transaksi: <strong>{{ $penjualan->count() }}</strong>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div> {{-- table-responsive --}}
                    </div>
                </div>                
            </div>
        </div>
    </div>
</main>
</div>
@endsection
