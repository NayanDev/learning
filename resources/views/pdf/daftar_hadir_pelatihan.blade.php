<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Hadir Pelatihan</title>
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
            font-weight: bold
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
            <table class="no-border" style="width:100%;">
                <tr>
                    <td class="text-start" width="25%">Nomor</td>
                    <td width="5%">:</td>
                    <td class="text-start">108/SP/DUP/IV/2023</td>
                </tr>
                <tr>
                    <td class="text-start">Hari / Tgl</td>
                    <td width="5%">:</td>
                    <td class="text-start">Rabu, 12 April 2023 <span>Jam : 15.30 WIB - Selesai</span></td>
                </tr>
                <tr>
                    <td class="text-start">Tempat</td>
                    <td width="5%">:</td>
                    <td class="text-start">R. Meeting lt.2 PT.Sampharindo Perdana</td>
                </tr>
                <tr>
                    <td class="text-start" style="vertical-align: top">Pembicara</td>
                    <td width="5%" style="vertical-align: top">:</td>
                    <td class="text-start">
                        1. Cahyanti Fitri Hafidha <br>
                        2. Rizal Roffada Hanif
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <p>Pokok Bahasan: Pelatihan Creativity in Time of VUCA</p>

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
                <tr>
                    <td>1</td>    
                    <td class="text-start">Nayantaka</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: left">1.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>2</td>    
                    <td class="text-start">Nayy</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: center">2.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>1</td>    
                    <td class="text-start">Nayantaka</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: left">1.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>2</td>    
                    <td class="text-start">Nayy</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: center">2.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>1</td>    
                    <td class="text-start">Nayantaka</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: left">1.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>2</td>    
                    <td class="text-start">Nayy</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: center">2.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>1</td>    
                    <td class="text-start">Nayantaka</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: left">1.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>2</td>    
                    <td class="text-start">Nayy</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: center">2.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>1</td>    
                    <td class="text-start">Nayantaka</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: left">1.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>2</td>    
                    <td class="text-start">Nayy</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: center">2.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>1</td>    
                    <td class="text-start">Nayantaka</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: left">1.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>2</td>    
                    <td class="text-start">Nayy</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: center">2.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>1</td>    
                    <td class="text-start">Nayantaka</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: left">1.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>2</td>    
                    <td class="text-start">Nayy</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: center">2.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>1</td>    
                    <td class="text-start">Nayantaka</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: left">1.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>2</td>    
                    <td class="text-start">Nayy</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: center">2.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>1</td>    
                    <td class="text-start">Nayantaka</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: left">1.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>2</td>    
                    <td class="text-start">Nayy</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: center">2.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>1</td>    
                    <td class="text-start">Nayantaka</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: left">1.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>2</td>    
                    <td class="text-start">Nayy</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: center">2.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>1</td>    
                    <td class="text-start">Nayantaka</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: left">1.</td>    
                    <td></td>    
                </tr>
                <tr>
                    <td>2</td>    
                    <td class="text-start">Nayy</td>    
                    <td>Umum & SDM</td>    
                    <td style="text-align: center">2.</td>    
                    <td></td>    
                </tr>                                
            </tbody>
        </table>
    <br>
    <table class="no-border" style="width:100%;">
        {{-- <tr>
            <td class="no-border text-center"style="width:20%;">
                Semarang, {{ $created->created_date ? \Carbon\Carbon::parse($created->created_date)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
                <br>
                Dibuat Oleh,
                <br><br>
                @if($created->status === 'close')
                <img src="{{ asset('storage/signature/' . $created->approver->signature) }}" alt="Signature" width="100">
                <br>
                <u><strong>{{ $created->approver->name ?? '-' }}</strong></u>
                <br>
                <span>Manager {{ ucwords(strtolower($created->approver->divisi)) ?? '-' }}</span>
                @elseif($created->status === 'submit')
                <img src="{{ asset('storage/signature/' . $created->approver->signature) }}" alt="Signature" width="100">
                <br>
                <u><strong>{{ $created->approver->name ?? '-' }}</strong></u>
                <br>
                <span>Manager {{ ucwords(strtolower($created->approver->divisi)) ?? '-' }}</span>
                @else
                <div style="height: 50px"></div>
                <u><strong>{{ $created->approver->name ?? '-' }}</strong></u>
                <br>
                <span>Manager {{ ucwords(strtolower($created->approver->divisi)) ?? '-' }}</span>
                @endif
            </td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border text-center"style="width:20%;">
                Mengetahui,
                <br><br>
                @if($created->status === 'close')
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
        </tr> --}}
    </table>
    <p style="text-align: right">F.DUP.05.R.00.T.090217</p>
</body>
</html>