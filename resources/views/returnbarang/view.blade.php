@extends('layoutbootstrap')

@section('konten')   
<div class="content-wrapper">
<main>
    <div class="container-fluid px-3 px-md-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card my-4 border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <h5 class="text-center fw-bold mb-2">♻️ Master Return Barang</h5>
                        <p class="text-center text-muted mb-4">Daftar Transaksi Retur Barang</p>

                        {{-- Alert sukses --}}
                        @if(session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body">

                                <!-- Tombol Tambah Data -->
                                <div class="d-flex justify-content-end mb-3">
                                    <a href="{{ route('returnbarang.create') }}" class="btn btn-success btn-sm">
                                        <i class="ti ti-plus me-1"></i> Tambah Retur Barang
                                    </a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle table-hover text-center">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Retur</th>
                                                <th>Supplier</th>
                                                <th>Produk</th>
                                                <th>Jumlah</th>
                                                <th>Total Harga</th>
                                                <th>Alasan</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $totalHargaSemua = 0; @endphp
                                            @forelse ($returnbarang as $r)
                                                @php
                                                    $totalHarga = $r->jumlah * $r->harga;
                                                    $totalHargaSemua += $totalHarga;
                                                @endphp
                                                <tr>
                                                    <td>{{ ($returnbarang->currentPage() - 1) * $returnbarang->perPage() + $loop->iteration }}</td>
                                                    <td>{{ $r->kode_returnbarang }}</td>
                                                    <td>{{ $r->supplier->nama_supplier }}</td>
                                                    <td>{{ $r->produk->nama_produk ?? '-' }}</td>
                                                    <td>{{ $r->jumlah }}</td>
                                                    <td class="text-end">Rp{{ number_format($totalHarga, 0, ',', '.') }}</td>
                                                    <td>{{ $r->alasan }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($r->tanggal_returnbarang)->format('d-m-Y') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-muted text-center">Tidak ada data retur barang.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot class="table-light text-end">
                                            <tr>
                                                <th colspan="5" class="text-end">Total Seluruh Retur:</th>
                                                <th>Rp{{ number_format($totalHargaSemua, 0, ',', '.') }}</th>
                                                <th colspan="2"></th>
                                            </tr>
                                            <tr>
                                                <th colspan="8" class="text-center">Total Data Retur Barang: {{ $returnbarang->total() }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $returnbarang->links() }}
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
