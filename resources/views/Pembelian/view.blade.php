@extends('layoutbootstrap')

@section('konten')   

<div class="content-wrapper px-3 px-md-3 px-lg-3">    <main>
        <div class="container-fluid"> {{-- Hapus margin-left --}}
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-body">
                            <h5 class="custom-card-title mb-3 text-center">Manajemen Pembelian</h5>
                            <span class="d-block text-center">Daftar Transaksi Pembelian</span>

                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ url('/pembelian/create') }}" class="btn btn-primary btn-sm">
                                    <i class="ti ti-shopping-cart-plus"></i> Tambah Pembelian
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle table-hover text-center">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>No Faktur</th>
                                            <th>Tanggal</th>
                                            <th>Supplier</th>
                                            <th>Produk</th>
                                            <th>Ukuran</th>
                                            <th>Total Barang</th>
                                            <th>Total Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="table-light text-center">
                                        <tr>
                                            <th colspan="9">Total Pembelian: {{ $pembelian->count() }}</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse ($pembelian as $index => $p)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $p->no_faktur }}</td>
                                                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                                                <td>{{ $p->supplier->nama_supplier ?? '-' }}</td>
                                                <td>{{ $p->produk->nama_produk ?? '-' }}</td>
                                                <td>{{ $p->produk->ukuran ?? '-' }}</td>
                                                <td>{{ $p->total_barang }}</td>
                                                <td class="text-end">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                                <td>
                                                    <a href="{{ route('pembelian.edit', $p->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                                    <form action="{{ route('pembelian.destroy', $p->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center text-muted">Belum ada data pembelian</td>
                                            </tr>
                                        @endforelse
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
