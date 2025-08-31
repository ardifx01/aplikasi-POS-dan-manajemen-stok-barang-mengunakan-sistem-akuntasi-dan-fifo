<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Itscad Distro | Dashboard</title>

  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- AdminLTE Theme -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- Overlay Scrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('dashboardbootstrap') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifikasi -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" id="notifIcon">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge" id="notifCount">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notifDropdown">
          <span class="dropdown-item dropdown-header" id="notifHeader">0 Notifications</span>
          <div class="dropdown-divider"></div>
          <div id="notifItems">
            <span class="dropdown-item text-muted text-center">Loading...</span>
          </div>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
        </div>
      </li>

      <!-- Fullscreen -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Toast Container -->
  <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999; right: 1rem; top: 4rem;"></div>

  <!-- Notifikasi Script -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      fetch("{{ route('notifikasi') }}")
        .then(res => res.json())
        .then(data => {
          const notifContainer = document.getElementById('notifItems');
          const toastContainer = document.querySelector('.toast-container');
          let readNotifs = JSON.parse(localStorage.getItem('readNotifIds') || '[]');
          let deletedNotifs = JSON.parse(localStorage.getItem('deletedNotifIds') || '[]');
          let toastShown = false;

          // Hapus notifikasi yang sudah ditandai sebagai dihapus
          data = data.filter(item => !deletedNotifs.includes(item.id));

          const notifCount = data.length;
          document.getElementById('notifCount').innerText = notifCount;
          document.getElementById('notifHeader').innerText = `${notifCount} Notifications`;

          notifContainer.innerHTML = '';

          if (notifCount === 0) {
            notifContainer.innerHTML = '<span class="dropdown-item text-muted text-center">Tidak ada notifikasi</span>';
            return;
          }

          data.forEach((item) => {
            const isRead = readNotifs.includes(item.id);

            // Buat elemen notifikasi
            const notifItem = document.createElement('div');
            notifItem.className = 'dropdown-item d-flex justify-content-between align-items-center';
            notifItem.setAttribute('data-id', item.id);
            notifItem.innerHTML = `
              <div><i class="${item.icon} mr-2"></i> ${item.text}<br><small class="text-muted">${item.time}</small></div>
              <button class="btn btn-sm btn-danger btn-delete-notif" title="Hapus">&times;</button>
            `;
            notifContainer.appendChild(notifItem);
            notifContainer.innerHTML += '<div class="dropdown-divider"></div>';

            // Tampilkan toast jika belum dibaca dan belum dihapus
            if (!isRead && !toastShown) {
              const toast = document.createElement('div');
              toast.className = 'toast align-items-center text-bg-info border-0 show';
              toast.setAttribute('role', 'alert');
              toast.setAttribute('aria-live', 'assertive');
              toast.setAttribute('aria-atomic', 'true');
              toast.innerHTML = `
                <div class="d-flex">
                  <div class="toast-body">
                    <i class="${item.icon} mr-2"></i> ${item.text}
                    <div class="text-muted small">${item.time}</div>
                  </div>
                  <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
              `;
              toastContainer.appendChild(toast);
              setTimeout(() => toast.remove(), 5000);

              // Tandai sebagai sudah dibaca
              readNotifs.push(item.id);
              toastShown = true;
            }
          });

          localStorage.setItem('readNotifIds', JSON.stringify([...new Set(readNotifs)]));

          // Event tombol hapus notifikasi
          document.querySelectorAll('.btn-delete-notif').forEach(button => {
            button.addEventListener('click', function (e) {
              e.stopPropagation();
              const id = this.closest('.dropdown-item').getAttribute('data-id');

              let deleted = JSON.parse(localStorage.getItem('deletedNotifIds') || '[]');
              deleted.push(id);
              localStorage.setItem('deletedNotifIds', JSON.stringify([...new Set(deleted)]));

              // Hapus dari DOM
              const item = this.closest('.dropdown-item');
              const divider = item.nextElementSibling;
              item.remove();
              if (divider && divider.classList.contains('dropdown-divider')) {
                divider.remove();
              }

              // Kurangi jumlah badge
              const updatedCount = parseInt(document.getElementById('notifCount').innerText) - 1;
              document.getElementById('notifCount').innerText = updatedCount;
              document.getElementById('notifHeader').innerText = `${updatedCount} Notifications`;

              if (updatedCount <= 0) {
                notifContainer.innerHTML = '<span class="dropdown-item text-muted text-center">Tidak ada notifikasi</span>';
              }
            });
          });
        });
    });
  </script>

</body>
</html>
