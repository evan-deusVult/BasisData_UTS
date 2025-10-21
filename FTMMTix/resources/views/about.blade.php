@extends('layouts.app')

@section('content')
<div class="container py-5">
  {{-- Hero Section --}}
  <div class="text-center mb-5">
    <h1 class="display-4 fw-bold text-primary">About Us</h1>
    <p class="lead text-secondary">Meet the team behind FTMMTIX - Your Event & Ticketing Platform</p>
  </div>

  {{-- Project Info --}}
  <div class="row justify-content-center mb-5">
    <div class="col-lg-8">
      <div class="card shadow-sm">
        <div class="card-body p-5">
          <h3 class="text-primary mb-4">Kelompok B</h3>
          <p class="lead">
            FTMMTIX adalah platform manajemen event dan pemesanan tiket yang dikembangkan oleh Kelompok B 
            untuk memudahkan mahasiswa, dosen, dan masyarakat umum dalam mengakses dan memesan tiket event 
            di Fakultas Teknologi Maju dan Multidisiplin (FTMM).
          </p>
          <hr>
          <p class="mb-0">
            <strong>Project:</strong> Event & Ticketing Management System<br>
            <strong>Institution:</strong> Universitas Airlangga - FTMM<br>
            <strong>Year:</strong> 2025
          </p>
        </div>
      </div>
    </div>
  </div>

  {{-- Team Members --}}
  <div class="text-center mb-4">
    <h2 class="fw-bold text-primary">Our Team</h2>
    <p class="text-secondary">The amazing people who made this project possible</p>
  </div>

  <div class="row g-4">
    {{-- Member 1 - Cendekia --}}
    <div class="col-md-6 col-lg-4">
      <div class="card h-100 shadow-sm text-center">
        <div class="card-body p-4">
          <div class="mb-3">
            @if(file_exists(public_path('images/team/cendekia.jpg')) || file_exists(public_path('images/team/cendekia.png')))
              <img src="{{ asset('images/team/cendekia.' . (file_exists(public_path('images/team/cendekia.jpg')) ? 'jpg' : 'png')) }}" 
                   alt="Cendekia" 
                   class="rounded-circle" 
                   style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #0d6efd;">
            @else
              <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                   style="width: 120px; height: 120px; font-size: 2.5rem;">
                <i class="bi bi-person-circle"></i>
              </div>
            @endif
          </div>
          <h5 class="card-title fw-bold">Cendekia</h5>
          <p class="text-muted mb-2">164221089</p>
          <span class="badge bg-primary">Developer</span>
        </div>
      </div>
    </div>

    {{-- Member 2 - Gizha --}}
    <div class="col-md-6 col-lg-4">
      <div class="card h-100 shadow-sm text-center">
        <div class="card-body p-4">
          <div class="mb-3">
            @if(file_exists(public_path('images/team/gizha.jpg')) || file_exists(public_path('images/team/gizha.png')))
              <img src="{{ asset('images/team/gizha.' . (file_exists(public_path('images/team/gizha.jpg')) ? 'jpg' : 'png')) }}" 
                   alt="Gizha" 
                   class="rounded-circle" 
                   style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #198754;">
            @else
              <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center" 
                   style="width: 120px; height: 120px; font-size: 2.5rem;">
                <i class="bi bi-person-circle"></i>
              </div>
            @endif
          </div>
          <h5 class="card-title fw-bold">Gizha</h5>
          <p class="text-muted mb-2">164231011</p>
          <span class="badge bg-success">Developer</span>
        </div>
      </div>
    </div>

    {{-- Member 3 - Gracia --}}
    <div class="col-md-6 col-lg-4">
      <div class="card h-100 shadow-sm text-center">
        <div class="card-body p-4">
          <div class="mb-3">
            @if(file_exists(public_path('images/team/gracia.jpg')) || file_exists(public_path('images/team/gracia.png')))
              <img src="{{ asset('images/team/gracia.' . (file_exists(public_path('images/team/gracia.jpg')) ? 'jpg' : 'png')) }}" 
                   alt="Gracia" 
                   class="rounded-circle" 
                   style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #0dcaf0;">
            @else
              <div class="rounded-circle bg-info text-white d-inline-flex align-items-center justify-content-center" 
                   style="width: 120px; height: 120px; font-size: 2.5rem;">
                <i class="bi bi-person-circle"></i>
              </div>
            @endif
          </div>
          <h5 class="card-title fw-bold">Gracia</h5>
          <p class="text-muted mb-2">164231056</p>
          <span class="badge bg-info">Developer</span>
        </div>
      </div>
    </div>

    {{-- Member 4 - Evan --}}
    <div class="col-md-6 col-lg-4">
      <div class="card h-100 shadow-sm text-center">
        <div class="card-body p-4">
          <div class="mb-3">
            @if(file_exists(public_path('images/team/evan.jpg')) || file_exists(public_path('images/team/evan.png')))
              <img src="{{ asset('images/team/evan.' . (file_exists(public_path('images/team/evan.jpg')) ? 'jpg' : 'png')) }}" 
                   alt="Evan" 
                   class="rounded-circle" 
                   style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #ffc107;">
            @else
              <div class="rounded-circle bg-warning text-white d-inline-flex align-items-center justify-content-center" 
                   style="width: 120px; height: 120px; font-size: 2.5rem;">
                <i class="bi bi-person-circle"></i>
              </div>
            @endif
          </div>
          <h5 class="card-title fw-bold">Evan</h5>
          <p class="text-muted mb-2">164231061</p>
          <span class="badge bg-warning">Developer</span>
        </div>
      </div>
    </div>

    {{-- Member 5 - Ghaly --}}
    <div class="col-md-6 col-lg-4">
      <div class="card h-100 shadow-sm text-center">
        <div class="card-body p-4">
          <div class="mb-3">
            @if(file_exists(public_path('images/team/ghaly.jpg')) || file_exists(public_path('images/team/ghaly.png')))
              <img src="{{ asset('images/team/ghaly.' . (file_exists(public_path('images/team/ghaly.jpg')) ? 'jpg' : 'png')) }}" 
                   alt="Ghaly" 
                   class="rounded-circle" 
                   style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #dc3545;">
            @else
              <div class="rounded-circle bg-danger text-white d-inline-flex align-items-center justify-content-center" 
                   style="width: 120px; height: 120px; font-size: 2.5rem;">
                <i class="bi bi-person-circle"></i>
              </div>
            @endif
          </div>
          <h5 class="card-title fw-bold">Ghaly</h5>
          <p class="text-muted mb-2">164231069</p>
          <span class="badge bg-danger">Developer</span>
        </div>
      </div>
    </div>
  </div>

  {{-- Contact Section --}}
  <div class="row justify-content-center mt-5">
    <div class="col-lg-8">
      <div class="card shadow-sm bg-light">
        <div class="card-body p-5 text-center">
          <h4 class="text-primary mb-3">Get In Touch</h4>
          <p class="mb-4">
            Jika Anda memiliki pertanyaan atau ingin berkolaborasi dengan kami, 
            jangan ragu untuk menghubungi tim kami.
          </p>
          <div class="d-flex justify-content-center gap-3">
            <a href="mailto:info@ftmmtix.unair.ac.id" class="btn btn-primary">
              <i class="bi bi-envelope"></i> Email Us
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
              <i class="bi bi-house"></i> Back to Home
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
