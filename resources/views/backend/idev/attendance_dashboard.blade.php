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
        <!-- Kartu Pelatihan 1 (Contoh) -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title fw-bold text-dark mb-1">Pelatihan Keselamatan dan Kesehatan Kerja (K3) Fundamental</h5>
                                    <p class="card-subtitle text-muted">Instruktur: Bapak Budi Hartono</p>
                                </div>
                                <span class="badge bg-primary text-primary-emphasis rounded-pill fs-6">Akan Datang</span>
                            </div>

                            <div class="row g-3 my-3">
                                <div class="col-md-4 d-flex align-items-center">
                                    <i class="ti ti-calendar-event fs-4 text-secondary me-2"></i>
                                    <span class="fw-medium">25 Oktober 2025</span>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <i class="ti ti-clock fs-4 text-secondary me-2"></i>
                                    <span class="fw-medium">09:00 - 16:00 WIB</span>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <i class="ti ti-map-pin fs-4 text-secondary me-2"></i>
                                    <span class="fw-medium">Aula Serbaguna, Lt. 3</span>
                                </div>
                            </div>

                            <hr>

                            <div class="d-md-flex justify-content-between align-items-center">
                                <div class="mb-3 mb-md-0">
                                    <h6 class="fw-bold">Token Kehadiran Anda</h6>
                                    <p class="text-muted small mb-0">Gunakan token ini untuk presensi saat pelatihan dimulai.</p>
                                </div>
                                <div class="token-area d-flex align-items-center">
                                    <span class="token-code me-3">K3-XYZ-123</span>
                                    <button class="btn btn-outline-secondary btn-sm copy-token-btn" data-token="K3-XYZ-123" title="Salin Token">
                                        <i class="ti ti-copy me-1"></i> Salin
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kartu Pelatihan 2 (Contoh Selesai) -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title fw-bold text-dark mb-1">Advanced Product Management</h5>
                                    <p class="card-subtitle text-muted">Instruktur: Ibu Dian Sastro (External)</p>
                                </div>
                                <span class="badge bg-success text-success-emphasis rounded-pill fs-6">Selesai</span>
                            </div>

                             <div class="row g-3 my-3">
                                <div class="col-md-4 d-flex align-items-center">
                                    <i class="ti ti-calendar-event fs-4 text-secondary me-2"></i>
                                    <span class="fw-medium">15 September 2025</span>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <i class="ti ti-clock fs-4 text-secondary me-2"></i>
                                    <span class="fw-medium">09:00 - 15:00 WIB</span>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <i class="ti ti-map-pin fs-4 text-secondary me-2"></i>
                                    <span class="fw-medium">Ruang Meeting Cendana</span>
                                </div>
                            </div>

                            <hr>

                            <div class="d-md-flex justify-content-between align-items-center text-muted">
                                <h6 class="mb-0">Pelatihan ini telah selesai.</h6>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
  </div>
</div>
@endsection
