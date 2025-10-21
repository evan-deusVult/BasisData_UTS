<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>{{ config('app.name', 'FTMMTIX') }}</title>

  {{-- @vite(['resources/css/app.css','resources/js/app.js']) --}}

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('css/theme.css') }}?v={{ time() }}">

  <style>
    /* Layout specifics */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      position: relative;
      padding-bottom: 220px; /* tinggi footer + margin */
    }
    
    footer {
      padding: 40px 0;
      margin-top: 60px;
      position: absolute;
      left: 0;
      right: 0;
      bottom: 0;
      width: 100%;
    }
    
    footer a {
      text-decoration: none;
    }
    
    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  
  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
      <img src="{{ asset('images/logo-ftmm-tix4.png') }}" 
           alt="FTMMTIX Logo" 
           width="130" 
           height="auto" 
           class="me-2">
    </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>


          @if(auth('lecturer')->check())
            <li class="nav-item"><a class="nav-link" href="{{ route('account.edit') }}">Edit Akun</a></li>
            <li class="nav-item"><span class="nav-link disabled">Hi, {{ auth('lecturer')->user()->name }} (Dosen)</span></li>
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-dark ms-lg-2">Logout</button>
              </form>
            </li>
          @elseif(auth('user')->check())
            <li class="nav-item"><a class="nav-link" href="{{ route('account.edit') }}">Edit Akun</a></li>
            <li class="nav-item"><span class="nav-link disabled">Hi, {{ auth('user')->user()->name }} (Umum)</span></li>
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-dark ms-lg-2">Logout</button>
              </form>
            </li>
          @elseif(auth()->check())
            @if(auth()->user()->role === 'admin')
              {{-- <li class="nav-item"><a class="nav-link" href="{{ url('/admin/dashboard') }}">Dashboard Admin</a></li> --}}
            @else
              <li class="nav-item"><a class="nav-link" href="{{ route('account.edit') }}">Edit Akun</a></li>
            @endif
            <li class="nav-item"><span class="nav-link disabled">Hi, {{ auth()->user()->name }}</span></li>
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-dark ms-lg-2">Logout</button>
              </form>
            </li>
          @else
            <li class="nav-item">
              <a href="{{ route('login') }}" class="btn btn-sm btn-outline-dark ms-lg-2">Login</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('register') }}" class="btn btn-sm btn-success ms-lg-2">Register</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.login') }}" class="btn btn-sm btn-warning ms-lg-2">Login Admin</a>
            </li>
          @endif
          <li class="nav-item">
            <button id="theme-toggle" class="btn btn-outline-secondary btn-sm ms-2">
              <i class="bi bi-moon-fill"></i> Dark Mode
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- Flash Message --}}
  <div class="container mt-3">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  <main>
    @yield('content')
  </main>

  {{-- Footer --}}
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-3">
          <h5>FTMMTIX</h5>
          <p>Fakultas Teknologi Maju dan Multidisiplin<br>Universitas Airlangga</p>
        </div>
        <div class="col-md-4 mb-3">
          <h6>Quick Links</h6>
          <ul class="list-unstyled">
            <li><a href="{{ url('/') }}">Events</a></li>
            <li><a href="{{ route('about') }}">About Us</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h6>Contact Info</h6>
          <p>
          Jl. Dr. Ir. H. Soekarno, Mulyorejo, Kec. Mulyorejo, Kota Surabaya, Jawa Timur 60115<br>
            Email: info@ftmm.unair.ac.id
          </p>
        </div>
      </div>
      <div class="text-center pt-3">
        <small>© {{ date('Y') }} FTMMTIX. All rights reserved.</small>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/theme-toggle.js') }}?v={{ time() }}" defer></script>
</body>
</html>
