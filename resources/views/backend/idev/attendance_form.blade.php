@php
    $eventName = $data_query->event->workshop->name ?? '-';
    $jamIn = \Carbon\Carbon::parse($data_query->event->start_date)->format('H:i') ?? '-';
    $jamOut = \Carbon\Carbon::parse($data_query->event->end_date)->format('H:i') ?? '-';
    $date = \Carbon\Carbon::parse($data_query->event->start_date)->translatedFormat('d F Y') ?? '-';
    $speaker = $data_query->event->speaker ?? '-';
    $category = request('cat') ?? '-';
    $instructor = $data_query->event->instructor ?? '-';
@endphp

@extends("easyadmin::backend.parent")
@section("content")
@push('mtitle')
{{$title}}
@endpush
<div class="pc-container">
  <div class="pc-content">

    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            Hi, <b>{{ Auth::user()->name }} </b> 
            @if(config('idev.enable_role',true))
            You are logged in as <i>{{ Auth::user()->role->name }}</i> 
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-body p-3">
            <!-- KARTU KONFIRMASI KEHADIRAN (PENGGANTI "Welcome to iDev") -->
            <div class="card">
                <div class="card-body p-4 p-sm-5">
                    
                    <!-- Judul Kartu -->
                    <div class="d-flex justify-content-between align-items-center">
                      <h3 class="fw-bold text-dark">Konfirmasi Kehadiran Pelatihan</h3>
                        @if($data_query->sign_ready && $data_query->sign_present)
                          <span class="badge text-bg-success text-dark fs-6">Sudah Konfirmasi</span>
                        @else
                          <span class="badge text-bg-warning text-dark fs-6">Menunggu Konfirmasi</span>
                        @endif
                    </div>
                    <p class="mt-2 text-muted">Anda diundang untuk mengikuti pelatihan berikut. Mohon konfirmasi kehadiran Anda.</p>
                    <hr class="my-4">

                    <!-- Detail Pelatihan -->
                    <div class="vstack gap-4">
                        <!-- Judul Pelatihan -->
                        <div class="d-flex align-items-start">
                            <div class="icon-circle flex-shrink-0 bg-info-subtle text-info">
                                <i class="ti ti-bookmark fs-4"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0">Judul Pelatihan</p>
                                <p class="fw-semibold text-dark mb-0">{{ $eventName }}</p>
                            </div>
                        </div>

                        <!-- Instruktur -->
                        <div class="d-flex align-items-start">
                           <div class="icon-circle flex-shrink-0 bg-info-subtle text-info">
                                <i class="ti ti-user fs-4"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0">Instruktur</p>
                                <p class="fw-semibold text-dark mb-0">{{ $speaker }} <span class="fw-normal text-muted small">({{ $instructor }})</span></p>
                            </div>
                        </div>
                        
                        <!-- Grid untuk Tanggal, Jam, dan Ruang -->
                        <div class="row pt-2 g-4">
                            <!-- Tanggal -->
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle flex-shrink-0 bg-light text-secondary">
                                       <i class="ti ti-calendar-event fs-4"></i>
                                    </div>
                                    <div class="ms-3">
                                        <p class="text-muted mb-0">Tanggal</p>
                                        <p class="fw-semibold text-dark mb-0">{{ $date ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                             <!-- Jam -->
                            <div class="col-md-4">
                                 <div class="d-flex align-items-center">
                                    <div class="icon-circle flex-shrink-0 bg-light text-secondary">
                                       <i class="ti ti-clock fs-4"></i>
                                    </div>
                                    <div class="ms-3">
                                        <p class="text-muted mb-0">Jam</p>
                                        <p class="fw-semibold text-dark mb-0">{{ $jamIn }} - {{ $jamOut ?? 'Selesai' }} WIB</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Ruang -->
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle flex-shrink-0 bg-light text-secondary">
                                       <i class="ti ti-map-pin fs-4"></i>
                                    </div>
                                    <div class="ms-3">
                                        <p class="text-muted mb-0">Ruang</p>
                                        <p class="fw-semibold text-dark mb-0">{{ $data_query->event->location ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tombol Aksi -->
                    <div class="mt-5">
                        <!-- Pesan Konfirmasi (Awalnya tersembunyi) -->
                        <div id="confirmationMessage" class="alert alert-success text-center d-none" role="alert">
                            <h5 class="alert-heading">Terima kasih!</h5>
                            <p class="mb-0">Kehadiran Anda telah berhasil dikonfirmasi. Kami nantikan kehadiran Anda.</p>
                        </div>

                        <div class="d-grid">
                          @if($data_query->sign_ready && $data_query->sign_present)
                            <button class="btn btn-success btn-lg fw-bold py-3">
                              <i class="ti ti-circle-check me-2"></i> Sudah Konfirmasi
                            </button>
                          @elseif(!$data_query->sign_ready && !$data_query->sign_present)
                            <button id="confirmButton" class="btn btn-info btn-lg fw-bold py-3" onclick="confirmAttendance()">
                              <i class="ti ti-circle-check me-2"></i> Saya Hadir
                            </button>
                          @else
                            <button class="btn btn-warning btn-lg fw-bold py-3" disabled>
                              <i class="ti ti-circle-check me-2"></i> Data tidak ditemukan
                            </button>
                          @endif
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function confirmAttendance() {
    // Simple attendance confirm: POST token + CSRF to attendanceForm route
    var token = "{{ $data_query->token ?? request('token') }}";
    var url = "/participant-attendance/" + token;
    var csrf = $('meta[name="csrf-token"]').attr('content') || "{{ csrf_token() }}";

    // UI feedback
    $('#confirmButton').attr('disabled', true).text('Processing...');

    $.ajax({
      url: url,
      type: 'POST',
      data: {
        _token: csrf,
        token: token // attendanceForm currently reads token from request('token')
      },
      success: function (response) {
        if (response.status) {
          // show confirmation area and disable the button
          $('#confirmationMessage').removeClass('d-none');
          $('#confirmButton').remove();
          // update badge if present
          $('.badge').removeClass('text-bg-warning').addClass('text-bg-success').text('Sudah Konfirmasi');
        } else {
          $('#confirmButton').removeAttr('disabled').html('<i class="ti ti-circle-check me-2"></i> Saya Hadir');
          Swal.fire('Gagal', response.message || 'Gagal memproses konfirmasi', 'error');
        }
      },
      error: function (xhr) {
        $('#confirmButton').removeAttr('disabled').html('<i class="ti ti-circle-check me-2"></i> Saya Hadir');
        var msg = 'Terjadi kesalahan. Silakan coba lagi.';
        if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
        Swal.fire('Gagal', msg, 'error');
      }
    });
  }
</script>
@endsection
