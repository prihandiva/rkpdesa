@extends('admin.layout')

@section('title', 'Detail RKP Desa')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Detail RKP Desa</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rkpdesa.index') }}">RKP Desa</a></li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="{{ route('rkpdesa.index') }}" class="btn btn-secondary">
                            <i class="feather-arrow-left me-2"></i>Kembali
                        </a>
                        <a href="{{ route('rkpdesa.edit', $rkpDesa->id_kegiatan) }}" class="btn btn-warning">
                            <i class="feather-edit me-2"></i>Edit
                        </a>
                        <button onclick="window.print()" class="btn btn-info">
                            <i class="feather-printer me-2"></i>Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ page-header ] end -->

        <div class="row">
            <!--! [Start] Main Details !-->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Informasi Kegiatan</h6>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-3">{{ $rkpDesa->nama }}</h4>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style="width: 30%;">Tahun Anggaran</th>
                                    <td>: {{ $rkpDesa->tahun_rkp->tahun ?? $rkpDesa->tahun }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kegiatan</th>
                                    <td>: {{ $rkpDesa->jenis_kegiatan }}</td>
                                </tr>
                                <tr>
                                    <th>Bidang</th>
                                    <td>: {{ $rkpDesa->bidang_rkp->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Lokasi</th>
                                    <td>: {{ $rkpDesa->lokasi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Volume</th>
                                    <td>: {{ $rkpDesa->volume ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Waktu Pelaksanaan</th>
                                    <td>: {{ $rkpDesa->waktu ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Penerima Manfaat</th>
                                    <td>: {{ $rkpDesa->penerima ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>

                         <hr>
                         
                         <h6 class="fw-bold">Anggaran & Pelaksanaan</h6>
                         <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style="width: 30%;">Jumlah Anggaran</th>
                                    <td class="fw-bold text-primary">: Rp {{ number_format($rkpDesa->jumlah, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Sumber Biaya</th>
                                    <td>: {{ $rkpDesa->sumber_biaya_rkp->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pola Pelaksanaan</th>
                                    <td>: {{ $rkpDesa->pola_pelaksanaan_rkp->nama ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--! [Start] Relations !-->
                <div class="card border-0 shadow-sm mb-4">
                     <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Referensi Dokumen</h6>
                    </div>
                    <div class="card-body">
                         <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Usulan Asal (Musdus)</h6>
                                    @if($rkpDesa->usulan)
                                        <p class="mb-0 text-muted">{{ $rkpDesa->usulan->jenis_kegiatan }} - Dusun: {{ $rkpDesa->usulan->dusun->nama ?? '-' }}</p>
                                    @else
                                        <p class="mb-0 text-muted">- Tidak ada usulan terkait -</p>
                                    @endif
                                </div>
                                 @if($rkpDesa->usulan)
                                    <a href="{{ route('usulan.edit', $rkpDesa->id_usulan) }}" class="btn btn-sm btn-outline-primary"><i class="feather-external-link"></i></a>
                                @endif
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">RPJM Referensi</h6>
                                     @if($rkpDesa->rpjm)
                                        <p class="mb-0 text-muted">{{ $rkpDesa->rpjm->visi }} ({{ $rkpDesa->rpjm->tahun_mulai }}-{{ $rkpDesa->rpjm->tahun_selesai }})</p>
                                    @else
                                        <p class="mb-0 text-muted">- Tidak ada RPJM terkait -</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--! [Start] Status Sidebar !-->
            <div class="col-lg-4">
                 <!--! [Start] Verification Status !-->
                 <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom">
                        <h6 class="mb-0">Status Verifikasi</h6>
                    </div>
                    <div class="card-body text-center">
                        @php
                            $statusVer = $rkpDesa->status_verifikasi ?? 'Menunggu';
                            $badgeClass = match($statusVer) {
                                'Diterima' => 'bg-success',
                                'Ditolak' => 'bg-danger',
                                'Revisi' => 'bg-warning',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} fs-14 mb-3">{{ $statusVer }}</span>
                        
                        @if($rkpDesa->catatan_verifikasi)
                            <div class="alert alert-warning text-start" role="alert">
                                <strong>Catatan:</strong><br>
                                {{ $rkpDesa->catatan_verifikasi }}
                            </div>
                        @endif
                    </div>
                </div>

                <!--! [Start] Approval Status !-->
                 <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom">
                        <h6 class="mb-0">Status Persetujuan (Final)</h6>
                    </div>
                    <div class="card-body text-center">
                         @php
                            $statusApp = $rkpDesa->status_approval ?? 'Menunggu';
                            $badgeAppClass = match($statusApp) {
                                'Disetujui Kepala Desa' => 'bg-success',
                                'Disetujui BPD' => 'bg-info',
                                'Ditolak' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge {{ $badgeAppClass }} fs-14">{{ $statusApp }}</span>
                    </div>
                </div>

                <!--! [Start] Files !-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom">
                        <h6 class="mb-0">Dokumen Lampiran</h6>
                    </div>
                    <div class="card-body">
                         <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Berita Acara Musrenbang</span>
                                @if($rkpDesa->file_berita_acara_musrenbang)
                                    <a href="{{ asset($rkpDesa->file_berita_acara_musrenbang) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
                                @else
                                    <span class="text-muted small">Tidak ada</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
