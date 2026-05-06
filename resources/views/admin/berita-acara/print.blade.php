<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Berita Acara - {{ $judul }}</title>
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
        .mb-4 { margin-bottom: 2rem; }
        .mb-2 { margin-bottom: 0.8rem; }
        .mt-4 { margin-top: 2rem; }
        
        table { width: 100%; border-collapse: collapse; }
        .table-borderless td { border: none; padding: 2px; vertical-align: top; }
        
        .signature-section { margin-top: 50px; }
        .signature-table { width: 100%; }
        .signature-table td { text-align: center; vertical-align: top; padding-bottom: 30px; }
        
        .peserta-table { margin-top: 20px; width: 100%; border: 1px solid #000; }
        .peserta-table th, .peserta-table td { border: 1px solid #000; padding: 8px; font-size: 11pt; }
        
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
            .page-break { page-break-before: always; }
        }

        /* TinyMCE content fixes for print */
        .content-body ul, .content-body ol { margin-top: 0; margin-bottom: 0; padding-left: 20px; }
        .content-body p { margin-top: 0; margin-bottom: 0.5rem; }
    </style>
</head>
<body onload="window.print()">

    <!-- Tombol Kembali (Tidak dicetak) -->
    <div class="no-print" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
        <button onclick="window.history.back()" style="padding: 10px 20px; cursor: pointer; background: #eee; border: 1px solid #ccc; border-radius: 4px;">Kembali</button>
    </div>

    <!-- HEADER -->
    <div class="text-center fw-bold mb-4" style="font-size: 14pt;">
        BERITA ACARA<br>
        {{ strtoupper($judul) }}
    </div>

    <!-- INTRO -->
    <div class="text-justify mb-4">
        Dalam rangka melaksanakan prinsip partisipasi dalam Pembangunan Desa di Desa Pandanlandung Kecamatan Wagir Kabupaten Malang, maka:
    </div>

    <!-- META DATA -->
    <table class="table-borderless mb-4" style="width: 100%;">
        <tr>
            <td style="width: 150px;">Hari dan Tanggal</td>
            <td style="width: 20px;">:</td>
            <td>{{ \Carbon\Carbon::parse($beritaAcara->tanggal)->translatedFormat('l, d F Y') }}</td>
        </tr>
        <tr>
            <td>Jam</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($beritaAcara->jam_mulai)->format('H.i') }} WIB - {{ $beritaAcara->jam_selesai ? \Carbon\Carbon::parse($beritaAcara->jam_selesai)->format('H.i') . ' WIB' : 'Selesai' }}</td> 
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

    <!-- SECTION A -->
    <div class="text-justify mb-2">
        A. Materi dan topik yang dibahas dalam forum ini serta yang bertindak selaku pimpinan rapat adalah:
    </div>

    <div style="margin-left: 30px;">
        <div class="mb-2">I. Materi dan Topik:</div>
        <div class="content-body" style="margin-left: 20px; margin-bottom: 20px;">
            {!! $beritaAcara->materi !!}
        </div>

        <div class="mb-2">II. Unsur Pimpinan Rapat</div>
        <table class="table-borderless" style="margin-left: 25px; width: auto;">
            <tr>
                <td style="width: 150px;">Pimpinan Rapat</td>
                <td style="width: 20px;">:</td>
                <td>{{ $beritaAcara->pemimpin ?? '-' }}</td>
                <td style="padding-left: 20px;">dari</td>
                <td style="padding-left: 20px;">{{ $beritaAcara->asal_pemimpin ?? '.............................................' }}</td>
            </tr>
            <tr>
                <td>Sekretaris/Notulis</td>
                <td>:</td>
                <td>{{ $beritaAcara->notulis1 ?? '-' }}</td>
                <td style="padding-left: 20px;">dari</td>
                <td style="padding-left: 20px;">{{ $beritaAcara->asal_notulis1 ?? '.............................................' }}</td>
            </tr>
            @if($beritaAcara->notulis2)
            <tr>
                <td></td>
                <td></td>
                <td>{{ $beritaAcara->notulis2 }}</td>
                <td style="padding-left: 20px;">dari</td>
                <td style="padding-left: 20px;">{{ $beritaAcara->asal_notulis2 ?? '.............................................' }}</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- SECTION B -->
    <div class="text-justify mt-4 mb-2">
        B. Setelah melakukan pembahasan dan diskusi terhadap materi atau topik diatas, selanjutnya seluruh peserta musyawarah menyetujui serta memutuskan beberapa hal yang berketetapan menjadi putusan akhir, yaitu:
    </div>

    <div class="content-body text-justify" style="margin-left: 30px;">
        {!! $beritaAcara->putusan ?? '<i>(Belum ada putusan tercatat)</i>' !!}
    </div>

    <div class="text-justify mt-4">
        Demikian berita acara ini dibuat dan disahkan dengan penuh tanggung jawab agar dapat digunakan sebagaimana mestinya.
    </div>

    <!-- TANDA TANGAN -->
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td style="width: 50%;">Pimpinan Musyawarah</td>
                <td style="width: 50%;">Notulis/Sekretaris</td>
            </tr>
            <tr>
                <td style="height: 50px;"></td>
                <td style="height: 50px;"></td>
            </tr>
            <tr>
                <td><u><b>{{ $beritaAcara->pemimpin ?? '.........................' }}</b></u></td>
                <td><u><b>{{ $beritaAcara->notulis1 ?? '.........................' }}</b></u></td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 30px;">
                    Mengetahui/Menyetujui:
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">Kepala Desa</td>
                @if($beritaAcara->jenis == 'BPD')
                <td style="width: 50%;">Ketua BPD</td>
                @else
                <td></td>
                @endif
            </tr>
            <tr>
                <td style="height: 50px;"></td>
                <td style="height: 50px;"></td>
            </tr>
            <tr>
                <td><u><b>{{ $kades ? strtoupper($kades->nama) : '.........................' }}</b></u></td>
                @if($beritaAcara->jenis == 'BPD')
                <td><u><b>{{ $userBpd ? strtoupper($userBpd->nama) : ($beritaAcara->nama_bpd ?? '.........................') }}</b></u></td>
                @else
                <td></td>
                @endif
            </tr>
        </table>
    </div>

    <div class="text-center mt-5 mb-3">
        <b>Mengetahui dan menyetujui,<br>
        Wakil dan peserta musyawarah</b>
    </div>

    <!-- 10 Wakil TTD (Format 3 Kolom: Nama, Alamat, Ttd) -->
    <table class="table-borderless mt-3" style="width: 100%; font-size: 11pt; text-align: center;">
        <tr>
            <td style="width: 33%; padding-bottom: 20px;">Nama</td>
            <td style="width: 33%; padding-bottom: 20px;">Alamat</td>
            <td style="width: 34%; padding-bottom: 20px;">Ttd</td>
        </tr>
        @foreach($beritaAcara->peserta as $index => $p)
        <tr>
            <td style="padding-bottom: 30px; text-align: left;">
                {{ $index + 1 }}. {{ $p->nama }}
            </td>
            <td style="padding-bottom: 30px; text-align: center;">
                {{ $p->alamat }}
            </td>
            <td style="padding-bottom: 30px; text-align: left; padding-left: 20px;">
                ..........................................
            </td>
        </tr>
        @endforeach
    </table>

    <!-- PAGE BREAK & ATTENDANCE -->
    <div class="page-break"></div>

    <div class="text-center fw-bold mt-4 mb-4">
        DAFTAR HADIR PESERTA MUSYAWARAH
    </div>
    
    <table class="peserta-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 30%;">Nama</th>
                <th style="width: 25%;">Unsur/Jabatan</th>
                <th style="width: 25%;">Alamat</th>
                <th style="width: 15%; text-align: center;">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
        @forelse($beritaAcara->absensi as $index => $abs)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $abs->nama }}</td>
                <td>{{ $abs->unsur }}</td>
                <td>{{ $abs->alamat }}</td>
                <td></td> <!-- Empty for manual signature -->
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 20px; color: #888;">Belum ada data daftar hadir.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
