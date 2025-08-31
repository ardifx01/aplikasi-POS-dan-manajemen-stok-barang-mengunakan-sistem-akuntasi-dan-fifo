@extends('layoutbootstrap')

@section('konten')   
<div class="content-wrapper px-3">
    <main>
        <div class="container-fluid px-2 px-md-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-body">

                            {{-- ✅ Header --}}
                            <div class="text-center mb-4">
                                <h5 class="fw-bold mb-1">📦 Data Produk</h5>
                                <p class="text-muted small">Daftar Seluruh Produk Tersedia</p>
                            </div>

                            {{-- ✅ Alert --}}
                            @if(session('success'))
                                <div class="alert alert-success text-center">{{ session('success') }}</div>
                            @endif

                            {{-- ✅ Tabel Produk --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle text-center">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Kode</th>
                                            <th>Nama Produk</th>
                                            <th>Kategori</th>
                                            <th>Ukuran</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="table-light text-center">
                                        <tr>
                                            <th colspan="9">Total Produk: {{ $produk->count() }}</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse($produk as $index => $p)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if($p->gambar)
                                                        <img src="{{ asset('storage/produk/'.$p->gambar) }}" 
                                                             alt="Gambar Produk" 
                                                             style="height: 50px; width: 50px; object-fit: cover;" 
                                                             class="rounded shadow-sm">
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ $p->kode_produk }}</td>
                                                <td>{{ $p->nama_produk }}</td>
                                                <td>{{ $p->kategori }}</td>
                                                <td>{{ $p->ukuran }}</td>
                                                <td class="text-end">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                                                <td>{{ $p->stok }}</td>
                                                <td>
                                                    <span class="badge {{ $p->status == 'ada' ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ ucfirst($p->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-muted text-center">Tidak ada data produk</td>
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
