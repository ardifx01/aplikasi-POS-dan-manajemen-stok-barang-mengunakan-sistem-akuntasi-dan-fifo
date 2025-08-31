@extends('layoutbootstrap')

@section('konten')

<div class="container-fluid px-4" style="margin-left: 50px;">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card my-4 shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4 fw-bold">Form Edit Produk</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <!-- Kode Produk -->
                            <fieldset disabled>
                                <div class="mb-3">
                                    <label for="kode_produk_tampil" class="form-label">Kode Produk</label>
                                    <input class="form-control" id="kode_produk_tampil" type="text" value="{{ $produk->kode_produk }}" readonly>
                                </div>
                            </fieldset>
                            <input type="hidden" name="kode_produk" value="{{ $produk->kode_produk }}">

                            <!-- Nama Produk -->
                            <div class="col-12">
                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Contoh: Hoodie Oversize" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                            </div>

                            <!-- Kategori -->
                            <div class="col-12 col-md-6">
                                <label for="kategori" class="form-label">Kategori Produk</label>
                                <select name="kategori" id="kategori" class="form-select" required>
                                    <option value="" disabled>-- Pilih Kategori Produk --</option>
                                    <optgroup label="Atasan">
                                        <option value="Hoodie" {{ $produk->kategori == 'Hoodie' ? 'selected' : '' }}>Hoodie</option>
                                        <option value="Kaos" {{ $produk->kategori == 'Kaos' ? 'selected' : '' }}>Kaos</option>
                                        <option value="Kemeja" {{ $produk->kategori == 'Kemeja' ? 'selected' : '' }}>Kemeja</option>
                                        <option value="Jaket" {{ $produk->kategori == 'Jaket' ? 'selected' : '' }}>Jaket</option>
                                    </optgroup>
                                    <optgroup label="Bawahan & Aksesori">
                                        <option value="Celana" {{ $produk->kategori == 'Celana' ? 'selected' : '' }}>Celana</option>
                                        <option value="Sendal" {{ $produk->kategori == 'Sendal' ? 'selected' : '' }}>Sendal</option>
                                        <option value="Tas" {{ $produk->kategori == 'Tas' ? 'selected' : '' }}>Tas</option>
                                    </optgroup>
                                </select>
                            </div>

                             <!-- Satuan -->
                            <div class="col-12 col-md-6">
                                <label for="satuan" class="form-label">Satuan</label>
                                <input type="text" name="satuan" id="satuan" class="form-control" placeholder="Contoh: pcs, lusin" value="{{ old('satuan', $produk->satuan) }}" required>
                            </div>

                            <!-- Ukuran -->
                            <div class="col-12 col-md-6">
                                <label for="ukuran" class="form-label">Ukuran</label>
                                <input type="text" name="ukuran" id="ukuran" class="form-control" placeholder="Contoh: L, M, Oversize" value="{{ old('ukuran', $produk->ukuran) }}" required>
                            </div>

                            <!-- Harga -->
                            <div class="col-12 col-md-6">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="text" name="harga" id="harga" class="form-control" placeholder="Contoh: Rp. 150.000" value="{{ old('harga', $produk->harga) }}" required>
                            </div>

                            <!-- Stok -->
                            <div class="col-12 col-md-6">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="number" name="stok" id="stok" class="form-control" placeholder="Contoh: 50" value="{{ old('stok', $produk->stok) }}" min="0" required>
                            </div>

                            <!-- Gambar Produk -->
                            <div class="col-12">
                                <label for="gambar" class="form-label">Gambar Produk</label>
                                <input type="file" name="gambar" id="gambar" class="form-control" onchange="previewImg()">
                                <div class="form-text">Unggah gambar produk dalam format JPG, PNG, atau JPEG.</div>

                                @if ($produk->gambar)
                                    <img src="{{ asset('storage/produk/' . $produk->gambar) }}" alt="Gambar Produk" class="preview img-thumbnail mt-3" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <img class="preview img-thumbnail mt-3" style="display:none; width:150px; height:150px; object-fit:cover;">
                                @endif
                            </div>

                            <!-- Tombol -->
                            <div class="col-12 d-flex flex-column flex-md-row justify-content-between gap-2 mt-3">
                                <button type="submit" class="btn btn-success btn-lg w-90 w-md-40">Simpan</button>
                                <a href="{{ url('/produk') }}" class="btn btn-secondary btn-lg w-90 w-md-40">Batal</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Format Harga & Preview Gambar -->
<script>
    const hargaInput = document.getElementById('harga');
    hargaInput.addEventListener('input', function (e) {
        let value = e.target.value.replace(/[^\d]/g, '');
        if (value) {
            e.target.value = 'Rp. ' + new Intl.NumberFormat('id-ID').format(value);
        } else {
            e.target.value = '';
        }
    });

    function previewImg() {
        const input = document.getElementById('gambar');
        const preview = document.querySelector('.preview');

        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection
