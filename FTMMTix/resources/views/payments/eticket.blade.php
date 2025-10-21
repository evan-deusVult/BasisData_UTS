@extends('layouts.app')

@section('content')
<div class="container py-5">
  <div class="p-5 mb-4 bg-success text-white rounded-3 shadow-sm text-center">
    <i class="bi bi-check-circle" style="font-size: 5rem;"></i>
    <h1 class="display-4 fw-bold mt-3">Pembayaran Berhasil!</h1>
    <p class="lead">Terima kasih telah melakukan pembayaran. Berikut adalah e-ticket Anda.</p>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
          <h3 class="mb-0">E-TICKET</h3>
        </div>
        <div class="card-body p-4">
          
          {{-- QR Code / Ticket Code --}}
          <div class="text-center mb-4">
            <div class="p-3 bg-light rounded d-inline-block">
              <h2 class="mb-0 text-primary">{{ $order->code }}</h2>
              <small class="text-muted">Kode Tiket</small>
            </div>
          </div>

          {{-- Event Info --}}
          <h4 class="text-primary mb-3">{{ $order->orderItems->first()->event->title ?? 'N/A' }}</h4>
          
          <div class="row mb-3">
            <div class="col-md-6">
              <p class="mb-2"><i class="bi bi-calendar-event text-primary"></i> <strong>Tanggal:</strong><br>
                {{ $order->orderItems->first()->event->start_at ? \Carbon\Carbon::parse($order->orderItems->first()->event->start_at)->format('d F Y') : '-' }}
              </p>
              <p class="mb-2"><i class="bi bi-clock text-primary"></i> <strong>Waktu:</strong><br>
                {{ $order->orderItems->first()->event->start_at ? \Carbon\Carbon::parse($order->orderItems->first()->event->start_at)->format('H:i') : '-' }} WIB
              </p>
            </div>
            <div class="col-md-6">
              <p class="mb-2"><i class="bi bi-geo-alt text-primary"></i> <strong>Lokasi:</strong><br>
                {{ $order->orderItems->first()->event->venue ?? '-' }}
              </p>
              <p class="mb-2"><i class="bi bi-ticket-perforated text-primary"></i> <strong>Jumlah Tiket:</strong><br>
                {{ $order->orderItems->sum('qty') }} Tiket
              </p>
            </div>
          </div>

          <hr>

          {{-- Pemesan Info --}}
          <div class="row mb-3">
            <div class="col-md-6">
              <p class="mb-2"><strong>Nama Pemesan:</strong><br>
                {{ $order->student->name ?? $order->lecturer->name ?? $order->user->name ?? 'N/A' }}
              </p>
            </div>
            <div class="col-md-6">
              <p class="mb-2"><strong>Total Pembayaran:</strong><br>
                <span class="text-success fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
              </p>
            </div>
          </div>

          <hr>

          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Silakan tunjukkan e-ticket ini saat masuk ke acara.
          </div>

          {{-- Actions --}}
          <div class="d-grid gap-2">
            <button onclick="window.print()" class="btn btn-primary">
              <i class="bi bi-printer"></i> Cetak E-Ticket
            </button>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
              <i class="bi bi-house"></i> Kembali ke Home
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<style>
  @media print {
    .navbar, .footer, .btn { display: none; }
  }
</style>
@endsection
