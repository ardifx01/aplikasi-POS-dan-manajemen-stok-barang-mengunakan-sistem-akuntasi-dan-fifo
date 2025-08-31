@extends('layoutbootstrap')

@section('konten')

<div class="content-wrapper px-3 px-md-3 px-lg-3">

    <div class="container-fluid px-4" style="margin-left: 50px;">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card my-4 shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <h4 class="text-center mb-4 fw-bold">Form Edit Pembelian</h4>

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">

                                {{-- No Faktur --}}
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Faktur</label>
                                    <input type="text" class="form-control" value="{{ $pembelian->no_faktur }}" readonly>
                                </div>

                                {{-- Supplier --}}
                                <div class="col-md-6">
                                    <label class="form-label">Supplier</label>
                                    <input type="text" name="kode_supplier" class="form-control" list="listSupplier" value="{{ $pembelian->kode_supplier }}" required>
                                    <datalist id="listSupplier">
                                        @foreach($supplier as $s)
                                            <option value="{{ $s->kode_supplier }}">{{ $s->nama_supplier }}</option>
                                        @endforeach
                                    </datalist>
                                </div>

                                {{-- Nama Produk --}}
                                <div class="col-md-6">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" name="nama_produk" class="form-control" value="{{ $pembelian->produk->nama_produk }}" required>
                                </div>

                                {{-- Kategori --}}
                                <div class="col-md-6">
                                    <label class="form-label">Kategori</label>
                                    <input type="text" name="kategori" class="form-control" value="{{ $pembelian->produk->kategori }}" required>
                                </div>

                                {{-- Ukuran --}}
                                <div class="col-md-6">
                                    <label class="form-label">Ukuran</label>
                                    <input type="text" name="ukuran" class="form-control" value="{{ $pembelian->produk->ukuran }}" required>
                                </div>

                                {{-- Satuan --}}
                                <div class="col-md-6">
                                    <label class="form-label">Satuan</label>
                                    <input type="text" name="satuan" class="form-control" value="{{ $pembelian->produk->satuan }}" required>
                                </div>

                                {{-- Harga --}}
                                <div class="col-md-6">
                                    <label class="form-label">Harga Satuan</label>
                                    <input type="number" name="harga" class="form-control" value="{{ $pembelian->harga }}" required>
                                </div>

                                {{-- Jumlah --}}
                                <div class="col-md-6">
                                    <label class="form-label">Jumlah Barang</label>
                                    <input type="number" name="jumlah" class="form-control" value="{{ $pembelian->total_barang }}" required>
                                </div>

                                {{-- Tanggal Pembelian --}}
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Pembelian</label>
                                    <input type="date" name="tanggal_pembelian" class="form-control" value="{{ $pembelian->tanggal }}" required>
                                </div>

                                {{-- Gambar (opsional) --}}
                                <div class="col-md-12">
                                    <label class="form-label">Gambar Produk (Opsional)</label>
                                    <input type="file" name="gambar" class="form-control" accept="image/*">
                                    @if ($pembelian->produk->gambar)
                                        <img src="{{ asset('storage/produk/' . $pembelian->produk->gambar) }}" class="img-thumbnail mt-2" width="120" alt="Gambar Produk">
                                    @endif
                                </div>

                                {{-- Tombol --}}
                                <div class="col-12 d-flex flex-column flex-md-row justify-content-between gap-3 mt-4">
                                    <button type="submit" class="btn btn-success w-100 w-md-50">Update</button>
                                    <a href="{{ route('pembelian.index') }}" class="btn btn-secondary w-100 w-md-50">Batal</a>
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
