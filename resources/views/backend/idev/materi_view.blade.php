<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menampilkan PDF: Nama File Disini</title>
    
    <link rel="stylesheet" href="{{ asset('easyadmin/theme/'.config('idev.theme','default').'/css/style.css')}}" id="main-style-link" />
  <link rel="stylesheet" href="{{ asset('easyadmin/theme/'.config('idev.theme','default').'/css/style-preset.css')}}" id="preset-style-link" />
  <link href="{{ asset('easyadmin/idev/styles.css')}}" rel="stylesheet" />
  @foreach(config('idev.import_styles', []) as $item)
    <link href="{{ $item }}" rel="stylesheet" />
  @endforeach
    
    <!-- Tabler Icons CSS -->
    <link rel="stylesheet" href="{{ asset('easyadmin/theme/default/fonts/tabler-icons.min.css')}}" />

    <style>
        /* Mencegah double scrollbar dan mengatur layout dasar */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; 
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        /* Header yang tetap di atas */
        .pdf-header {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            height: 65px; /* Tinggi header yang pasti */
            flex-shrink: 0;
        }
        /* Kontainer untuk iframe agar mengisi sisa ruang */
        .pdf-viewer-container {
            height: calc(100vh - 65px); 
            width: 100%;
        }
        /* Iframe untuk menampilkan PDF */
        .pdf-viewer {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body class="d-flex flex-column">

    <!-- Header Halaman -->
    <header class="pdf-header d-flex align-items-center px-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- Informasi File -->
            <div class="d-flex align-items-center text-truncate">
                <i class="ti ti-file-text fs-2 text-danger"></i>
                <span class="fw-bold text-dark fs-5 text-truncate" title="materi_pelatihan_k3.pdf">
                    materi_pelatihan_k3.pdf
                </span>
            </div>

            <!-- Statistik Download & Lihat -->
            <div class="d-flex align-items-center gap-4">
                <div class="text-center">
                    <small class="text-muted d-block" style="font-size: 0.7rem;">DIBACA</small>
                    <div class="fw-bold fs-5">
                        <i class="ti ti-eye text-muted" style="vertical-align: middle;"></i>
                        <span style="vertical-align: middle;">25</span>
                    </div>
                </div>
                <div class="text-center">
                    <small class="text-muted d-block" style="font-size: 0.7rem;">DIDOWNLOAD</small>
                    <div class="fw-bold fs-5">
                        <i class="ti ti-download text-muted" style="vertical-align: middle;"></i>
                        <span style="vertical-align: middle;">15</span>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div>
                <button onclick="confirmDownload()" class="btn btn-outline-success">
                    <i class="ti ti-download me-1"></i>
                    Download
                </button>
                <button onclick="window.history.back()" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Kembali
                </button>
            </div>
        </div>
    </header>

    <div class="pdf-viewer-container">
        <iframe src="http://lms.test/storage/materi/file-example_PDF_1MB_1760940812.pdf" class="pdf-viewer" title="Menampilkan PDF"></iframe>
    </div>

    <script src="{{ asset('easyadmin/theme/default/js/plugins/sweet-alert.js')}}"></script>
    <script>
        function confirmDownload(fileName, fileUrl) {
            Swal.fire({
                title: 'Download File?',
                text: 'Apakah kamu ingin mendownload file ' + fileName + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Download',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Langsung download file
                    const link = document.createElement('a');
                    link.href = fileUrl;
                    link.download = fileName;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            });
        }
    </script>
</body>
</html>
