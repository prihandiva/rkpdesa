<table class="table">
    <thead>
        <tr>
            <th colspan="7" style="text-align: center; font-weight: bold; font-size: 14px;">DAFTAR USULAN PEMBANGUNAN DESA</th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center; font-weight: bold; font-size: 12px;">
                TAHUN: {{ $tahun ? $tahun : 'Semua Tahun' }} | STATUS: {{ $status ? $status : 'Semua Status' }}
            </th>
        </tr>
        <tr>
            <th colspan="7"></th>
        </tr>
        <tr>
            <th colspan="7"></th>
        </tr>
        <tr>
            <th colspan="7"></th>
        </tr>
        <tr>
            <th colspan="7"></th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center;">No</th>
            <th style="font-weight: bold; text-align: center;">Dusun</th>
            <th style="font-weight: bold; text-align: center;">RW/RT</th>
            <th style="font-weight: bold; text-align: center;">Jenis Kegiatan</th>
            <th style="font-weight: bold; text-align: center;">Bidang</th>
            <th style="font-weight: bold; text-align: center;">Prioritas</th>
            <th style="font-weight: bold; text-align: center;">Tahun</th>
        </tr>
    </thead>
    <tbody>
        @php
            $globalNo = 1;
        @endphp
        @forelse($groupedUsulans as $id_dusun => $usulans)
            @foreach($usulans as $usulan)
                <tr>
                    <td style="text-align: center;">{{ $globalNo++ }}</td>
                    <td>{{ $usulan->dusun->nama ?? '-' }}</td>
                    <td style="text-align: center;">RW: {{ $usulan->id_rw }} / RT: {{ $usulan->id_rt }}</td>
                    <td>{{ $usulan->jenis_kegiatan }}</td>
                    <td>{{ $usulan->bidang }}</td>
                    <td style="text-align: center;">{{ $usulan->prioritas }}</td>
                    <td style="text-align: center;">{{ $usulan->tahun }}</td>
                </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data usulan.</td>
            </tr>
        @endforelse

        <tr><td colspan="7"></td></tr>
        <tr><td colspan="7"></td></tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="3" style="text-align: center;">Malang, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center;">Sekretaris Desa</td>
            <td colspan="1"></td>
            <td colspan="3" style="text-align: center;">Kepala Desa</td>
        </tr>
        <tr><td colspan="7"></td></tr>
        <tr><td colspan="7"></td></tr>
        <tr><td colspan="7"></td></tr>
        <tr>
            <td colspan="3" style="text-align: center; font-weight: bold; text-decoration: underline;">
                {{ $sekdes ? $sekdes->nama : '................................' }}
            </td>
            <td colspan="1"></td>
            <td colspan="3" style="text-align: center; font-weight: bold; text-decoration: underline;">
                {{ $kades ? $kades->nama : '................................' }}
            </td>
        </tr>
    </tbody>
</table>
