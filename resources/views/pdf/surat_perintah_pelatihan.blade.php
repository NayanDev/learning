<?php
    $letterNumb = $event->letter_number ?? '-';
    $workshop = ucwords(strtolower($event->workshop->name ?? '-'));
    $divisi = ucwords(strtolower($event->divisi ?? '-'));
    $location = ucwords(strtolower($event->location ?? '-'));
    $day = \Carbon\Carbon::parse($event->start_date)->isoFormat('dddd');
    $date = \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') ?? '-';;
    $clock = \Carbon\Carbon::parse($event->start_date)->format('H:i') ?? '-';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Perintah Pelatihan</title>
    <link rel="icon" href=" {{ config('idev.app_favicon', asset('easyadmin/idev/img/favicon.png')) }}">
    <style>
        body {
            font-size: 10px;
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
            padding-top: 22px;
            padding-left: 10px;
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
            font-size: 10px;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
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

        .highlight {
            background-color: gray; /* Warna kuning */
        }
    </style>
</head>
<body>
    <div class="letterhead">
            <img src="{{ asset('easyadmin/idev/img/kop-dokumen.png') }}" alt="PT Sampharindo">
            <h3  style="border: 1px solid black;padding:25px 10px 25px 25px;">SURAT PERINTAH PELATIHAN</h3>
        </div>
        <div class="info-section">
            <table class="no-border" style="width:40%;">
                <tr>
                    <td class="text-start no-border">No.</td>
                    <td width="5%" class="no-border">:</td>
                    <td class="text-start no-border">{{ $letterNumb }}</td>
                </tr>
                <tr>
                    <td class="text-start no-border">Perihal</td>
                    <td width="5%" class="no-border">:</td>
                    <td class="text-start no-border">Perintah Pelatihan</td>
                </tr>
            </table>
        </div>
    <p>Berdasarkan Usulan Divisi "{{ $divisi }}", maka kami menugaskan nama tersebut dibawah ini:</p>

        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Nama</th>
                    <th  width="20%">Divisi / Bagian</th>
                    <th>Tanda Tangan</th>
                    <th width="20%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participant->participants as $participant)
                    @if($loop->iteration % 2 === 0)
                        <tr>
                            <td>{{ $loop->iteration }}</td>    
                            <td class="text-start">{{ $participant->name }}</td>    
                            <td>{{ $participant->divisi }}</td>    
                            <td style="text-align: center;position: relative;">{{ $loop->iteration }}.<img src="{{ asset('storage/signature/' . $participant->signready?->signature) }}" style="position: absolute;top:0;left:70;" alt=" " width="100"></td>    
                            <td></td>    
                        </tr>
                    @else
                        <tr>
                            <td>{{ $loop->iteration }}</td>    
                            <td class="text-start">{{ $participant->name }}</td>    
                            <td>{{ $participant->divisi }}</td>    
                            <td style="text-align: left;position: relative;">{{ $loop->iteration }}.<img src="{{ asset('storage/signature/' . $participant->signready?->signature) }}" style="position: absolute;top:0;left:0;" alt=" " width="100"></td>    
                            <td></td>    
                        </tr>  
                    @endif
                @endforeach               
            </tbody>
        </table>
        <p>
            Untuk mengikuti "{{ $workshop }}" pada hari {{ $day }}, {{ $date }}, Pukul {{ $clock }} WIB - Selesai, bertempat di {{ $location }} <br>
            Demikian Surat Perintah Pelatihan ini dibuat agar dilaksanakan dengan penuh tanggung jawab. Atas perhatiannya kami ucapkan terima kasih.
        </p>
    <br>
    <table class="no-border" style="width:100%;">
        <tr>
            <td class="no-border text-center"style="width:25%;">
                Semarang, {{ $participant->created_date ? \Carbon\Carbon::parse($participant->created_date)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
                <br>
                Dibuat Oleh,
                <br><br>
                @if($event->status === 'approve')
                <img src="{{ asset('storage/signature/' . $event->approver->signature) }}" alt="Signature" width="100">
                <br>
                <u><strong>{{ $event->approver->name ?? '-' }}</strong></u>
                <br>
                <span>Manager {{ ucwords(strtolower(optional($event->approver)->divisi ?? '-')) }}</span>
                @elseif($event->status === 'submit')
                <img src="{{ asset('storage/signature/' . $event->approver->signature) }}" alt="Signature" width="100">
                <br>
                <u><strong>{{ $event->approver->name ?? '-' }}</strong></u>
                <br>
                <span>Manager {{ ucwords(strtolower(optional($event->approver)->divisi ?? '-')) }}</span>
                @else
                <div style="height: 50px"></div>
                <u><strong>{{ $event->approver->name ?? '-' }}</strong></u>
                <br>
                <span>Manager {{ ucwords(strtolower(optional($event->approver)->divisi ?? '-')) }}</span>
                @endif
            </td>
            <td class="no-border" style="width:25%;"></td>
            <td class="no-border" style="width:25%;"></td>
            <td class="no-border text-center"style="width:25%;">
                Mengetahui,
                <br><br>
                @if($event->status === 'approve')
                <img src="{{ asset('img/direktur.svg') ?? 'tanda tangan belum diset' }}" alt="Signature" width="100">
                <br>
                <u><strong>MAKMURI YUSIN</strong></u>
                <br>
                <span>Direktur Umum & SDM</span>
                @else
                <div style="height: 50px"></div>
                <em>Data belum tersedia</em>
                @endif
            </td>
        </tr>
    </table>
    <p style="text-align: right">F.DUP.05.R.00.T.090217</p>
</body>
</html>