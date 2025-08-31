@extends('layoutbootstrap')

@section('konten')

<div class="content-wrapper px-3">
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-40 col-lg-10 col-xl-40">
                <div class="card shadow-sm border-0 my-4">
                    <div class="card-body">
                        <h4 class="text-center fw-bold mb-2">Master Data COA</h4>
                        <p class="text-center text-muted mb-4">Daftar Chart of Accounts (COA) yang tersedia</p>

                        {{-- Tombol Tambah --}}
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ url('/coa/create') }}" class="btn btn-success btn-sm shadow-sm">
                                <i class="ti ti-plus me-1"></i> Tambah Data
                            </a>
                        </div>

                        {{-- Tabel Data --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 10%;">Kode</th>
                                        <th class="text-start">Nama Akun</th>
                                        <th style="width: 10%;">Header</th>
                                        <th style="width: 15%;">Saldo</th>
                                        <th style="width: 20%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($coa as $c)
                                        <tr>
                                            <td>{{ $c->kode_coa }}</td>
                                            <td class="text-start">{{ $c->nama_coa }}</td>
                                            <td>{{ $c->header }}</td>
                                            <td class="text-end">Rp{{ number_format($c->saldo, 0, ',', '.') }}</td>
                                            <td>
                                                <a href="{{ route('coa.edit', $c->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                                                <form action="{{ route('coa.destroy', $c->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-muted">Tidak ada data COA</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div> {{-- table-responsive --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
