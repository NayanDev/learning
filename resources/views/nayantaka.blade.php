@extends("easyadmin::backend.parent")
@section("content")
@push('mtitle')
{{$title}}
@endpush
<div class="pc-container">
  <div class="pc-content">
    <div class="row">

        <div class="col-12">
            
            <section id="page-course-detail">
                <div class="row g-4">
                    <!-- Konten Video (Kiri) -->
                    <div class="col-lg-8">
                        <div class="card course-card">
                            <div class="video-wrapper">
                                <!-- Placeholder Video YouTube -->
                                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                            <div class="card-body p-4">
                                <h3 class="fw-bold mb-3">Modul 1.1: Apa itu K3?</h3>
                                <p class="text-muted">Instruktur: Bapak Budi Hartono</p>
                                <hr>
                                <h5 class="fw-bold">Deskripsi Modul</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
                                    Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet.
                                    Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kurikulum (Kanan) -->
                    <div class="col-lg-4">
                        <div class="card course-card">
                            <div class="card-header bg-white border-0">
                                <h5 class="fw-bold mb-0">List Participant</h5>
                            </div>
                            <div class="card-body p-4">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td width="5%">No</td>
                                            <td>Name</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>NAYANTAKA</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card course-card">
                            <div class="card-header bg-white border-0 pt-3">
                                <h5 class="fw-bold mb-0">Kurikulum Kursus</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="accordion" id="accordionKurikulum">

                                    <!-- Modul 1 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button fw-bold collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                                Modul 1: Pre-Test
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse show"
                                            aria-labelledby="headingThree" data-bs-parent="#accordionKurikulum">
                                            <div class="accordion-body curriculum-list">
                                                <ul class="list-group list-group-flush">
                                                    <!-- ====== LINK DIPERBARUI ====== -->
                                                    <a href="#" class="list-group-item list-group-item-action"
                                                        onclick="showPage('page-test-lobby')"><i
                                                            class="ti ti-pencil"></i> Pre-Test (Wajib)</a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                aria-expanded="true" aria-controls="collapseOne">
                                                Modul 2: Pengenalan K3
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionKurikulum">
                                            <div class="accordion-body curriculum-list">
                                                <ul class="list-group list-group-flush">
                                                    <a href="#" class="list-group-item list-group-item-action"><i
                                                            class="ti ti-file-text"></i> Landasan Hukum K3 (Bacaan)</a>
                                                    <a href="#" class="list-group-item list-group-item-action"><i
                                                            class="ti ti-player-play"></i> Mengapa K3 Penting?
                                                        (08:15)</a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ... modul 2 & 3 ... -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button fw-bold collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                Modul 3: Implementasi di Lapangan
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="headingTwo" data-bs-parent="#accordionKurikulum">
                                            <div class="accordion-body curriculum-list">
                                                <ul class="list-group list-group-flush">
                                                    <a href="#" class="list-group-item list-group-item-action"><i
                                                            class="ti ti-player-play"></i> Identifikasi Bahaya
                                                        (12:00)</a>
                                                    <a href="#" class="list-group-item list-group-item-action"><i
                                                            class="ti ti-file-text"></i> Studi Kasus (Bacaan)</a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button fw-bold collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                                Modul 4: Post-Test
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse"
                                            aria-labelledby="headingThree" data-bs-parent="#accordionKurikulum">
                                            <div class="accordion-body curriculum-list">
                                                <ul class="list-group list-group-flush">
                                                    <!-- ====== LINK DIPERBARUI ====== -->
                                                    <a href="#" class="list-group-item list-group-item-action"
                                                        onclick="showPage('page-test-lobby')"><i
                                                            class="ti ti-pencil"></i> Post-Test (Final)</a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="page-test-lobby" class="d-none">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h3 fw-bold">Instruksi Pre-Test</h2>
                        <p class="text-muted mb-0">Pelatihan: <strong class="text-dark">Pre-Test: K3
                                Fundamental</strong></p>
                    </div>
                    <button class="btn btn-outline-secondary" onclick="showPage('page-course-detail')">
                        <i class="ti ti-arrow-left me-1"></i>
                        Kembali ke Modul
                    </button>
                </div>

                <!-- Kartu Instruksi -->
                <div class="card course-card">
                    <div class="row g-0">
                        <div class="col-md-4 d-none d-md-flex align-items-center justify-content-center"
                            style="background-color: #E6F4F1; border-top-left-radius: 0.75rem; border-bottom-left-radius: 0.75rem;">
                            <i class="ti ti-checklist text-primary" style="font-size: 8rem; opacity: 0.8;"></i>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-5">
                                <h3 class="fw-bold">Anda akan memulai tes</h3>
                                <p class="text-muted">Harap baca instruksi berikut dengan saksama sebelum memulai.</p>

                                <ul class="list-group list-group-flush my-4">
                                    <li class="list-group-item d-flex align-items-center border-0 px-0">
                                        <i class="ti ti-list-check fs-2 text-primary me-3"></i>
                                        <div>
                                            <strong class_alias="d-block">Jumlah Soal</strong>
                                            <span>20 Soal Pilihan Ganda</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center border-0 px-0">
                                        <i class="ti ti-clock fs-2 text-primary me-3"></i>
                                        <div>
                                            <strong class_alias="d-block">Durasi</strong>
                                            <span>30 Menit</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center border-0 px-0">
                                        <i class="ti ti-target-arrow fs-2 text-primary me-3"></i>
                                        <div>
                                            <strong class_alias="d-block">Nilai Kelulusan (Passing Score)</strong>
                                            <span>Skor minimal adalah 70</span>
                                        </div>
                                    </li>
                                </ul>

                                <div class="alert alert-warning d-flex" role="alert">
                                    <i class="ti ti-alert-triangle fs-3 me-3"></i>
                                    <div>
                                        <h6 class="fw-bold">Peringatan Penting!</h6>
                                        <ul class="mb-0 ps-3">
                                            <li>Tes ini hanya dapat diambil <strong>satu kali</strong>.</li>
                                            <li>Jangan <strong>me-refresh</strong> halaman selama tes berlangsung.</li>
                                            <li>Pastikan koneksi internet Anda stabil.</li>
                                        </ul>
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-lg w-100 mt-4"
                                    onclick="showPage('page-test-taking')">
                                    Mulai Tes Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
        </div>
        
    
        
    
    
    </div>
  </div>
