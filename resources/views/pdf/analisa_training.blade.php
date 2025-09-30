<?php
$trainings = [
    [
        'no' => 1,
        'jabatan' => 'Manager SCM',
        'jumlah_personil' => 1,
        'Jenis Pelatihan' => [
                'Qualifications' => [
                    'SMA' => true,
                    'Bachelor' => true, 
                    'Sertifikasi APT' => true,
                    'Magister' => true,
                    'Doktoral' => true,
                    'Profesi' => true
                ],
                'Pelatihan Umum' => [
                    'Organisasi perusahaan' => true,
                    'CBOP Dasar' => true,
                    'Bahasa Inggris' => true,
                    'Bahasa Indonesia' => true
                ],
                'Pelatihan Khusus & Tambahan' => [
                    'Pelatihan Sistem' => true,
                    'Penguatan Motivasi' => true,
                    'Kepemimpinan' => true,
                    'Skill Khusus' => true,
                    'Job Description' => true,
                    'Programming' => true,
                ]
            ]
        
    ],
    [
        'no' => 2,
        'jabatan' => 'Manager SCM',
        'jumlah_personil' => 1,
        'Jenis Pelatihan' => [
                'Qualifications' => [
                    'SMA' => true,
                    'Bachelor' => true, 
                    'Sertifikasi APT' => true,
                    'Magister' => true,
                    'Doktoral' => true,
                    'Profesi' => true
                ],
                'Pelatihan Umum' => [
                    'Organisasi perusahaan' => true,
                    'CBOP Dasar' => true,
                    'Bahasa Inggris' => true,
                    'Bahasa Indonesia' => true
                ],
                'Pelatihan Khusus & Tambahan' => [
                    'Pelatihan Sistem' => true,
                    'Penguatan Motivasi' => true,
                    'Kepemimpinan' => true,
                    'Skill Khusus' => true,
                    'Job Description' => true,
                    'Programming' => true,
                ]
            ]
        
    ],
    [
        'no' => 3,
        'jabatan' => 'Manager SCM',
        'jumlah_personil' => 1,
        'Jenis Pelatihan' => [
                'Qualifications' => [
                    'SMA' => true,
                    'Bachelor' => true, 
                    'Sertifikasi APT' => true,
                    'Magister' => true,
                    'Doktoral' => true,
                    'Profesi' => true
                ],
                'Pelatihan Umum' => [
                    'Organisasi perusahaan',
                    'CBOP Dasar' => true,
                    'Bahasa Inggris' => true,
                    'Bahasa Indonesia' => true
                ],
                'Pelatihan Khusus & Tambahan' => [
                    'Pelatihan Sistem' => true,
                    'Penguatan Motivasi' => true,
                    'Kepemimpinan' => true,
                    'Skill Khusus' => true,
                    'Job Description' => true,
                    'Programming' => true,
                ]
            ]
        
    ],
];

// Calculate colspan
$totalCols = 0;
foreach ($trainings[0]['Jenis Pelatihan'] as $section => $items) {
    $totalCols += count($items);
}

