<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Kehadiran Pelatihan</title>
    <!-- Bootstrap 5 CSS --><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('easyadmin/theme/default/fonts/tabler-icons.min.css')}}" />
    <!-- Google Fonts --><link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F0F7F8; /* Light blue-gray background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .qrcode-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .attendance-card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .attendance-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 10px;
            background-color: #0891B2; /* Cyan top border */
        }
        .brand-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
        }
        .brand-logo {
            height: 40px; /* Adjust as needed */
            margin-right: 10px;
        }
        .qr-code-section {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 25px;
            border: 1px dashed #dee2e6;
        }
        .qr-code-img {
            max-width: 180px; /* Adjust QR code size */
            height: auto;
            border: 5px solid #ffffff; /* White border for QR */
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .info-item {
            display: flex;
            align-items: flex-start;
            text-align: left;
            margin-bottom: 12px;
        }
        .info-item .icon {
            font-size: 1.5rem;
            color: #0891B2; /* Cyan icon */
            margin-right: 15px;
            flex-shrink: 0;
            margin-top: 3px;
        }
    </style>
</head>
<body>
    <div class="attendance-card">

        <h3 class="fw-bold text-dark mb-2">Kartu Kehadiran Pelatihan</h3>
        <p class="text-muted mb-4">Silakan pindai kode QR ini untuk mencatat kehadiran Anda pada sesi pelatihan.</p>

        <hr class="my-4">

        <div class="qr-code-section">
            <p class="mb-3 text-muted">Arahkan kamera Anda ke kode di bawah ini:</p>
            <div class="qrcode-center">
                {!! DNS2D::getBarcodeHTML($data, 'QRCODE') !!}
            </div>
            <p class="mt-3 fw-bold text-primary">Scan untuk Kehadiran!</p>
        </div>
        
        <p class="text-muted small mt-4 mb-0">Pastikan Anda telah masuk ke sistem sebelum memindai.</p>
    </div>

</body>
</html>
