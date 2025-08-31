@extends('layoutbootstrap')

@section('konten')

<div class="container-fluid px-4" style="margin-left: 50px;">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card my-4 shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center fs-4 fw-bold">
                    Detail Retur Barang
                </div>
                <div class="card-body px-4 py-4">

                    <table class="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 40%;">Kode Retur</th>
                                <td>{{ $returnbarang->kode_returnbarang }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nama Supplier</th>
                                <td>{{ $returnbarang->supplier->nama_supplier }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nama Produk</th>
                                <td>{{ $returnbarang->produk->nama_produk }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Jumlah</th>
                                <td>{{ $returnbarang->jumlah }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Alasan Retur</th>
                                <td>{{ $returnbarang->alasan }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tanggal Retur</th>
                                <td>{{ \Carbon\Carbon::parse($returnbarang->tanggal_returnbarang)->format('d M Y') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-end mt-3">
                        <a href="{{ route('returnbarang.index') }}" class="btn btn-dark btn-lg">Kembali</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
