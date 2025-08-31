@extends('layoutbootstrap')

@section('konten')
<div class="content-wrapper">

  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><i class="fas fa-chart-line"></i> Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Konten Utama -->
  <section class="content">
    <div class="container-fluid">

      <!-- Kotak Statistik (8 Total - 2 Baris x 4 Kolom) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ number_format($totalBarangMasuk ?? 0) }}</h3>
              <p>Stok Masuk</p>
            </div>
            <div class="icon"><i class="fas fa-arrow-down"></i></div>
            <a href="{{ url('/pembelian') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ number_format($totalBarangKeluar ?? 0) }}</h3>
              <p>Stok Keluar</p>
            </div>
            <div class="icon"><i class="fas fa-arrow-up"></i></div>
            <a href="{{ url('/penjualan') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ number_format($totalStok ?? 0) }}</h3>
              <p>Total Stok</p>
            </div>
            <div class="icon"><i class="fas fa-cubes"></i></div>
            <a href="{{ url('/produk') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>Rp {{ number_format($totalUangPenjualan ?? 0) }}</h3>
              <p>Total Penjualan</p>
            </div>
            <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            <a href="{{ url('/penjualan') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-secondary">
            <div class="inner">
              <h3>{{ number_format($totalProduk ?? 0) }}</h3>
              <p>Jumlah Produk</p>
            </div>
            <div class="icon"><i class="fas fa-boxes"></i></div>
            <a href="{{ url('/produk') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-dark">
            <div class="inner">
              <h3>{{ number_format($totalRetur ?? 0) }}</h3>
              <p>Total Retur</p>
            </div>
            <div class="icon"><i class="fas fa-undo"></i></div>
            <a href="{{ url('/returnbarang') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>{{ number_format($totalKategori ?? 0) }}</h3>
              <p>Total Kategori</p>
            </div>
            <div class="icon"><i class="fas fa-tags"></i></div>
            <a href="{{ url('/produk') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-teal">
            <div class="inner">
              <h3>{{ number_format($totalTransaksi ?? 0) }}</h3>
              <p>Total Transaksi</p>
            </div>
            <div class="icon"><i class="fas fa-exchange-alt"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>

      <!-- Grafik & Produk Terlaris -->
      <div class="row mt-4">
        <div class="col-lg-6">
          <div class="card shadow-sm">
            <div class="card-header bg-gradient-dark text-white">
              <h3 class="card-title"><i class="fas fa-chart-line"></i> Grafik Penjualan per Bulan</h3>
            </div>
            <div class="card-body">
              <canvas id="penjualanChart" style="min-height: 300px;"></canvas>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title"><i class="fas fa-star"></i> Produk Terlaris</h3>
            </div>
            <div class="card-body p-3">
              @if (count($barangSeringDibeli) > 0)
              <div class="table-responsive">
                <table class="table table-sm table-bordered text-center mb-0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode</th>
                      <th>Nama</th>
                      <th>Dibeli</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($barangSeringDibeli as $index => $produk)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $produk->kode_produk }}</td>
                      <td class="text-start">{{ $produk->nama_produk }}</td>
                      <td>{{ number_format($produk->total_dibeli) }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              @else
              <p class="text-center mb-0">Belum ada data penjualan.</p>
              @endif
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('penjualanChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: {!! json_encode($labelsBulanan) !!},
      datasets: [{
        label: 'Total Penjualan (Rp)',
        data: {!! json_encode($dataBulanan) !!},
        borderColor: '#007bff',
        backgroundColor: 'rgba(0, 123, 255, 0.2)',
        fill: true,
        tension: 0.3,
        pointBackgroundColor: 'white',
        pointBorderColor: '#007bff',
        pointRadius: 4
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: function(context) {
              return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return 'Rp ' + value.toLocaleString('id-ID');
            }
          }
        }
      }
    }
  });
</script>
@endpush