</div>

<script>
    function confirmAttendance(token) {
  var url = "{{ route('participant.attendance.form.ready') }}";
  var csrf = $('meta[name="csrf-token"]').attr('content') || "{{ csrf_token() }}";

  // Tampilkan konfirmasi dulu
  Swal.fire({
    title: 'Konfirmasi Kehadiran',
    text: 'Apakah kamu yakin ingin mengonfirmasi kehadiran?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya, Saya Hadir',
    cancelButtonText: 'Batal',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      // Ubah UI tombol
      $('#confirmButton')
        .attr('disabled', true)
        .html('<i class="ti ti-loader ti-spin me-2"></i> Memproses...');

      // Kirim request AJAX
      $.ajax({
        url: url,
        type: 'POST',
        data: {
          _token: csrf,
          token: token
        },
        success: function (response) {
          if (response.status) {
            // Notifikasi sukses
            Swal.fire({
              title: 'Berhasil!',
              text: response.message || 'Kehadiran kamu berhasil dikonfirmasi.',
              icon: 'success',
              timer: 2000,
              showConfirmButton: false
            });

            // Update tampilan halaman
            $('#confirmationMessage').removeClass('d-none');
            $('#confirmButton').remove();
            $('.badge')
              .removeClass('text-bg-warning')
              .addClass('text-bg-success')
              .text('Sudah Konfirmasi');
          } else {
            // Gagal dari server
            $('#confirmButton').removeAttr('disabled')
              .html('<i class="ti ti-circle-check me-2"></i> Saya Hadir');

            Swal.fire('Gagal', response.message || 'Gagal memproses konfirmasi.', 'error');
          }
        },
        error: function (xhr) {
          $('#confirmButton').removeAttr('disabled')
            .html('<i class="ti ti-circle-check me-2"></i> Saya Hadir');

          var msg = 'Terjadi kesalahan. Silakan coba lagi.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            msg = xhr.responseJSON.message;
          }

          Swal.fire('Gagal', msg, 'error');
        }
      });
    } else {
      // Jika user menekan "Batal"
      Swal.fire({
        title: 'Dibatalkan',
        text: 'Konfirmasi kehadiran dibatalkan.',
        icon: 'info',
        timer: 1500,
        showConfirmButton: false
      });
    }
  });
}

function showPage(pageId) {
            // Sembunyikan semua halaman
            contentPages.forEach(page => {
                page.classList.add('d-none');
            });

            // Tampilkan halaman yang ditargetkan
            const targetPage = document.getElementById(pageId);
            if (targetPage) {
                targetPage.classList.remove('d-none');
            }

            // Gulir ke atas halaman
            window.scrollTo(0, 0);

            // Atur status 'active' di sidebar
            sidebarLinks.forEach(link => {
                let linkPage = link.getAttribute('data-page');
                if (linkPage === pageId) {
                    link.classList.add('active');
                } else {
                    // Logika khusus untuk menjaga menu admin/kursus tetap aktif
                    if ((pageId === 'page-test-review') && linkPage === 'page-test-manager') {
                        link.classList.add('active'); // Jaga 'Pengelola Tes' aktif saat di 'review'
                    } else if (
                        (pageId === 'page-test-lobby' || pageId === 'page-test-taking' || pageId === 'page-test-result') &&
                        linkPage === 'page-course-detail'
                    ) {
                        link.classList.add('active'); // Jaga 'Halaman Kursus' aktif saat tes
                    }
                    else {
                        link.classList.remove('active');
                    }
                }
            });

            // Atur status 'active' pada tab (jika berpindah ke halaman dari dalam tab)
            if (pageId === 'page-test-manager' || pageId === 'page-test-review') {
                // Pastikan tab 'Hasil Peserta' aktif saat kembali
                const resultsTab = new bootstrap.Tab(document.getElementById('test-results-tab'));
                resultsTab.show();
            }
        }
</script>
@endsection
