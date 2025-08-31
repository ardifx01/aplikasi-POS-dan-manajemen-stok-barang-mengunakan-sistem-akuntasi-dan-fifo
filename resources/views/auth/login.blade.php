<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Aplikasi</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>Aplikasi</b>Login</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Silakan masuk untuk memulai sesi</p>

      {{-- Status Session --}}
      @if (session('status'))
          <div class="alert alert-success text-sm">
              {{ session('status') }}
          </div>
      @endif

      {{-- Error Global --}}
      @if ($errors->any())
          <div class="alert alert-danger text-sm">
              <ul class="mb-0 ps-3">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>

        {{-- Password --}}
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>

        {{-- Remember Me --}}
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember_me" name="remember">
              <label for="remember_me">Ingat Saya</label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
          </div>
        </div>
      </form>

      {{-- Social Login --}}
      <div class="social-auth-links text-center mt-3 mb-3">
        <a href="{{ url('auth/facebook') }}" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Masuk dengan Facebook
        </a>
        <a href="{{ url('auth/google') }}" class="btn btn-block btn-danger">
          <i class="fab fa-google mr-2"></i> Masuk dengan Google
        </a>
      </div>

      {{-- Links --}}
      <p class="mb-1">
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}">Lupa password?</a>
        @endif
      </p>
      <p class="mb-0">
        @if (Route::has('register'))
          <a href="{{ route('register') }}" class="text-center">Daftar akun baru</a>
        @endif
      </p>

    </div>
  </div>
</div>

<!-- JS -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
