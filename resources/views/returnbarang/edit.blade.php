@extends('layoutbootstrap')

@section('konten') 

<div class="container-fluid px-4" style="margin-left: 50px;">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card my-4 shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4 fw-bold">Form Edit Return Barang</h4>

                    <!-- Error Message -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Input -->
                    <form action="{{ route('returnbarang.update', $returnbarang->kode_returnbarang) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">

                            <!-- Kode Supplier (manual + datalist) -->
                            <div class="col-12 col-md-6">
                                <label for="kode_supplier" class="form-label">Kode Supplier</label>
                                <input type="text" id="kode_supplier" name="kode_supplier" list="supplierList" class="form-control @error('kode_supplier') is-invalid @enderror" value="{{ old('kode_supplier', $returnbarang->kode_supplier) }}" required>
                                <datalist id="supplierList">
                                    @foreach($supplier as $s)
                                        <option value="{{ $s->kode_supplier }}">{{ $s->nama_supplier }}</option>
                                    @endforeach
                                </datalist>
                                @error('kode_supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kode Produk (manual + datalist) -->
                            <div class="col-12 col-md-6">
                                <label for="kode_produk" class="form-label">Kode Produk</label>
                                <input type="text" id="kode_produk" name="kode_produk" list="produkList" class="form-control @error('kode_produk') is-invalid @enderror" value="{{ old('kode_produk', $returnbarang->kode_produk) }}" required>
                                <datalist id="produkList">
                                    @foreach($produk as $p)
                                        <option value="{{ $p->kode_produk }}">{{ $p->nama_produk }}</option>
                                    @endforeach
                                </datalist>
                                @error('kode_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jumlah Retur -->
                            <div class="col-12 col-md-6">
                                <label for="jumlah" class="form-label">Jumlah Return</label>
                                <input id="jumlah" name="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', $returnbarang->jumlah) }}" min="1" required>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Harga per Unit -->
                            <div class="col-12 col-md-6">
                                <label for="harga" class="form-label">Harga per Unit</label>
                                <input id="harga" name="harga" type="number" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $returnbarang->harga) }}" min="1" required>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alasan -->
                            <div class="col-12">
                                <label for="alasan" class="form-label">Alasan Return</label>
                                <textarea id="alasan" name="alasan" rows="3" class="form-control @error('alasan') is-invalid @enderror" required>{{ old('alasan', $returnbarang->alasan) }}</textarea>
                                @error('alasan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Return -->
                            <div class="col-12">
                                <label for="tanggal_returnbarang" class="form-label">Tanggal Return</label>
                                <input id="tanggal_returnbarang" name="tanggal_returnbarang" type="date" class="form-control @error('tanggal_returnbarang') is-invalid @enderror" value="{{ old('tanggal_returnbarang', $returnbarang->tanggal_returnbarang) }}" required>
                                @error('tanggal_returnbarang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol Simpan dan Batal -->
                            <div class="col-12 d-flex flex-column flex-md-row justify-content-between gap-2 mt-3">
                                <button type="submit" class="btn btn-success btn-lg w-100 w-md-40">Simpan</button>
                                <a href="{{ url('/returnbarang') }}" class="btn btn-secondary btn-lg w-100 w-md-40">Batal</a>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
