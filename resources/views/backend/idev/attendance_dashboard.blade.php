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
            <!-- Navigasi Tab -->
        <ul class="nav nav-tabs mb-4" id="trainingTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="warning-tab" data-bs-toggle="tab" data-bs-target="#warning-training" type="button" role="tab" aria-controls="warning-training" aria-selected="false">
                    Warning
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming-training" type="button" role="tab" aria-controls="upcoming-training" aria-selected="true">
                    Pelatihan Akan Datang
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed-training" type="button" role="tab" aria-controls="completed-training" aria-selected="false">
                    Riwayat Pelatihan Selesai
                </button>
            </li>
        </ul>
        </div>
        
        <!-- Konten Tab -->
    <div class="tab-content" id="trainingTabContent">
        <!-- ============================================== -->
        <!-- Panel 1: Warning (Aktif) -->
        <!-- ============================================== -->
        <div class="tab-pane fade show active" id="warning-training" role="tabpanel" aria-labelledby="warning-tab">
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="card">
                        @if(Auth::user()->signature == null || Auth::user()->signature == '')
                            <div class="card-body">
                                <h5 class="card-title">Peringatan: Update Tanda Tangan!</h5>
                                <b></b>
                                <p>
                                    1. masuk ke menu <b>account settings</b> dibagian kanan atas<br>
                                    2. scroll kebawah hingga menemukan bagian <b>signature</b><br>
                                    3. buat tanda tangan digital anda dengan mouse atau touchscreen<br>
                                    4. klik <b>save as svg</b> untuk menyimpan tanda tangan dalam format svg<br>
                                    4. (optional) jika anda sudah memiliki tanda tangan dalam format gambar (png/jpg), silahkan upload pada bagian <b>upload signature</b><br>
                                    5. klik <b>update profile</b> untuk menyimpan perubahan tanda tangan
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        
        <!-- ============================================== -->
        <!-- Panel 2: Pelatihan Akan Datang -->
        <!-- ============================================== -->
        <div class="tab-pane fade show" id="upcoming-training" role="tabpanel" aria-labelledby="upcoming-tab">
            <div class="row g-4">

                @foreach($eventsAttendance as $event)
                @if(!$event->in_ready)
                <div class="col-lg-6">
                    <div class="card">
                         <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">{{ $event->event->workshop->name ?? '-' }}</h5>
                                    <p class="card-subtitle text-muted">Instruktur: {{ $event->event->speaker ?? '-' }} ({{ $event->event->instructor }})</p>
                                </div>
                                <span class="badge bg-warning rounded-pill px-3 py-2 flex-shrink-0">Confirmation</span>
                            </div>

                            <hr class="my-3">

                            <div class="row g-3">
                                <div class="col-md-6 d-flex align-items-center">
                                    <i class="ti ti-calendar-event fs-4 text-muted me-2"></i>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($event->event->start_date)->translatedFormat('d F Y') ?? '-' }}</span>
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <i class="ti ti-clock fs-4 text-muted me-2"></i>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($event->event->start_date)->format('H:i') ?? '-' }} - {{ \Carbon\Carbon::parse($event->event->end_date)->format('H:i') ?? '-' }} WIB</span>
                                </div>
                                <div class="col-12 d-flex align-items-center">
                                    <i class="ti ti-map-pin fs-4 text-muted me-2"></i>
                                    <span class="fw-medium">{{ $event->event->location ?? '-' }}</span>
                                </div>
                            </div>

                            <hr class="my-3">

                            <div class="token-area d-flex justify-content-center align-items-center ">
                                <button class="btn btn-sm btn-info" onclick="confirmAttendance()">
                                    <i class="ti ti-check me-1"></i> Attendance
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach

            </div>
        </div>

        <!-- ============================================== -->
        <!-- Panel 3: Riwayat Pelatihan Selesai -->
        <!-- ============================================== -->
        <div class="tab-pane fade" id="completed-training" role="tabpanel" aria-labelledby="completed-tab">
            <div class="row g-4">

                <!-- Kartu 3: Pelatihan Selesai (Dari Desain Anda) -->
                @foreach($eventsAttendance as $event)
                @if($event->out_present)
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">{{ $event->event->workshop->name ?? '-' }}</h5>
                                    <p class="card-subtitle text-muted">Instruktur: {{ $event->event->speaker ?? '-' }} ({{ $event->event->instructor }})</p>
                                </div>
                                <span class="badge bg-success rounded-pill px-3 py-2 flex-shrink-0">Selesai</span>
                            </div>

                            <hr class="my-3">

                            <div class="row g-3">
                                <div class="col-md-6 d-flex align-items-center">
                                    <i class="ti ti-calendar-event fs-4 text-muted me-2"></i>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($event->event->start_date)->translatedFormat('d F Y') ?? '-' }}</span>
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <i class="ti ti-clock fs-4 text-muted me-2"></i>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($event->event->start_date)->format('H:i') ?? '-' }} - {{ \Carbon\Carbon::parse($event->event->end_date)->format('H:i') ?? '-' }} WIB</span>
                                </div>
                                <div class="col-12 d-flex align-items-center">
                                    <i class="ti ti-map-pin fs-4 text-muted me-2"></i>
                                    <span class="fw-medium">{{ $event->event->location ?? '-' }}</span>
                                </div>
                            </div>

                            <hr class="my-3">
                            <p class="text-muted text-center mb-0">Pelatihan ini telah selesai.</p>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach

            </div>
        </div>
    </div>


    
    </div>
  </div>
</div>

<script>
    function confirmAttendance() {
    // Simple attendance confirm: POST token + CSRF to attendanceForm route
    var url = "{{ route('participant.attendance.form.ready') }}";
    var csrf = $('meta[name="csrf-token"]').attr('content') || "{{ csrf_token() }}";

    // UI feedback
    $('#confirmButton').attr('disabled', true).text('Processing...');

    $.ajax({
      url: url,
      type: 'POST',
      data: {
        _token: csrf,
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
