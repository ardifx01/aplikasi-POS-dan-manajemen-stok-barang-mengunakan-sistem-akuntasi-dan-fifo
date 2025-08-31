@extends('layoutbootstrap')

@section('konten')

<div class="content-wrapper px-3">
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-9">
                <div class="card shadow-sm border-0 my-4">
                    <div class="card-body p-4">
                        <h4 class="text-center fw-bold mb-3">Form Edit COA</h4>

                        {{-- Error Message --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Form --}}
                        <form action="{{ route('coa.update', $coa->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">

                                {{-- Kode COA (readonly + hidden) --}}
                                <fieldset disabled>
                                    <div class="col-12">
                                        <label for="kode_coa_tampil" class="form-label">Kode COA</label>
                                        <input type="text" class="form-control" id="kode_coa_tampil" value="{{ $coa->kode_coa }}">
                                    </div>
                                </fieldset>
                                <input type="hidden" name="kode_coa" value="{{ $coa->kode_coa }}">

                                {{-- Nama Akun --}}
                                <div class="col-12">
                                    <label for="nama_coa" class="form-label">Nama Akun</label>
                                    <input type="text" name="nama_coa" id="nama_coa" class="form-control"
                                           placeholder="Contoh: Kas"
                                           value="{{ old('nama_coa', $coa->nama_coa) }}" required
                                           pattern="[A-Za-z\s]+" title="Nama hanya boleh berisi huruf dan spasi">
                                </div>

                                {{-- Header --}}
                                <div class="col-12">
                                    <label for="header" class="form-label">Header</label>
                                    <input type="text" name="header" id="header" class="form-control"
                                           placeholder="Contoh: 1000"
                                           value="{{ old('header', $coa->header) }}" required
                                           pattern="\d+" title="Header hanya boleh diisi angka.">
                                </div>

                                {{-- Saldo --}}
                                <div class="col-12">
                                    <label for="saldo" class="form-label">Saldo</label>
                                    <input type="number" name="saldo" id="saldo" class="form-control"
                                           placeholder="Contoh: 500000"
                                           step="0.01" required
                                           value="{{ old('saldo', $coa->saldo) }}">
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="col-12 d-flex flex-column flex-md-row justify-content-between gap-2 mt-3">
                                    <button type="submit" class="btn btn-success btn-lg w-100 w-md-50">Simpan</button>
                                    <a href="{{ route('coa.index') }}" class="btn btn-secondary btn-lg w-100 w-md-50">Batal</a>
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
