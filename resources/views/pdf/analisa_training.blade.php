@php
function addLineBreaks($text) 
{
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
@endphp

@foreach($analystHeader as $item)
    @php
        $qualification = json_decode($item->qualification, true);
        $general = json_decode($item->general, true);
        $technical = json_decode($item->technic, true);
    @endphp
@endforeach

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
        height: 100px;
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
        <span style="float:left;font-size:6px;">Divisi / Bagian / Unit Kerja :  {{ $created->user->divisi }}</span>
        <span style="float:right;font-size:6px;">Periode {{ $year->training->year }}</span>
    </div>
    <br>
    <table>
        <thead>
            <tr>
                <th rowspan="3" style="width: 15px">No</th>
                <th rowspan="3">Jabatan</th>
                <th rowspan="3" style="width: 30px;">Jumlah Personil</th>
                <th colspan="<?= count($qualification) + count($general) + count($technical) ?>">Jenis Pelatihan</th>
            </tr>
            <tr>
                <th colspan="<?= count($qualification) ?>" class="text-center">Qualification</th>
                <th colspan="<?= count($general) ?>" class="text-center">Pelatihan Umum</th>
                <th colspan="<?= count($technical) ?>" class="text-center">Pelatihan Khusus & Tambahan</th>
            </tr>
            <tr>
                @foreach($analystHeader as $item)
                    @php
                        $qualification = json_decode($item->qualification, true);
                        $general = json_decode($item->general, true);
                        $technical = json_decode($item->technic, true);
                    @endphp
                    @foreach($qualification as $key )
                        <th class="th"><span class="rotate-text"><?= addLineBreaks($key); ?></span></th>
                    @endforeach
                    @foreach($general as $key )
                        <th class="th"><span class="rotate-text"><?= addLineBreaks($key); ?></span></th>
                    @endforeach
                    @foreach($technical as $key )
                        <th class="th"><span class="rotate-text"><?= addLineBreaks($key); ?></span></th>
                    @endforeach
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($analystBody as $item)
                @php
                    $qualification = json_decode($item->qualification, true);
                    $general = json_decode($item->general, true);
                    $technical = json_decode($item->technic, true);
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-start">{{ $item->position }}</td>
                    <td>{{ $item->personil }}</td>

                    {{-- Qualifications --}}
                    @foreach($qualification as $qual)
                        <td class="text-center" style="font-size: 9px">{!! $qual === "true" ? '&#10003;' : '' !!}</td>
                    @endforeach
                                                                        
                    {{-- Qualifications --}}
                    @foreach($general as $gen)
                        <td class="text-center" style="font-size: 9px">{!! $gen === "true" ? '&#10003;' : '' !!}</td>
                    @endforeach

                    {{-- Qualifications --}}
                    @foreach($technical as $tech)
                        <td class="text-center" style="font-size: 9px">{!! $tech === "true" ? '&#10003;' : '' !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <p><i>Catatan: berilah tanda &#10003; pada kolom yang sesuai</i></p>
    <br>

    <table class="no-border" style="width:100%;">
        <tr>
            <td class="no-border text-center"style="width:20%;">
                Disiapkan Oleh,<br><br>
                @if($created->status === 'approve')
                <img src="{{ asset('easyadmin/idev/img/ttd.png') }}" alt="tanda tangan" width="100">
                <br>
                <strong>{{ $created->user->name ?? '-' }}</strong>
                @elseif($created->status === 'submit')
                <img src="{{ asset('easyadmin/idev/img/ttd.png') }}" alt="tanda tangan" width="100">
                <br>
                <strong>{{ $created->user->name ?? '-' }}</strong>
                @else
                <div style="height: 50px"></div>
                <strong>{{ $created->user->name ?? '-' }}</strong>
                @endif
            </td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border" style="width:20%;"></td>
            <td class="no-border text-center"style="width:20%;">
                Disetujui Oleh,<br><br>
                @if($created->status === 'approve')
                <img src="{{ asset('easyadmin/idev/img/ttd.png') }}" alt="tanda tangan" width="100">
                <br>
                <strong>{{ $created->approver->name ?? '-' }}</strong>
                @else
                <div style="height: 50px"></div>
                <em>Data belum disiapkan</em>
                @endif
            </td>
        </tr>
    </table>
    <p style="text-align: right">F.DUP.34.R.00.T.01.07.10</p>
</body>
</html>