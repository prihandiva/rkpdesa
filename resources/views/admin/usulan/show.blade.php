@extends('admin.layout')

@section('title', 'Detail Usulan')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Detail Usulan</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('usulan.index') }}">Usulan</a></li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex d-md-none">
                        <a href="javascript:void(0)" class="page-header-right-close-toggle">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="{{ route('usulan.index') }}" class="btn btn-md btn-secondary">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali</span>
                        </a>
                        <a href="{{ route('usulan.edit', $usulan->id_usulan) }}" class="btn btn-md btn-warning">
                            <i class="feather-edit me-2"></i>
                            <span>Edit</span>
                        </a>
                    </div>
                </div>
                <div class="d-md-none d-flex align-items-center">
                    <a href="javascript:void(0)" class="page-header-right-open-toggle">
                        <i class="feather-align-right fs-20"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- [ page-header ] end -->

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Informasi Usulan</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Nama Usulan / Kegiatan</th>
                                        <td class="fw-bold fs-5">{{ $usulan->jenis_kegiatan }}</td>
                                    </tr>
                                    {{-- Bidang row removed as per request --}}
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $usulan->deskripsi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi</th>
                                        <td>
                                            <ul class="list-unstyled mb-0">
                                                <li><strong>Dusun:</strong> {{ $usulan->dusun->nama ?? '-' }}</li>
                                                <li><strong>RW:</strong> {{ $usulan->rw->nama_rw ?? '-' }}</li>
                                                <li><strong>RT:</strong> {{ $usulan->rt->nama_rt ?? '-' }}</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tahun Anggaran</th>
                                        <td>{{ $usulan->tahun }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-light border-bottom">
                        <h6 class="mb-0">Status & Prioritas</h6>
                    </div>
                    <div class="card-body">
                        <!-- Priority Section -->
                        <div class="mb-4 text-center border-bottom pb-4">
                            <label class="d-block text-muted small mb-2">Prioritas Usulan</label>
                            @php
                                $prioVal = $usulan->prioritas;
                                $prioColor = match(true) {
                                    $prioVal >= 5 => 'danger',
                                    $prioVal >= 4 => 'warning',
                                    $prioVal >= 3 => 'info',
                                    default => 'success'
                                };
                            @endphp
                            <div class="d-flex justify-content-center align-items-center">
                                <h1 class="display-3 fw-bold text-{{ $prioColor }} mb-0">{{ $prioVal }}</h1>
                            </div>
                            <span class="badge bg-light text-muted border mt-2">{{ $usulan->jenis }}</span>
                        </div>

                            <!-- Vertical Timeline (Stepper) -->
                            <div class="position-relative ps-3 mt-4">
                                @php
                                    $status = $usulan->status;
                                    
                                    // Helper function to determine state
                                    // Levels: 1=Proses, 2=Pending, 3=Terverifikasi/Gagal, 4=BPD (Setuju/Tolak)
                                    $level = 1;
                                    if ($status == 'Pending') $level = 2;
                                    elseif (in_array($status, ['Terverifikasi', 'Gagal Terverifikasi'])) $level = 3;
                                    elseif (in_array($status, ['Menunggu persetujuan BPD', 'Disetujui', 'Ditolak BPD'])) $level = 4;
                                    
                                    // Override if jumping levels (e.g. direct approval)
                                    // Assuming linear flow for now based on request.
                                    
                                    // Colors
                                    $c_muted = 'muted';
                                    $c_primary = 'primary';
                                    $c_success = 'success';
                                    $c_danger = 'danger';
                                @endphp

                                <!-- Step 1: Pengajuan Usulan (Proses) -->
                                <div class="d-flex align-items-center mb-4 position-relative">
                                    <div class="position-absolute start-0 top-0 translate-middle-x bg-white" style="z-index: 2;">
                                        <i class="feather-file-text fs-4 text-{{ $level >= 1 ? $c_primary : $c_muted }}"></i>
                                    </div>
                                    <div class="border-start border-3 border-{{ $level > 1 ? $c_primary : $c_muted }} position-absolute start-0 h-100" style="left: -1px; top: 10px; z-index: 1;"></div>
                                    <div class="ms-4">
                                        <h6 class="mb-0 {{ $level >= 1 ? 'fw-bold text-dark' : 'text-muted' }}">Pengajuan Usulan</h6>
                                        <small class="text-muted">Draft Usulan Masuk</small>
                                        @if($status == 'Proses') <span class="badge bg-primary ms-2">Saat Ini</span> @endif
                                    </div>
                                </div>

                                <!-- Step 2: Usulan Diterima RKP (Pending) -->
                                <div class="d-flex align-items-center mb-4 position-relative">
                                    <div class="position-absolute start-0 top-0 translate-middle-x bg-white" style="z-index: 2;">
                                        <i class="feather-inbox fs-4 text-{{ $level >= 2 ? $c_primary : $c_muted }}"></i>
                                    </div>
                                    <div class="border-start border-3 border-{{ $level > 2 ? $c_primary : $c_muted }} position-absolute start-0 h-100" style="left: -1px; top: 10px; z-index: 1;"></div>
                                    <div class="ms-4">
                                        <h6 class="mb-0 {{ $level >= 2 ? 'fw-bold text-dark' : 'text-muted' }}">Diterima RKP</h6>
                                        <small class="text-muted">Menunggu Verifikasi</small>
                                        @if($status == 'Pending') <span class="badge bg-warning ms-2">Saat Ini</span> @endif
                                    </div>
                                </div>

                                <!-- Step 3: Verifikasi (Terverifikasi/Gagal) -->
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
                                        <small class="text-muted">Desa/Tim RKP</small>
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
                                            $step4Color = $c_primary; // Menunggu BPD
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
                                        <small class="text-muted">Keputusan Akhir</small>
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
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Riwayat Usulan</h6>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($logs as $log)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="me-2">
                                        <h6 class="mb-1 small fw-bold">{{ $log->judul ?? 'Update' }}</h6>
                                        <p class="mb-1 small text-muted">{{ $log->deskripsi }}</p>
                                    </div>
                                    <div class="text-end" style="min-width: 80px;">
                                        <span class="badge bg-light text-dark border d-block mb-1" style="font-size: 0.65rem;">
                                            {{ $log->created_at->format('H:i') }}
                                        </span>
                                        <span class="text-muted" style="font-size: 0.6rem;">{{ $log->created_at->format('d M') }}</span>
                                    </div>
                                </div>
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

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Informasi Tambahan</h6>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-5 text-muted small">Dibuat Pada</dt>
                            <dd class="col-sm-7 small">{{ $usulan->created_at ? $usulan->created_at->format('d M Y H:i') : '-' }}</dd>

                            <dt class="col-sm-5 text-muted small">Terakhir Update</dt>
                            <dd class="col-sm-7 small">{{ $usulan->updated_at ? $usulan->updated_at->format('d M Y H:i') : '-' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
