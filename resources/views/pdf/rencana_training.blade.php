<?php
$trainings = [
    [
        'nama' => 'Warehouse in Pharmaceutical Industry',
        'durasi' => '2 Jam',
        'instruktur' => 'Internal',
        'personil' => '27 Personil', 
        'jabatan' => 'SCM',
        'schedule' => [
            'jan' => [1,2,3,4], // minggu yang di-highlight
            'feb' => [],
            'mar' => [],
            'apr' => [],
            'may' => [],
            'jun' => [],
            'jul' => [],
            'aug' => [],
            'sep' => [],
            'oct' => [],
            'nov' => [],
            'dec' => []
        ]
    ],
    [
        'nama' => 'Leadership',
        'durasi' => '2 Jam',
        'instruktur' => 'Eksternal',
        'personil' => '7 Personil',
        'jabatan' => 'SCM',
        'schedule' => [
            'jan' => [],
            'feb' => [1,2],
            'mar' => [],
            'apr' => [],
            'may' => [],
            'jun' => [],
            'jul' => [],
            'aug' => [],
            'sep' => [],
            'oct' => [],
            'nov' => [],
            'dec' => [2]
        ]
],
[
        'nama' => '',
        'durasi' => '',
        'instruktur' => '',
        'personil' => '',
        'jabatan' => '',
        'schedule' => [
            'jan' => [],
            'feb' => [],
            'mar' => [],
            'apr' => [],
            'may' => [],
            'jun' => [],
            'jul' => [],
            'aug' => [],
            'sep' => [],
            'oct' => [],
            'nov' => [],
            'dec' => []
        ]
],
[
        'nama' => '',
        'durasi' => '',
        'instruktur' => '',
        'personil' => '',
        'jabatan' => '',
        'schedule' => [
            'jan' => [],
            'feb' => [],
            'mar' => [],
            'apr' => [],
            'may' => [],
            'jun' => [],
            'jul' => [],
            'aug' => [],
            'sep' => [],
            'oct' => [],
            'nov' => [],
            'dec' => []
        ]
],
[
        'nama' => '',
        'durasi' => '',
        'instruktur' => '',
        'personil' => '',
        'jabatan' => '',
        'schedule' => [
            'jan' => [],
            'feb' => [],
            'mar' => [],
            'apr' => [],
            'may' => [],
            'jun' => [],
            'jul' => [],
            'aug' => [],
            'sep' => [],
            'oct' => [],
            'nov' => [],
            'dec' => []
        ]
],
[
        'nama' => '',
        'durasi' => '',
        'instruktur' => '',
        'personil' => '',
        'jabatan' => '',
        'schedule' => [
            'jan' => [],
            'feb' => [],
            'mar' => [],
            'apr' => [],
            'may' => [],
            'jun' => [],
            'jul' => [],
            'aug' => [],
            'sep' => [],
            'oct' => [],
            'nov' => [],
            'dec' => []
        ]
],
[
        'nama' => '',
        'durasi' => '',
        'instruktur' => '',
        'personil' => '',
        'jabatan' => '',
        'schedule' => [
            'jan' => [],
            'feb' => [],
            'mar' => [],
            'apr' => [],
            'may' => [],
            'jun' => [],
            'jul' => [],
            'aug' => [],
            'sep' => [],
            'oct' => [],
            'nov' => [],
            'dec' => []
        ]
],
];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rencana Usulan Pelatihan</title>
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
        <br><br>
        <span style="float:left;font-size:7px;">Divisi / Bagian / Unit Kerja :  Produksi</span>
        <span style="float:right;font-size:7px;">Periode 2025</span>
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
                <img width="75" src="{{ asset('easyadmin/idev/img/ttd.png') }}" alt="Tanda Tangan">
                <br>
                <strong>Anto Wardana</strong>
            </td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border text-center"style="width:20%;">
                Disetujui Oleh,
                <br><br>
                <img width="75" src="{{ asset('easyadmin/idev/img/ttd.png') }}" alt="Tanda Tangan">
                <br>
                <strong>Ramadhan Reza Akbar</strong>
            </td>
        </tr>
    </table>
    <p style="text-align: right">F.DUP.10.R.00.T.01.07.17</p>
</body>
</html>