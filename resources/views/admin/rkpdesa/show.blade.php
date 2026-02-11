@extends('admin.layout')

@section('title', 'Detail RKP Desa')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
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
    </div>

    <div class="row">
        <!-- Left Column: Details & Actions -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Informasi Kegiatan</h6>
                </div>
                <div class="card-body">
                    <!-- Read-Only Details -->
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th style="width: 30%;">Nama Kegiatan</th>
                                <td>{{ $rkpDesa->nama }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kegiatan</th>
                                <td>{{ $rkpDesa->jenis_kegiatan }}</td>
                            </tr>
                            <tr>
                                <th>Bidang</th>
                                <td>{{ $rkpDesa->masterBidang->nama ?? $rkpDesa->bidang }}</td> 
                            </tr>
                            <tr>
                                <th>Tahun</th>
                                <td>{{ $rkpDesa->tahun }}</td>
                            </tr>
                            <tr>
                                <th>Lokasi</th>
                                <td>{{ $rkpDesa->lokasi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Volume</th>
                                <td>{{ $rkpDesa->volume ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Biaya</th>
                                <td>Rp {{ number_format($rkpDesa->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Sumber Biaya</th>
                                <td>{{ $rkpDesa->masterSumberBiaya->nama ?? $rkpDesa->sumber_biaya }}</td>
                            </tr>
                            <tr>
                                <th>Pola Pelaksanaan</th>
                                <td>{{ $rkpDesa->masterPola->nama ?? $rkpDesa->pola_pelaksanaan }}</td>
                            </tr>
                            <tr>
                                <th>File Berita Acara</th>
                                <td>
                                    @if($rkpDesa->file_berita_acara_musrenbang)
                                        <a href="{{ asset($rkpDesa->file_berita_acara_musrenbang) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="feather-file-text me-1"></i>Lihat Dokumen
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <hr>

                    <!-- ROLE: Tim Verifikasi -->
                    @if(session('user_role') == 'tim_verifikasi')
                    <div class="card bg-light border mb-3">
                        <div class="card-body">
                            <h6 class="card-title text-info"><i class="feather-check-circle me-2"></i>Verifikasi Usulan</h6>
                            <form action="{{ route('rkpdesa.update', $rkpDesa->id_kegiatan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <!-- Removed hidden fields to prevent validation errors with empty values -->
                                <!-- We only need to send status and specific notes -->
                                
                                <div class="mb-3">
                                    <label class="form-label">Status Verifikasi</label>
                                    <select name="status" class="form-select">
                                        <option value="Pending" {{ $rkpDesa->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Terverifikasi" {{ $rkpDesa->status == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                        <option value="Gagal Terverifikasi" {{ $rkpDesa->status == 'Gagal Terverifikasi' ? 'selected' : '' }}>Gagal Terverifikasi</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Catatan Verifikasi</label>
                                    <textarea name="catatan_verifikasi" class="form-control" rows="3">{{ $rkpDesa->catatan_verifikasi }}</textarea>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- ROLE: BPD -->
                    @if(session('user_role') == 'bpd')
                        @if($rkpDesa->status == 'Terverifikasi' || $rkpDesa->status == 'Disetujui' || $rkpDesa->status == 'Ditolak BPD')
                        <div class="card bg-light border mb-3">
                            <div class="card-body">
                                <h6 class="card-title text-warning"><i class="feather-shield me-2"></i>Persetujuan BPD</h6>
                                <form action="{{ route('rkpdesa.update', $rkpDesa->id_kegiatan) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Status Approval</label>
                                        <select name="status" class="form-select">
                                            <option value="Menunggu persetujuan BPD" {{ $rkpDesa->status == 'Menunggu persetujuan BPD' ? 'selected' : '' }}>Menunggu persetujuan BPD</option>
                                            <option value="Disetujui" {{ $rkpDesa->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                            <option value="Ditolak BPD" {{ $rkpDesa->status == 'Ditolak BPD' ? 'selected' : '' }}>Ditolak BPD</option>
                                        </select>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Simpan Keputusan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <i class="feather-clock me-2"></i>
                            <strong>Menunggu Verifikasi</strong>
                            <p class="mb-0 small">Anda dapat memberikan persetujuan setelah kegiatan ini berstatus <strong>Terverifikasi</strong>. Status saat ini: <strong>{{ $rkpDesa->status }}</strong></p>
                        </div>
                        @endif
                    @endif

                    <!-- ROLE: Penyusun RKP -->
                    @if(session('user_role') == 'tim_penyusun')
                        @if($rkpDesa->status == 'Terverifikasi' || $rkpDesa->status == 'Disetujui')
                        <div class="card bg-light border mb-3">
                            <div class="card-body">
                                <h6 class="card-title text-success"><i class="feather-edit me-2"></i>Lengkapi Data RKP</h6>
                                <p class="small text-muted">Silakan lengkapi data RKP Desa (RAB, Lokasi, dll) melalui halaman edit.</p>
                                <a href="{{ route('rkpdesa.edit', $rkpDesa->id_kegiatan) }}" class="btn btn-success btn-sm">
                                    <i class="feather-edit-2 me-1"></i>Edit Data RKP
                                </a>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-secondary">
                            <i class="feather-lock me-2"></i>
                            <strong>Mode Baca Saja</strong>
                            <p class="mb-0 small">Anda hanya dapat melengkapi data jika status kegiatan sudah <strong>Terverifikasi</strong>. Status saat ini: <strong>{{ $rkpDesa->status }}</strong></p>
                        </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>

        <!-- Right Column: Status info & Timeline -->
        <div class="col-lg-4">
            <!-- Status & Priority Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Status & Prioritas</h6>
                </div>
                <div class="card-body">
                     <!-- Priority Section -->
                    <div class="mb-4 text-center border-bottom pb-4">
                        <label class="d-block text-muted small mb-2">Prioritas Kegiatan</label>
                        @php
                            $prioVal = $rkpDesa->prioritas ?? 0;
                            $prioColor = match(true) {
                                $prioVal >= 5 => 'danger',
                                $prioVal >= 4 => 'warning',
                                $prioVal >= 3 => 'info',
                                default => 'success'
                            };
                            if($prioVal == 0) $prioColor = 'secondary';
                        @endphp
                        <div class="d-flex justify-content-center align-items-center">
                            <h1 class="display-3 fw-bold text-{{ $prioColor }} mb-0">{{ $prioVal > 0 ? $prioVal : '-' }}</h1>
                        </div>
                        <span class="badge bg-light text-muted border mt-2">Skala 1 - 5</span>
                    </div>

                    <!-- Vertical Timeline (Stepper) -->
                    <div class="position-relative ps-3 mt-4">
                        @php
                            $status = $rkpDesa->status;
                            
                            // Levels: 1=Proses, 2=Pending, 3=Terverifikasi/Gagal, 4=BPD (Setuju/Ditolak)
                            // Mapping for existing RKP statuses
                            $level = 1; 
                            if ($status == 'Proses') $level = 1;
                            elseif ($status == 'Pending') $level = 2; // Diterima RKP
                            elseif (in_array($status, ['Terverifikasi', 'Gagal Terverifikasi'])) $level = 3;
                            elseif (in_array($status, ['Menunggu persetujuan BPD', 'Disetujui', 'Ditolak BPD'])) $level = 4;
                            
                            $c_muted = 'muted';
                            $c_primary = 'primary';
                            $c_success = 'success';
                            $c_danger = 'danger';
                        @endphp

                        <!-- Step 1: Usulan Masuk / Proses -->
                        <div class="d-flex align-items-center mb-4 position-relative">
                            <div class="position-absolute start-0 top-0 translate-middle-x bg-white" style="z-index: 2;">
                                <i class="feather-file-text fs-4 text-{{ $level >= 1 ? $c_primary : $c_muted }}"></i>
                            </div>
                            <div class="border-start border-3 border-{{ $level > 1 ? $c_primary : $c_muted }} position-absolute start-0 h-100" style="left: -1px; top: 10px; z-index: 1;"></div>
                            <div class="ms-4">
                                <h6 class="mb-0 {{ $level >= 1 ? 'fw-bold text-dark' : 'text-muted' }}">Usulan Masuk</h6>
                                <small class="text-muted">Draft RKP</small>
                                @if($status == 'Proses') <span class="badge bg-primary ms-2">Saat Ini</span> @endif
                            </div>
                        </div>

                        <!-- Step 2: Pending (Menunggu Verifikasi) -->
                        <div class="d-flex align-items-center mb-4 position-relative">
                            <div class="position-absolute start-0 top-0 translate-middle-x bg-white" style="z-index: 2;">
                                <i class="feather-inbox fs-4 text-{{ $level >= 2 ? $c_primary : $c_muted }}"></i>
                            </div>
                            <div class="border-start border-3 border-{{ $level > 2 ? $c_primary : $c_muted }} position-absolute start-0 h-100" style="left: -1px; top: 10px; z-index: 1;"></div>
                            <div class="ms-4">
                                <h6 class="mb-0 {{ $level >= 2 ? 'fw-bold text-dark' : 'text-muted' }}">Menunggu Verifikasi</h6>
                                <small class="text-muted">Siap Diverifikasi</small>
                                @if($status == 'Pending') <span class="badge bg-warning ms-2">Saat Ini</span> @endif
                            </div>
                        </div>

                        <!-- Step 3: Verifikasi Teknis -->
                        @php
                            $step3Color = $c_muted;
                            $step3Icon = 'feather-check-circle';
                            if ($level > 3) {
                                $step3Color = $c_primary;
                            } elseif ($level == 3) {
                                $step3Color = $status == 'Gagal Terverifikasi' ? $c_danger : $c_primary;
                                $step3Icon = $status == 'Gagal Terverifikasi' ? 'feather-x-circle' : 'feather-check-circle';
                            }
                        @endphp
                        <div class="d-flex align-items-center mb-4 position-relative">
                            <div class="position-absolute start-0 top-0 translate-middle-x bg-white" style="z-index: 2;">
                                <i class="{{ $step3Icon }} fs-4 text-{{ $step3Color }}"></i>
                            </div>
                            <div class="border-start border-3 border-{{ $level > 3 ? $c_primary : $c_muted }} position-absolute start-0 h-100" style="left: -1px; top: 10px; z-index: 1;"></div>
                            <div class="ms-4">
                                <h6 class="mb-0 {{ $level >= 3 ? 'fw-bold text-dark' : 'text-muted' }}">Verifikasi Teknis</h6>
                                <small class="text-muted">Tim Penyusun / Verifikator</small>
                                @if($status == 'Terverifikasi') <span class="badge bg-info ms-2">OK</span>
                                @elseif($status == 'Gagal Terverifikasi') <span class="badge bg-danger ms-2">Gagal</span> @endif
                            </div>
                        </div>

                        <!-- Step 4: Approval BPD -->
                        @php
                            $step4Color = $c_muted;
                            $step4Icon = 'feather-thumbs-up';
                            if ($level == 4) {
                                if ($status == 'Disetujui') {
                                    $step4Color = $c_success;
                                    $step4Icon = 'feather-check-square';
                                } elseif ($status == 'Ditolak BPD') {
                                    $step4Color = $c_danger;
                                    $step4Icon = 'feather-x-square';
                                } else {
                                    $step4Color = $c_primary;
                                    $step4Icon = 'feather-clock';
                                }
                            }
                        @endphp
                        <div class="d-flex align-items-center position-relative">
                            <div class="position-absolute start-0 top-0 translate-middle-x bg-white" style="z-index: 2;">
                                <i class="{{ $step4Icon }} fs-4 text-{{ $step4Color }}"></i>
                            </div>
                            <div class="ms-4">
                                <h6 class="mb-0 {{ $level == 4 ? 'fw-bold text-dark' : 'text-muted' }}">Approval BPD</h6>
                                <small class="text-muted">Musyawarah BPD</small>
                                @if($status == 'Disetujui') 
                                    <span class="badge bg-success ms-2">DISETUJUI</span>
                                @elseif($status == 'Ditolak BPD') 
                                    <span class="badge bg-danger ms-2">DITOLAK</span>
                                @elseif($status == 'Menunggu persetujuan BPD')
                                    <span class="badge bg-warning ms-2">Menunggu</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Timeline/Notification Log -->
             <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Riwayat & Notifikasi</h6>
                    <small class="text-muted">Desending</small>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($logs as $log)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 small fw-bold">{{ $log->judul ?? 'Update' }}</h6>
                                    <p class="mb-1 small text-muted">{{ $log->deskripsi }}</p>
                                </div>
                                <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">
                                    {{ $log->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <span class="badge bg-secondary rounded-pill" style="font-size: 0.6rem;">{{ $log->status }}</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted py-4">
                            <i class="feather-bell-off fs-4 d-block mb-2"></i>
                            <span class="small">Belum ada riwayat aktivitas</span>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .bg-purple {
        background-color: #6f42c1 !important;
        color: #fff !important;
    }
</style>
@endsection
