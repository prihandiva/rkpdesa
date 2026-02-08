<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Berita Acara</title>
    <style>
        @page {
            size: A4;
            margin: 2.5cm;
        }
        body {
            font-family: "Bookman Old Style", Georgia, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            background: #fff;
        }
        .text-center { text-align: center; }
        .text-justify { text-align: justify; }
        .fw-bold { font-weight: bold; }
        .mb-4 { margin-bottom: 1.5rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mt-4 { margin-top: 1.5rem; }
        
        table { width: 100%; border-collapse: collapse; }
        .table-borderless td { border: none; padding: 2px; vertical-align: top; }
        
        .signature-section { margin-top: 50px; }
        .signature-table td { text-align: center; vertical-align: top; padding-bottom: 60px; }
        
        .peserta-table { margin-top: 20px; width: 100%; border: 1px solid #000; }
        .peserta-table th, .peserta-table td { border: 1px solid #000; padding: 5px; }

        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Tombol Kembali (Tidak dicetak) -->
    <div class="no-print" style="position: fixed; top: 20px; right: 20px;">
        <button onclick="window.history.back()" style="padding: 10px 20px; cursor: pointer;">Kembali</button>
    </div>

    <div class="text-center fw-bold mb-4">
        BERITA ACARA<br>
        {{ strtoupper($judul) }}
    </div>

    <div class="text-justify mb-4">
        Dalam rangka melaksanakan prinsip partisipasi dalam Pembangunan Desa di Desa Pandanlandung Kecamatan Wagir Kabupaten Malang, maka:
    </div>

    <table class="table-borderless mb-4" style="width: auto;">
        <tr>
            <td style="width: 150px;">Hari dan Tanggal</td>
            <td>:</td>
            <td>{{ $beritaAcara->hari }}, {{ \Carbon\Carbon::parse($beritaAcara->tanggal)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Jam</td>
            <td>:</td>
            <td>09.00 WIB - Selesai</td> <!-- Hardcoded based on common practice or add field if needed -->
        </tr>
        <tr>
            <td>Tempat</td>
            <td>:</td>
            <td>{{ $beritaAcara->tempat }}</td>
        </tr>
    </table>

    <div class="text-justify mb-4">
        Telah diselenggarakan {{ $judul }} yang dihadiri wakil-wakil dari masyarakat, tokoh masyarakat, serta unsur lain yang terkait di desa sebagaimana tercantum dalam daftar hadir terlampir.
    </div>

    <div class="text-justify mb-2">
        A. Materi dan topik yang dibahas dalam forum ini serta yang bertindak selaku pimpinan rapat adalah:
    </div>

    <div style="margin-left: 20px;">
        <div class="mb-2">I. Materi dan Topik:</div>
        <div style="margin-left: 20px;">
            {!! $beritaAcara->materi !!}
        </div>
    </div>

    <div style="margin-left: 20px; margin-top: 20px;">
        <div class="mb-2">II. Unsur Pimpinan Rapat</div>
        <table class="table-borderless" style="margin-left: 20px; width: auto;">
            <tr>
                <td style="width: 150px;">Pimpinan Rapat</td>
                <td>:</td>
                <td>{{ $beritaAcara->pemimpin ?? '-' }}</td>
            </tr>
            <tr>
                <td>Sekretaris/Notulis</td>
                <td>:</td>
                <td>{{ $beritaAcara->notulis1 ?? '-' }}</td>
            </tr>
            @if($beritaAcara->notulis2)
            <tr>
                <td></td>
                <td></td>
                <td>{{ $beritaAcara->notulis2 ?? '-' }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="text-justify mt-4 mb-2">
        B. Setelah melakukan pembahasan dan diskusi terhadap materi atau topik diatas, selanjutnya seluruh peserta musyawarah menyetujui serta memutuskan beberapa hal yang berketetapan menjadi putusan akhir, yaitu:
    </div>

    <div style="margin-left: 20px;" class="text-justify">
        {!! $beritaAcara->putusan ?? '<i>(Belum ada putusan tercatat)</i>' !!}
    </div>

    <div class="text-justify mt-4">
        Demikian berita acara ini dibuat dan disahkan dengan penuh tanggung jawab agar dapat digunakan sebagaimana mestinya.
    </div>

    <!-- Tanda Tangan Utama -->
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td style="width: 50%;">
                    Pimpinan Musyawarah<br><br><br><br><br>
                    <u><b>{{ $beritaAcara->pemimpin ?? '.........................' }}</b></u>
                </td>
                <td style="width: 50%;">
                    Notulis/Sekretaris<br><br><br><br><br>
                    <u><b>{{ $beritaAcara->notulis1 ?? '.........................' }}</b></u>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Mengetahui:<br>
                    Kepala Desa<br><br><br><br><br>
                    <u><b>Wiroso Hadi</b></u> <!-- Hardcoded for now or fetch from DB config -->
                </td>
            </tr>
        </table>
    </div>

    <!-- Page Break for Signature List -->
    <div style="page-break-before: always;"></div>

    <div class="text-center fw-bold mb-4">
        DAFTAR HADIR PESERTA MUSYAWARAH
    </div>
    
    <div class="text-center mb-4">
        Mengetahui dan menyetujui,<br>
        Wakil dan peserta musyawarah
    </div>

    <table class="peserta-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Nama</th>
                <th style="width: 35%;">Alamat</th>
                <th style="width: 15%;">Unsur</th>
                <th style="width: 15%;">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($beritaAcara->peserta as $index => $peserta)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $peserta->nama }}</td>
                <td>{{ $peserta->alamat }}</td>
                <td>{{ $peserta->jabatan }}</td>
                <td></td> <!-- Empty for manual signature -->
            </tr>
            @empty
            @for($i=1; $i<=10; $i++)
            <tr>
                <td class="text-center">{{ $i }}</td>
                <td>.................................</td>
                <td>.................................</td>
                <td>.................................</td>
                <td></td>
            </tr>
            @endfor
            @endforelse
        </tbody>
    </table>

</body>
</html>
