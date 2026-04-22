<table>
    <thead>
        <tr>
            <th colspan="16" style="text-align: center; font-weight: bold; font-size: 14px;">RANCANGAN RPJM DESA</th>
        </tr>
        <tr>
            <th colspan="16" style="text-align: center; font-weight: bold; font-size: 14px;">
                @if(!empty($periode))
                    TAHUN {{ strtoupper($periode) }}
                @else
                    SELURUH PERIODE
                @endif
            </th>
        </tr>
        <tr><td colspan="16"></td></tr>
        <tr>
            <td colspan="3" style="font-weight: bold;">DESA</td>
            <td colspan="13">: PEMERINTAH DESA PANDANLANDUNG</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight: bold;">KECAMATAN</td>
            <td colspan="13">: KECAMATAN WAGIR</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight: bold;">KABUPATEN/KOTA</td>
            <td colspan="13">: KABUPATEN MALANG</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight: bold;">PROVINSI</td>
            <td colspan="13">: PROVINSI JAWA TIMUR</td>
        </tr>
        <tr>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">NO</th>
            <th colspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">BIDANG/SUB BIDANG/JENIS KEGIATAN</th>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">LOKASI <br>( RT / RW <br>DUSUN )</th>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">PERKIRAAN <br>VOLUME</th>
            <th rowspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">SASARAN / <br>MANFAAT</th>
            <th colspan="8" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">WAKTU PELAKSANAAN</th>
            <th colspan="2" style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">PRAKIRAAN BIAYA &amp; SUMBERDANA</th>
        </tr>
        <tr>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">BIDANG / SUB BIDANG</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">JENIS KEGIATAN</th>
            <!-- WAKTU PELAKSANAAN 1-8 -->
            @for($i=1; $i<=8; $i++)
            <th style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">THN <br>{{$i}}</th>
            @endfor
            <!-- BIAYA -->
            <th style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">JUMLAH <br>( RUPIAH )</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold; vertical-align: middle;">SUMBER</th>
        </tr>
        <tr>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">1</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">2</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">3</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">4</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">5</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">6</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">7</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">8</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">9</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">10</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">11</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">12</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">13</th>
             <th style="border: 1px solid #000; text-align: center; font-weight: bold;">14</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">15</th>
            <th style="border: 1px solid #000; text-align: center; font-weight: bold;">16</th>
        </tr>
    </thead>
    <tbody>
        @php
            $grandTotal = 0;
            $bidangCounter = 1;
        @endphp
        
        @foreach($groupedRpjm as $idBidang => $items)
            @php
                $bidangNama = $items->first()->masterBidang->nama ?? 'Tanpa Bidang';
                $bidangCode = str_pad($bidangCounter, 2, '0', STR_PAD_LEFT);
                $totalBidang = $items->sum('jumlah');
                $grandTotal += $totalBidang;
            @endphp
            
            <!-- Header Bidang -->
            <tr>
                <td style="border: 1px solid #000; text-align: center; font-weight: bold;">{{ $bidangCode }}</td>
                <td colspan="13" style="border: 1px solid #000; font-weight: bold; text-transform: uppercase;">BIDANG {{ $bidangNama }}</td>
                <td style="border: 1px solid #000; font-weight: bold; text-align: right;">{{ $totalBidang > 0 ? $totalBidang : '' }}</td>
                <td style="border: 1px solid #000;"></td>
            </tr>
            
            <!-- Items per Bidang -->
            @foreach($items as $index => $item)
            <tr>
                <td style="border: 1px solid #000;"></td>
                <td style="border: 1px solid #000; padding-left: 10px;">{{ $item->subbidang ?? '' }}</td>
                <td style="border: 1px solid #000;">{{ $item->jenis_kegiatan }}</td>
                <td style="border: 1px solid #000;">{{ $item->lokasi ?? '-' }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ $item->volume ?? '-' }}</td>
                <td style="border: 1px solid #000;">{{ $item->sasaran ?? '-' }}</td>
                
                <!-- Waktu Pelaksanaan Checkmarks -->
                @for($i=1; $i<=8; $i++)
                <td style="border: 1px solid #000; text-align: center; vertical-align: middle; font-size: 14px;">
                    @if($item->tahun_pelaksanaan == $i)
                        &#10003;
                    @endif
                </td>
                @endfor
                
                <td style="border: 1px solid #000; text-align: right;">{{ $item->jumlah ?? 0 }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ $item->sumberBiayaModels->count() > 0 ? $item->sumberBiayaModels->pluck('nama')->implode(', ') : (is_array($item->sumber_biaya) ? implode(', ', $item->sumber_biaya) : ($item->sumber_biaya ?? '-')) }}</td>
            </tr>
            @endforeach
            
            <!-- JUMLAH PER BIDANG -->
            <tr>
                <td colspan="14" style="border: 1px solid #000; text-align: center; font-weight: bold;">JUMLAH PER BIDANG</td>
                <td style="border: 1px solid #000; font-weight: bold; text-align: right;">{{ $totalBidang }}</td>
                <td style="border: 1px solid #000;"></td>
            </tr>

            @php
                $bidangCounter++;
            @endphp
        @endforeach
        
        <!-- Grand Total -->
        <tr>
            <td colspan="14" style="border: 1px solid #000; text-align: center; font-weight: bold;">JUMLAH TOTAL</td>
            <td style="border: 1px solid #000; font-weight: bold; text-align: right;">{{ $grandTotal }}</td>
            <td style="border: 1px solid #000;"></td>
        </tr>
        
        <!-- Spacing for Signatures -->
        <tr><td colspan="16"></td></tr>
        <tr><td colspan="16"></td></tr>
        
        <tr>
            <td colspan="12" style="text-align: center;"></td>
            <td colspan="4" style="text-align: center;">
                @php
                    $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    $currentDate = date('d') . ' ' . $months[date('n') - 1] . ' ' . date('Y');
                @endphp
                Pandanlandung, {{ $currentDate }}
            </td>
        </tr>
        <tr>
            <td colspan="12" style="text-align: center;">Mengetahui,</td>
            <td colspan="4" style="text-align: center;">Disetujui Oleh:</td>
        </tr>
        <tr>
            <td colspan="12" style="text-align: center;">Kepala Desa Pandanlandung</td>
            <td colspan="4" style="text-align: center;">Sekretaris Desa</td>
        </tr>
        <tr><td colspan="16"></td></tr>
        <tr><td colspan="16"></td></tr>
        <tr><td colspan="16"></td></tr>
        <tr>
            <td colspan="12" style="text-align: center; font-weight: bold; text-decoration: underline;">{{ $kades->nama ?? '.....................................' }}</td>
            <td colspan="4" style="text-align: center; font-weight: bold; text-decoration: underline;">{{ $sekdes->nama ?? '.....................................' }}</td>
        </tr>
        <tr>
            <td colspan="12" style="text-align: center;">{{ $kades && $kades->NIP ? 'NIP. ' . $kades->NIP : '' }}</td>
            <td colspan="4" style="text-align: center;">{{ $sekdes && $sekdes->NIP ? 'NIP. ' . $sekdes->NIP : '' }}</td>
        </tr>
    </tbody>
</table>
