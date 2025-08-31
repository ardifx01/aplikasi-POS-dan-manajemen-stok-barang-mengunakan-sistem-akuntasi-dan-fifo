@extends('layoutbootstrap')

@section('konten')

<div class="content-wrapper px-3">
    <div class="container-fluid py-4 px-4" style="margin-left: 50px;">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-body px-4 py-5">
                        <h3 class="text-center mb-3 fw-bold">Tambah Supplier</h3> {{-- ← warna default --}}
                        <p class="text-center text-muted mb-4">Silakan lengkapi form di bawah ini untuk menambahkan supplier baru.</p>

                        {{-- Alert Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger shadow-sm">
                                <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Form Tambah Supplier --}}
                        <form action="{{ route('supplier.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">

                                {{-- Kode Supplier (readonly) --}}
                                <fieldset disabled>
                                    <div class="col-12">
                                        <label for="kode_supplier_tampil" class="form-label fw-semibold">Kode Supplier</label>
                                        <input type="text" class="form-control" id="kode_supplier_tampil" value="{{ $kode_supplier }}">
                                    </div>
                                </fieldset>
                                <input type="hidden" name="kode_supplier" value="{{ $kode_supplier }}">

                                {{-- Nama Supplier --}}
                                <div class="col-12">
                                    <label for="nama_supplier" class="form-label fw-semibold">Nama Supplier</label>
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control" placeholder="Contoh: PT. Distro XYZ" value="{{ old('nama_supplier') }}" required>
                                </div>

                                {{-- Alamat --}}
                                <div class="col-12">
                                    <label for="alamat" class="form-label fw-semibold">Alamat</label>
                                    <textarea name="alamat" id="alamat" rows="3" class="form-control" placeholder="Contoh: Jl. Merdeka No. 123" required>{{ old('alamat') }}</textarea>
                                </div>

                                {{-- No Telpon --}}
                                <div class="col-md-6">
                                    <label for="no_telpon" class="form-label fw-semibold">No Telpon</label>
                                    <input type="text" name="no_telpon" id="no_telpon" class="form-control" placeholder="Contoh: 08123456789" value="{{ old('no_telpon') }}" required>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Contoh: supplier@distro.com" value="{{ old('email') }}" required>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="col-12 d-flex flex-column flex-md-row justify-content-between gap-2 mt-4">
                                    <button type="submit" class="btn btn-success btn-lg w-100 w-md-50 shadow-sm">
                                        <i class="fas fa-save me-1"></i> Simpan
                                    </button>
                                    <a href="{{ url('/supplier') }}" class="btn btn-secondary btn-lg w-100 w-md-50 shadow-sm">
                                        <i class="fas fa-arrow-left me-1"></i> Batal
                                    </a>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