function addLineBreaks($text) {
    $words = explode(' ', $text);
    $result = [];
    
    foreach ($words as $word) {
        if (strlen($word) > 9) {
            $result[] = $word . '<br>';
        } else {
            $result[] = $word;
        }
    }
    
    return implode(' ', $result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analisa Kebutuhan Pelatihan</title>
    <style>
        body {
            font-size: 6px;
            margin: 0;
            padding: 0;
            font-family: 'DejaVu Sans', sans-serif;
        }

        .text-start {
            text-align: left;
        }

        .letterhead {
            position: relative;
            margin-bottom: 10px;
            overflow: visible;
            padding-bottom: 10px;
            /* border: 2px solid black; */
        }

        .letterhead img {
            position: absolute;
            width: 40px;
            padding-top: 5px;
            padding-bottom: 5px;
            /* border: 1px solid green; */
        }

        .letterhead h3 {
            /* margin-top: 20px; */
            margin-bottom: 0;
            text-align: right;
            /* padding: 10px; */
            /* border: 1px solid red; */
            padding: 0px;
        }
        
        .letterhead p {
            text-align: right;
            margin-top: 0;
            margin-bottom: 20px;
            padding: 0px;
            /* border:1px solid blue; */
        }

        .info-section {
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        .no-border {
            border: none !important;
        }

    .th {
        border: 1px solid black;
        font-size: 6px;
        margin: 0;
        padding: 0;
        text-align: center;
        vertical-align: middle;
        height: 80px;
        width: 25px;
        position: relative; /* Tambahkan ini */
    }

    .rotate-text {
        position: absolute;    /* Posisi absolute agar bisa full */
        top: 50%;             /* Posisi vertical center */
        left: 50%;           /* Posisi horizontal center */
        transform: translate(-50%, -50%) rotate(-90deg); /* Gabung translate dan rotate */
        width: 80px;        /* Sesuaikan dengan height th */
        display: flex;       /* Gunakan flex untuk centering content */
        align-items: center;
        justify-content: center;
        text-align: center;
    }

            /* Style untuk elemen yang hanya akan tampil di layar */
    .hanya-tampil-di-layar {
    padding: 10px;
    background-color: #A6BE47;
    border: 1px solid #ccd;
    margin-bottom: 20px;
    }

    /* Aturan untuk menyembunyikan elemen saat dicetak/dibuat PDF */
    @media print {
    .hanya-tampil-di-layar {
            display: none !important;
        }
    }
    </style>
</head>
<body>
    <div class="letterhead">
        <img src="{{ asset('easyadmin/idev/img/kop-dokumen.png') }}" alt="PT Sampharindo">
        <h3>ANALISA KEBUTUHAN LATIHAN</h3>
        <p><em>Training Needs Analysis</em></p>
    </div>
    <div class="info-section">
        <span style="float:left;font-size:6px;">Divisi / Bagian / Unit Kerja :  Produksi</span>
        <span style="float:right;font-size:6px;">Periode 2025</span>
    </div>
    <br>
    <table>
        <thead>
        <tr>
            <th rowspan="3" style="width: 15px">No</th>
            <th rowspan="3">Jabatan</th>
            <th rowspan="3" style="width: 30px;">Jumlah Personil</th>
            <th colspan="<?php echo $totalCols ?>">Jenis Pelatihan</th>
        </tr>
        <tr>
            {{-- Tampilkan header hanya sekali --}}
        @foreach($trainings[0]['Jenis Pelatihan'] as $section => $items)
            <th colspan="{{ count($items) }}">{{ $section }}</th>
        @endforeach
        </tr>
        <tr>
            @foreach($trainings[0]['Jenis Pelatihan'] as $section => $items)
                @foreach($items as $item => $key)
                    <th class="th"><span class="rotate-text"><?= addLineBreaks($item); ?></span></th>
                @endforeach
            @endforeach
        </tr>
    </thead>
        <tbody>
    @foreach($trainings as $training)
    <tr>
        <td>{{ $training['no'] }}</td>
        <td class="text-start">{{ $training['jabatan'] }}</td>
        <td>{{ $training['jumlah_personil'] }}</td>
        
        {{-- Qualifications --}}
        @foreach($training['Jenis Pelatihan']['Qualifications'] as $qual)
            <td>{!! $qual ? '&#10003;' : '' !!}</td>
        @endforeach

        {{-- Pelatihan Umum --}}
        @foreach($training['Jenis Pelatihan']['Pelatihan Umum'] as $umum)
            <td>{!! $umum ? '&#10003;' : '' !!}</td>
        @endforeach

        {{-- Pelatihan Khusus --}}
        @foreach($training['Jenis Pelatihan']['Pelatihan Khusus & Tambahan'] as $khusus)
            <td>{!! $khusus ? '&#10003;' : '' !!}</td>
        @endforeach
    </tr>
    @endforeach
</tbody>
    </table>

    <br>
    <p><i>Catatan: berilah tanda &#10003; pada kolom yang sesuai</i></p>
    <br><br>

    <table class="no-border" style="width:100%;">
        <tr>
            <td class="no-border text-center"style="width:20%;">
                Disiapkan Oleh,<br><br><br><br>
                <strong>Anto Wardana</strong>
            </td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border text-center"style="width:20%;">
                Disetujui Oleh,<br><br><br><br>
                <strong>Ramadhan Reza Akbar</strong>
            </td>
        </tr>
    </table>
    <p style="text-align: right">F.DUP.34.R.00.T.01.07.10</p>
</body>
</html>