<?php
$transformedTrainings = [];

foreach ($trainings as $training) {
    // Hitung durasi dalam jam
    $start = \Carbon\Carbon::parse($training['header']['start_date']);
    $end = \Carbon\Carbon::parse($training['header']['end_date']);
    $durasi = $start->diffInHours($end) . ' Jam';

    // Tentukan minggu mana yang aktif berdasarkan start_date
    $weekNumber = \Carbon\Carbon::parse($training['header']['start_date'])->weekOfMonth;
    $month = strtolower(\Carbon\Carbon::parse($training['header']['start_date'])->format('M'));
    
    $schedule = [
        'jan' => [], 'feb' => [], 'mar' => [], 'apr' => [], 
        'may' => [], 'jun' => [], 'jul' => [], 'aug' => [], 
        'sep' => [], 'oct' => [], 'nov' => [], 'dec' => []
    ];
    
    // Set minggu yang aktif
    $schedule[$month] = [$weekNumber];

    $transformedTrainings[] = [
        'nama' => $training['header']['workshop_name'],
        'durasi' => $durasi,
        'instruktur' => ucfirst($training['header']['instructor']),
        'personil' => count($training['participants']) . ' Personil',
        'jabatan' => $training['header']['position'],
        'schedule' => $schedule
    ];
}

// Tambahkan baris kosong jika jumlah data kurang dari 10
while (count($transformedTrainings) < 10) {
    $transformedTrainings[] = [
        'nama' => '',
        'durasi' => '',
        'instruktur' => '',
        'personil' => '',
        'jabatan' => '',
        'schedule' => array_fill_keys(['jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'], [])
    ];
}

$trainings = $transformedTrainings;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rencana Usulan Pelatihan</title>
    <link rel="icon" href=" {{ config('idev.app_favicon', asset('easyadmin/idev/img/favicon.png')) }}">
    <style>
        body {
            font-size: 7px;
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
            padding-bottom: 40px;
            border: 1px solid black;
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
            /* border: 1px solid salmon; */
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
        font-size: 7px;
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

    .highlight {
        background-color: gray; /* Warna kuning */
    }
    </style>
</head>
<body>
    <div class="letterhead">
            <img src="{{ asset('easyadmin/idev/img/kop-dokumen.png') }}" alt="PT Sampharindo">
            <h3>RENCANA USULAN PELATIHAN</h3>
    </div>
    <div class="info-section">
        <span style="float:left;font-size:7px;">Divisi / Bagian / Unit Kerja :  {{ $created->user->divisi }}</span>
        <span style="float:right;font-size:7px;">Periode {{ $year->training->year }}</span>
    </div>
    <br>

    <table>
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Jenis Pelatihan</th>
                    <th rowspan="2">Waktu /<br> Durasi</th>
                    <th rowspan="2">Instruktur</th>
                    <th rowspan="2">Personil</th>
                    <th rowspan="2">Jabatan</th>
                    <th colspan="4">Jan</th>
                    <th colspan="4">Feb</th>
                    <th colspan="4">Mar</th>
                    <th colspan="4">Apr</th>
                    <th colspan="4">May</th>
                    <th colspan="4">Jun</th>
                    <th colspan="4">Jul</th>
                    <th colspan="4">Aug</th>
                    <th colspan="4">Sept</th>
                    <th colspan="4">Oct</th>
                    <th colspan="4">Nov</th>
                    <th colspan="4">Dec</th>
                </tr>
                <tr>
                    <?php
                        for ($i = 0; $i < 12; $i++) {
                            for ($j = 1; $j <= 4; $j++) {
                                echo "<th>" . $j . "</th>"; // Output angka 1 hingga 4
                            }
                        }    
                    ?>  
                </tr>
            </thead>
            
            <tbody>
                @foreach($trainings as $key => $training)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-start">{{ $training['nama'] }}</td>
                        <td>{{ $training['durasi'] }}</td>
                        <td>{{ $training['instruktur'] }}</td>
                        <td>{{ $training['personil'] }}</td>
                        <td>{{ $training['jabatan'] }}</td>

                        @foreach(['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'] as $month)
                            @for($week = 1; $week <= 4; $week++)
                                <td class="{{ in_array($week, $training['schedule'][$month]) ? 'highlight' : '' }}"></td>
                            @endfor
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
<br><br>
    <table class="no-border" style="width:100%;">
        <tr>
            <td class="no-border text-center"style="width:20%;">
                Disiapkan Oleh,
                <br><br>
                @if($created->status === 'approve')
                <img src="{{ asset('storage/signature/' . $created->user->signature) }}" alt="Signature" width="100">
                <br>
                <u><strong>{{ $created->user->name ?? '-' }}</strong></u>
                <br>
                <span>Staff {{ $created->user->divisi ?? '-' }}</span>
                @elseif($created->status === 'submit')
                <img src="{{ asset('storage/signature/' . $created->user->signature) }}" alt="Signature" width="100">
                <br>
                <u><strong>{{ $created->user->name ?? '-' }}</strong></u>
                <br>
                <span>Staff {{ $created->user->divisi ?? '-' }}</span>
                @else
                <div style="height: 50px"></div>
                <u><strong>{{ $created->user->name ?? '-' }}</strong></u>
                <br>
                <span>Staff {{ $created->user->divisi ?? '-' }}</span>
                @endif
            </td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border text-center"style="width:20%;">
                Disetujui Oleh,
                <br><br>
                @if($created->status === 'approve')
                <img src="{{ asset('storage/signature/' . $created->approver->signature) }}" alt="Signature" width="100">
                <br>
                <u><strong>{{ $created->approver->name ?? '-' }}</strong></u>
                <br>
                <span>Manager {{ $created->approver->divisi ?? '-' }}</span>
                @else
                <div style="height: 50px"></div>
                <em>Data belum disiapkan</em>
                @endif
            </td>
        </tr>
    </table>
    <p style="text-align: right">F.DUP.04.R.00.T.01.07.17</p>
</body>
</html>