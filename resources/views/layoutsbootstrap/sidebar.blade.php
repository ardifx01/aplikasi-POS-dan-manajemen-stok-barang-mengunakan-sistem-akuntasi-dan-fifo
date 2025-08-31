<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ url('dashboardbootstrap') }}" class="brand-link">
    <img src="{{asset ('dist/img/AdminLTELogo.png') }}" alt="{{asset('images/logos/ITSCAD.JPEG')}}" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Itscad Distro</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset ('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{ url('dashboardbootstrap') }}" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item menu-open">
          <a href="{{ url('dashboardbootstrap') }}" class="nav-link active">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>Master Data <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('coa') }}" class="nav-link">
                <i class="fas fa-receipt nav-icon"></i>
                <p>Coa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('supplier') }}" class="nav-link">
                <i class="fas fa-parachute-box nav-icon"></i>
                <p>Supplier</p>
              </a>
            </li>
          </ul>
        </li>
 
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-exchange-alt"></i>
            <p>Transaksi <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('pembelian') }}" class="nav-link">
                <i class="fas fa-shopping-cart nav-icon"></i>
                <p>Pembelian</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('penjualan') }}" class="nav-link">
                <i class="fas fa-store nav-icon"></i>
                <p>Penjualan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('returnbarang') }}" class="nav-link">
                <i class="fas fa-undo-alt nav-icon"></i>
                <p>Return Barang</p>
              </a>
            </li>
          </ul>
        </li>

         <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>Stok<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
             <li class="nav-item">
              <a href="{{ url('produk') }}" class="nav-link">
                <i class="fas fa-cube nav-icon"></i>
                <p>Produk</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('produk/kartustok') }}" class="nav-link">
                <i class="fas fa-cube nav-icon"></i>
                <p>Kartu stok</p>
              </a>
            </li>
           </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book-open"></i>
            <p>Jurnal <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('jurnalumum') }}" class="nav-link">
                <i class="fas fa-book nav-icon"></i>
                <p>Jurnal Umum</p>
              </a>
            </li>
          </ul>
        </li>

         <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>Laporan<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('laporan/penjualanbulanan')}}" class="nav-link">
                <i class="fas fa-file-invoice nav-icon"></i>
                <p>Laporan Penjualan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('laporan/bukubesar') }}" class="nav-link">
                <i class="fas fa-book-open nav-icon"></i>
                <p>Buku Besar</p>
              </a>
            </li>
          </ul>
        </li>
    <!-- Logout -->
    <li class="nav-item">
      <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
