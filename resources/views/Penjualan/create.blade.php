@extends('layoutbootstrap')

@section('konten')

<div class="container-fluid px-4" style="margin-left: 50px;">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card my-4 shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4 fw-bold">Form Tambah Penjualan</h4>

                    {{-- Notifikasi Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form Penjualan --}}
                    <form action="{{ route('penjualan.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">

                            {{-- Kode Penjualan --}}
                            <div class="col-md-6">
                                <label for="kode_penjualan" class="form-label">Kode Penjualan</label>
                                <input type="text" name="kode_penjualan" id="kode_penjualan" class="form-control" value="{{ $kode_penjualan }}" readonly>
                            </div>

                            {{-- Kode Produk --}}
                            <div class="col-md-6">
                                <label for="kode_produk" class="form-label">Kode Produk</label>
                                <input list="produkList" name="kode_produk" id="kode_produk" class="form-control" placeholder="Ketik atau pilih kode produk" required>
                                <datalist id="produkList">
                                    @foreach($produkList as $produk)
                                        <option value="{{ $produk->kode_produk }}">
                                            {{ $produk->nama_produk }} - Stok: {{ $produk->stok }}
                                        </option>
                                    @endforeach
                                </datalist>
                            </div>

                            {{-- Harga Satuan Manual --}}
                            <div class="col-md-6">
                                <label for="harga" class="form-label">Harga Satuan</label>
                                <input type="number" name="harga" id="harga" class="form-control" placeholder="Masukkan harga satuan" required oninput="hitungTotal()">
                            </div>

                            {{-- Jumlah --}}
                            <div class="col-md-6">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Contoh: 3" min="1" required oninput="hitungTotal()">
                            </div>

                            {{-- Total Harga --}}
                            <div class="col-md-6">
                                <label for="total" class="form-label">Total Harga</label>
                                <input type="number" name="total" id="total" class="form-control" placeholder="Otomatis" readonly>
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-md-6">
                                <label for="tanggal" class="form-label">Tanggal Penjualan</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="col-12 d-flex flex-column flex-md-row justify-content-between gap-3 mt-4">
                                <button type="submit" class="btn btn-success w-100 w-md-50">Simpan</button>
                                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary w-100 w-md-50">Batal</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script Hitung Total Harga --}}
<script>
    function hitungTotal() {
        const harga = parseFloat(document.getElementById('harga').value) || 0;
        const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
        const total = harga * jumlah;
        document.getElementById('total').value = total.toFixed(2);
    }
</script>

@endsection
