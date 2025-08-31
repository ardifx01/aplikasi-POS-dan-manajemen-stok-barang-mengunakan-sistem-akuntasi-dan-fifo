@extends('layoutbootstrap')

@section('konten')   

<div class="container-fluid px-4" style="margin-left: 50px;">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card my-4 shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4 fw-bold">Form Return Barang</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('returnbarang.store') }}" method="post">
                        @csrf
                        <div class="row g-3">

                            {{-- Kode Supplier manual --}}
                            <div class="col-12 col-md-6">
                                <label for="kode_supplier" class="form-label">Kode Supplier</label>
                                <input type="text" id="kode_supplier" name="kode_supplier" class="form-control @error('kode_supplier') is-invalid @enderror" list="listSupplier" placeholder="Ketik kode supplier" required>
                                <datalist id="listSupplier">
                                    @foreach($suppliers as $s)
                                        <option value="{{ $s->kode_supplier }}">{{ $s->nama_supplier }}</option>
                                    @endforeach
                                </datalist>
                                @error('kode_supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kode Produk manual --}}
                            <div class="col-12 col-md-6">
                                <label for="kode_produk" class="form-label">Kode Produk</label>
                                <input type="text" id="kode_produk" name="kode_produk" class="form-control @error('kode_produk') is-invalid @enderror" list="listProduk" placeholder="Ketik kode produk" required>
                                <datalist id="listProduk">
                                    @foreach($produks as $p)
                                        <option value="{{ $p->kode_produk }}">{{ $p->nama_produk }}</option>
                                    @endforeach
                                </datalist>
                                @error('kode_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jumlah --}}
                            <div class="col-12 col-md-6">
                                <label for="jumlah" class="form-label">Jumlah Return</label>
                                <input id="jumlah" name="jumlah" type="number" class="form-control @error('jumlah') is-invalid @enderror" placeholder="Contoh: 5" min="1" required>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Harga --}}
                            <div class="col-12 col-md-6">
                                <label for="harga" class="form-label">Harga per Unit</label>
                                <input id="harga" name="harga" type="number" class="form-control @error('harga') is-invalid @enderror" placeholder="Contoh: 15000" min="1" required>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alasan --}}
                            <div class="col-12">
                                <label for="alasan" class="form-label">Alasan Return</label>
                                <textarea id="alasan" name="alasan" rows="3" class="form-control @error('alasan') is-invalid @enderror" placeholder="Contoh: Produk rusak atau tidak sesuai spesifikasi" required></textarea>
                                @error('alasan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-12">
                                <label for="tanggal_returnbarang" class="form-label">Tanggal Return</label>
                                <input id="tanggal_returnbarang" name="tanggal_returnbarang" type="date" class="form-control @error('tanggal_returnbarang') is-invalid @enderror" value="{{ date('Y-m-d') }}" required>
                                @error('tanggal_returnbarang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol --}}
                            <div class="col-12 d-flex flex-column flex-md-row justify-content-between gap-2 mt-3">
                                <button type="submit" class="btn btn-success btn-lg w-100 w-md-40">Simpan</button>
                                <a href="{{ route('returnbarang.index') }}" class="btn btn-secondary btn-lg w-100 w-md-40">Batal</a>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
