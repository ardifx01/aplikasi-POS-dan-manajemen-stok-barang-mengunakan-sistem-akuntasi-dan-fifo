@extends('layoutbootstrap')

@section('konten')   

<div class="content-wrapper px-3">
    <main>
        <div class="container-fluid px-3 px-md-4">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card my-4 shadow-sm">
                        <div class="card-body">

                            {{-- ✅ Header --}}
                            <div class="text-center mb-4">
                                <h5 class="fw-bold mb-1">📇 Master Data Supplier</h5>
                                <p class="text-muted small">Daftar Supplier</p>
                            </div>

                            {{-- ✅ Tombol Tambah --}}
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ url('/supplier/create') }}" class="btn btn-success btn-sm">
                                    <i class="ti ti-plus me-1"></i> Tambah Data
                                </a>
                            </div>

                            {{-- ✅ Tabel Data Supplier --}}
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered align-middle table-hover">
                                            <thead class="table-dark text-center">
                                                <tr>
                                                    <th>Kode Supplier</th>
                                                    <th>Nama Supplier</th>
                                                    <th>Alamat</th>
                                                    <th>No Telepon</th>
                                                    <th>Email</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($supplier as $P)
                                                    <tr>
                                                        <td class="text-center">{{ $P->kode_supplier }}</td>
                                                        <td>{{ $P->nama_supplier }}</td>
                                                        <td>{{ $P->alamat }}</td>
                                                        <td class="text-center">{{ $P->no_telpon }}</td>
                                                        <td>{{ $P->email }}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('supplier.edit', $P->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                                            <form action="{{ route('supplier.destroy', $P->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-muted text-center">Tidak ada data supplier</td>
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
            </div>
        </div>
    </main>
</div>

@endsection
