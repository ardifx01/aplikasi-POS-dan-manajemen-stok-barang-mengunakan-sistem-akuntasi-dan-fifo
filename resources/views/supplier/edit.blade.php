@extends('layoutbootstrap')

@section('konten')

<div class="content-wrapper px-3">
    <div class="container-fluid py-4 px-4" style="margin-left: 50px;">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h3 class="text-center fw-bold mb-3">Edit Supplier</h3>
                        <p class="text-center text-muted mb-4">Perbarui informasi data supplier yang diperlukan</p>

                        {{-- Error Validation --}}
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

                        {{-- Form Edit --}}
                        <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">

                                {{-- Kode Supplier --}}
                                <fieldset disabled>
                                    <div class="col-12">
                                        <label for="kode_supplier_tampil" class="form-label fw-semibold">Kode Supplier</label>
                                        <input type="text" class="form-control" id="kode_supplier_tampil" value="{{ $supplier->kode_supplier }}">
                                    </div>
                                </fieldset>
                                <input type="hidden" name="kode_supplier" value="{{ $supplier->kode_supplier }}">

                                {{-- Nama Supplier --}}
                                <div class="col-12">
                                    <label for="nama_supplier" class="form-label fw-semibold">Nama Supplier</label>
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control" value="{{ old('nama_supplier', $supplier->nama_supplier) }}" placeholder="Contoh: PT. Distro XYZ" required>
                                </div>

                                {{-- Alamat --}}
                                <div class="col-12">
                                    <label for="alamat" class="form-label fw-semibold">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Contoh: Jl. Merdeka No. 123" required>{{ old('alamat', $supplier->alamat) }}</textarea>
                                </div>

                                {{-- No Telpon --}}
                                <div class="col-12 col-md-6">
                                    <label for="no_telpon" class="form-label fw-semibold">No Telpon</label>
                                    <input type="text" name="no_telpon" id="no_telpon" class="form-control" placeholder="Contoh: 08123456789" value="{{ old('no_telpon', $supplier->no_telpon) }}" required>
                                </div>

                                {{-- Email --}}
                                <div class="col-12 col-md-6">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Contoh: supplier@distro.com" value="{{ old('email', $supplier->email) }}" required>
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
