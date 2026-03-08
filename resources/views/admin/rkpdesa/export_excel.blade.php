<table>
    <thead>
        <tr>
            <th colspan="12" style="text-align: center; font-weight: bold; font-size: 14px;">RANCANGAN RENCANA KERJA PEMERINTAH DESA (RKPDESA)</th>
        </tr>
        <tr>
            <th colspan="12" style="text-align: center; font-weight: bold; font-size: 14px;">TAHUN ANGGARAN {{ $tahunAktif }}</th>
        </tr>
        <tr>
            <th colspan="12" style="text-align: center; font-weight: bold; font-size: 14px;">DESA PANDANLANDUNG KECAMATAN WAGIR KABUPATEN MALANG</th>
        </tr>
        <tr>
            <th colspan="12"></th>
        </tr>
        <tr>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">No</th>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">Bidang</th>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">Jenis Kegiatan</th>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">Data Eksisting Tahun Berjalan</th>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">Target Capaian Tahun {{ $tahunAktif }}</th>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">Lokasi</th>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">Volume dan Satuan</th>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">Penerima Manfaat</th>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">Waktu Pelaksanaan</th>
            <th colspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">Biaya dan Sumber Pembiayaan</th>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">Pola Pelaksanaan (swakelola/<br>Kerjasama Antar Desa/<br>Kerjasama pihak Ketiga)</th>
        </tr>
        <tr>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">Jumlah (Rp)</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">Sumber Biaya</th>
        </tr>
        <tr>
            <th style="border: 1px solid #000; text-align: center; font-style: italic;">a</th>
            <th style="border: 1px solid #000; text-align: center; font-style: italic;">b</th>
            <th style="border: 1px solid #000; text-align: center; font-style: italic;">d</th>
            <th style="border: 1px solid #000; text-align: center; font-style: italic;">f</th>
            <th style="border: 1px solid #000; text-align: center; font-style: italic;">g</th>
            <th style="border: 1px solid #000; text-align: center; font-style: italic;">h</th>
            <th style="border: 1px solid #000; text-align: center; font-style: italic;">i</th>
            <th style="border: 1px solid #000; text-align: center; font-style: italic;">j</th>
            <th style="border: 1px solid #000; text-align: center; font-style: italic;">k</th>
            <th style="border: 1px solid #000; text-align: center; font-style: italic;">l</th>
            <th style="border: 1px solid #000; text-align: center; font-style: italic;">m</th>
            <th style="border: 1px solid #000; text-align: center; font-style: italic;">n</th>
        </tr>
    </thead>
    <tbody>
        @php
            $grandTotal = 0;
            $bidangIndex = 1;
        @endphp
        
        @foreach($groupedRkpdesa as $idBidang => $items)
            @php
                $bidangNama = $items->first()->masterBidang->nama ?? 'Tanpa Bidang';
                $totalBidang = $items->sum('jumlah');
                $grandTotal += $totalBidang;
            @endphp
            
            <!-- Header Bidang -->
            <tr>
                <td style="border: 1px solid #000; text-align: center; font-weight: bold;">{{ $bidangIndex }}.</td>
                <td colspan="8" style="border: 1px solid #000; font-weight: bold; text-transform: uppercase;">{{ $bidangNama }}</td>
                <td style="border: 1px solid #000; font-weight: bold; text-align: right;">{{ $totalBidang }}</td>
                <td style="border: 1px solid #000;"></td>
                <td style="border: 1px solid #000;"></td>
            </tr>
            
            <!-- Items per Bidang -->
            @foreach($items as $index => $item)
            <tr>
                <td style="border: 1px solid #000;"></td>
                <td style="border: 1px solid #000; text-align: center; font-style: italic;">{{ $index + 1 }}.</td>
                <td style="border: 1px solid #000; font-style: italic;">{{ $item->jenis_kegiatan }}</td>
                <td style="border: 1px solid #000; font-style: italic;">{{ $item->data_existing ?? '-' }}</td>
                <td style="border: 1px solid #000; font-style: italic;">{{ $item->target_capaian ?? '-' }}</td>
                <td style="border: 1px solid #000; font-style: italic;">{{ $item->lokasi ?? '-' }}</td>
                <td style="border: 1px solid #000; text-align: center; font-style: italic;">{{ $item->volume ?? '-' }}</td>
                <td style="border: 1px solid #000; font-style: italic;">{{ $item->penerima ?? '-' }}</td>
                <td style="border: 1px solid #000; text-align: center; font-style: italic;">{{ $item->waktu ?? '-' }}</td>
                <td style="border: 1px solid #000; text-align: right; font-style: italic;">{{ $item->jumlah ?? 0 }}</td>
                <td style="border: 1px solid #000; text-align: center; font-style: italic;">{{ $item->masterSumberBiaya->nama ?? '-' }}</td>
                <td style="border: 1px solid #000; text-align: center; font-style: italic;">{{ $item->masterPola->nama ?? ($item->pola_pelaksanaan ?? 'Swakelola') }}</td>
            </tr>
            @endforeach
            
            @php
                $bidangIndex++;
            @endphp
        @endforeach
        
        <!-- Grand Total -->
        <tr>
            <td colspan="9" style="border: 1px solid #000; text-align: center; font-weight: bold;">JUMLAH RKPDESA TAHUN ANGGARAN {{ $tahunAktif }}</td>
            <td style="border: 1px solid #000; font-weight: bold; text-align: right;">{{ $grandTotal }}</td>
            <td style="border: 1px solid #000;"></td>
            <td style="border: 1px solid #000;"></td>
        </tr>
        
        <!-- Spacing for Signatures -->
        <tr>
            <td colspan="12"></td>
        </tr>
        <tr>
            <td colspan="12"></td>
        </tr>
        
        <!-- Signatures -->
        <tr>
            <td colspan="8" style="text-align: center;"></td>
            <td colspan="4" style="text-align: center;">Pandanlandung, ...... Desember {{ $tahunAktif - 1 }}</td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center;">Mengetahui,</td>
            <td colspan="4" style="text-align: center;">Disetujui Oleh:</td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center;">Kepala Desa Pandanlandung</td>
            <td colspan="4" style="text-align: center;">Sekretaris Desa</td>
        </tr>
        <tr>
            <td colspan="12"></td>
        </tr>
        <tr>
            <td colspan="12"></td>
        </tr>
        <tr>
            <td colspan="12"></td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center; font-weight: bold; text-decoration: underline;">{{ $kades->nama ?? '.....................................' }}</td>
            <td colspan="4" style="text-align: center; font-weight: bold; text-decoration: underline;">{{ $sekdes->nama ?? '.....................................' }}</td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center;"></td>
            <td colspan="4" style="text-align: center;"></td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center;">{{ $kades && $kades->NIP ? 'NIP. ' . $kades->NIP : '' }}</td>
            <td colspan="4" style="text-align: center;">{{ $sekdes && $sekdes->NIP ? 'NIP. ' . $sekdes->NIP : '' }}</td>
        </tr>
    </tbody>
</table>
