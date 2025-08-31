@extends('layoutbootstrap')

@section('konten')

<div class="container-fluid px-4" style="margin-left: 50px;">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card my-4 shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4 fw-bold">Form Tambah Pembelian</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pembelian.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">

                            {{-- Nomor Faktur --}}
                            <div class="col-md-6">
                                <label for="no_faktur" class="form-label">Nomor Faktur</label>
                                <input type="text" class="form-control" value="{{ $noFaktur }}" readonly>
                            </div>

                            {{-- Supplier --}}
                            <div class="col-md-6">
                                <label for="kode_supplier" class="form-label">Supplier</label>
                                <input type="text" name="kode_supplier" class="form-control" list="listSupplier" placeholder="Pilih supplier" required>
                                <datalist id="listSupplier">
                                    @foreach($supplier as $s)
                                        <option value="{{ $s->kode_supplier }}">{{ $s->nama_supplier }}</option>
                                    @endforeach
                                </datalist>
                            </div>

                            {{-- Nama Produk --}}
                            <div class="col-md-6">
                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control" placeholder="Contoh: Kaos Polos" required>
                            </div>

                            {{-- Kategori (Dropdown Grouped) --}}
                            <div class="col-md-6">
                                <label for="kategori" class="form-label">Kategori Produk</label>
                                <select name="kategori" id="kategori" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Kategori Produk --</option>
                                    <optgroup label="Atasan">
                                        <option value="Hoodie" {{ old('kategori') == 'Hoodie' ? 'selected' : '' }}>Hoodie</option>
                                        <option value="Kaos" {{ old('kategori') == 'Kaos' ? 'selected' : '' }}>Kaos</option>
                                        <option value="Kemeja" {{ old('kategori') == 'Kemeja' ? 'selected' : '' }}>Kemeja</option>
                                        <option value="Jaket" {{ old('kategori') == 'Jaket' ? 'selected' : '' }}>Jaket</option>
                                    </optgroup>
                                    <optgroup label="Bawahan & Aksesori">
                                        <option value="Celana" {{ old('kategori') == 'Celana' ? 'selected' : '' }}>Celana</option>
                                        <option value="Sendal" {{ old('kategori') == 'Sendal' ? 'selected' : '' }}>Sendal</option>
                                        <option value="Tas" {{ old('kategori') == 'Tas' ? 'selected' : '' }}>Tas</option>
                                    </optgroup>
                                </select>
                            </div>

                            {{-- Ukuran --}}
                            <div class="col-md-6">
                                <label for="ukuran" class="form-label">Ukuran</label>
                                <input type="text" name="ukuran" class="form-control" placeholder="Contoh: L / XL / 32" required>
                            </div>

                            {{-- Satuan (Dropdown) --}}
                            <div class="col-md-6">
                                <label for="satuan" class="form-label">Satuan</label>
                                <select name="satuan" id="satuan" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Satuan --</option>
                                    <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>pcs</option>
                                    <option value="lusin" {{ old('satuan') == 'lusin' ? 'selected' : '' }}>lusin</option>
                                    <option value="pack" {{ old('satuan') == 'pack' ? 'selected' : '' }}>pack</option>
                                    <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>box</option>
                                    <option value="rim" {{ old('satuan') == 'rim' ? 'selected' : '' }}>rim</option>
                                    <option value="unit" {{ old('satuan') == 'unit' ? 'selected' : '' }}>unit</option>
                                </select>
                            </div>

                            {{-- Harga --}}
                            <div class="col-md-6">
                                <label for="harga" class="form-label">Harga Satuan</label>
                                <input type="number" name="harga" class="form-control" placeholder="Contoh: 10000" min="1" required>
                            </div>

                            {{-- Jumlah --}}
                            <div class="col-md-6">
                                <label for="jumlah" class="form-label">Jumlah Barang</label>
                                <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 5" min="1" required>
                            </div>

                            {{-- Gambar --}}
                            <div class="col-md-12">
                                <label for="gambar" class="form-label">Gambar Produk (opsional)</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*">
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-md-6">
                                <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
                                <input type="date" name="tanggal_pembelian" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>

                            {{-- Tombol --}}
                            <div class="col-12 d-flex flex-column flex-md-row justify-content-between gap-3 mt-4">
                                <button type="submit" class="btn btn-success w-100 w-md-50">Simpan</button>
                                <a href="{{ route('pembelian.index') }}" class="btn btn-secondary w-100 w-md-50">Batal</a>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
