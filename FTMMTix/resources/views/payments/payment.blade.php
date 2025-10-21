@extends('layouts.app')

@section('content')
<div class="container py-5">
  <div class="p-5 mb-4 bg-light rounded-3 shadow-sm text-center">
    <h1 class="display-4 fw-bold text-primary">Pembayaran</h1>
    <p class="lead text-secondary">Silakan pilih bank dan upload bukti pembayaran untuk menyelesaikan pemesanan tiket Anda.</p>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="bg-white p-4 rounded shadow-sm">
        
        {{-- Info Order --}}
        <div class="alert alert-info mb-4">
          <h5 class="alert-heading">Detail Pesanan</h5>
          <p class="mb-1"><strong>Event:</strong> {{ $order->orderItems->first()->event->title ?? 'N/A' }}</p>
          <p class="mb-1"><strong>Jumlah Tiket:</strong> {{ $order->orderItems->sum('qty') }}</p>
          <p class="mb-0"><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
        </div>

        <form id="paymentForm" action="{{ route('payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          {{-- Pilihan Bank --}}
          <div class="mb-3">
            <label for="bank_id" class="form-label text-primary">Pilih Bank</label>
            <select class="form-select" id="bank_id" name="bank_id" required>
              <option value="">-- Pilih Bank --</option>
              @foreach($banks as $bank)
                <option value="{{ $bank->id }}" 
                        data-account-name="{{ $bank->account_name }}"
                        data-account-number="{{ $bank->account_number }}">
                  {{ $bank->name }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Info Rekening Bank (muncul setelah pilih bank) --}}
          <div id="bankInfo" class="alert alert-success d-none mb-4">
            <h6 class="alert-heading">Informasi Rekening</h6>
            <p class="mb-1"><strong>Bank:</strong> <span id="selectedBankName"></span></p>
            <p class="mb-1"><strong>Atas Nama:</strong> <span id="accountName"></span></p>
            <p class="mb-0"><strong>Nomor Rekening:</strong> <span id="accountNumber"></span></p>
          </div>

          {{-- Upload Bukti Pembayaran --}}
          <div class="mb-3">
            <label for="proof" class="form-label text-primary">Upload Bukti Pembayaran</label>
            <input type="file" class="form-control" id="proof" name="proof" accept="image/*" required>
            <small class="text-muted">Format: JPG, PNG, max 2MB</small>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-success btn-lg">Konfirmasi Pembayaran</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<script>
  // Tampilkan info rekening saat bank dipilih
  document.getElementById('bank_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const bankInfo = document.getElementById('bankInfo');
    
    if (this.value) {
      document.getElementById('selectedBankName').textContent = selectedOption.text;
      document.getElementById('accountName').textContent = selectedOption.getAttribute('data-account-name');
      document.getElementById('accountNumber').textContent = selectedOption.getAttribute('data-account-number');
      bankInfo.classList.remove('d-none');
    } else {
      bankInfo.classList.add('d-none');
    }
  });
</script>
@endsection
