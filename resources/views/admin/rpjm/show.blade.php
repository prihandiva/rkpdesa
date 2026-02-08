@extends('admin.layout')

@section('title', 'Detail RPJM Desa')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Detail RPJM Desa</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rpjm.index') }}">RPJM Desa</a></li>
                <li class="breadcrumb-item">Detail</li>
            </ul>
        </div>
        <div class="page-header-right ms-auto">
            <a href="{{ route('rpjm.index') }}" class="btn btn-md btn-secondary">
                <i class="feather-arrow-left me-2"></i>
                <span>Kembali</span>
            </a>
            <a href="{{ route('rpjm.edit', $rpjm->id_rpjm) }}" class="btn btn-md btn-warning">
                <i class="feather-edit me-2"></i>
                <span>Edit</span>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Left Column: Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Informasi RPJM</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                             <tr>
                                <th style="width: 200px;">Periode Tahun</th>
                                <td class="fw-bold fs-5">{{ $rpjm->tahun_mulai }} - {{ $rpjm->tahun_selesai }}</td>
                            </tr>
                            <tr>
                                <th>Visi</th>
                                <td>{{ $rpjm->visi }}</td>
                            </tr>
                            <tr>
                                <th>Misi</th>
                                <td>{!! nl2br(e($rpjm->misi)) !!}</td>
                            </tr>
                            <tr>
                                <th>File Dokumen</th>
                                <td>
                                    @if($rpjm->file_dokumen)
                                        <a href="{{ asset($rpjm->file_dokumen) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="feather-file-text me-1"></i>Lihat Dokumen
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Status & Timeline -->
        <div class="col-lg-4">
            <!-- Status & Priority Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Status & Prioritas</h6>
                </div>
                <div class="card-body">
                     <!-- Priority Section -->
                    <div class="mb-4 text-center border-bottom pb-4">
                        <label class="d-block text-muted small mb-2">Prioritas</label>
                        @php
                            $prioVal = $rpjm->prioritas ?? 0;
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
                            $status = $rpjm->status;
                            
                            $level = 1; 
                            if ($status == 'Proses') $level = 1;
                            elseif ($status == 'Pending') $level = 2;
                            elseif (in_array($status, ['Terverifikasi', 'Gagal Terverifikasi'])) $level = 3;
                            elseif (in_array($status, ['Disetujui', 'Ditolak', 'Ditolak BPD'])) $level = 4;
                            
                            $c_muted = 'muted';
                            $c_primary = 'primary';
                            $c_success = 'success';
                            $c_danger = 'danger';
                        @endphp

                        <!-- Step 1: Draft / Penyusunan -->
                        <div class="d-flex align-items-center mb-4 position-relative">
                            <div class="position-absolute start-0 top-0 translate-middle-x bg-white" style="z-index: 2;">
                                <i class="feather-file-text fs-4 text-{{ $level >= 1 ? $c_primary : $c_muted }}"></i>
                            </div>
                            <div class="border-start border-3 border-{{ $level > 1 ? $c_primary : $c_muted }} position-absolute start-0 h-100" style="left: -1px; top: 10px; z-index: 1;"></div>
                            <div class="ms-4">
                                <h6 class="mb-0 {{ $level >= 1 ? 'fw-bold text-dark' : 'text-muted' }}">Penyusunan</h6>
                                <small class="text-muted">Draft Awal</small>
                                @if($status == 'Proses') <span class="badge bg-primary ms-2">Saat Ini</span> @endif
                            </div>
                        </div>

                        <!-- Step 2: Musrenbang / Pending -->
                        <div class="d-flex align-items-center mb-4 position-relative">
                            <div class="position-absolute start-0 top-0 translate-middle-x bg-white" style="z-index: 2;">
                                <i class="feather-users fs-4 text-{{ $level >= 2 ? $c_primary : $c_muted }}"></i>
                            </div>
                            <div class="border-start border-3 border-{{ $level > 2 ? $c_primary : $c_muted }} position-absolute start-0 h-100" style="left: -1px; top: 10px; z-index: 1;"></div>
                            <div class="ms-4">
                                <h6 class="mb-0 {{ $level >= 2 ? 'fw-bold text-dark' : 'text-muted' }}">Musrenbang</h6>
                                <small class="text-muted">Pembahasan Desa</small>
                                @if($status == 'Pending') <span class="badge bg-warning ms-2">Saat Ini</span> @endif
                            </div>
                        </div>

                        <!-- Step 3: Verifikasi -->
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
                                <h6 class="mb-0 {{ $level >= 3 ? 'fw-bold text-dark' : 'text-muted' }}">Verifikasi</h6>
                                <small class="text-muted">Review Teknis</small>
                                @if($status == 'Terverifikasi') <span class="badge bg-info ms-2">OK</span>
                                @elseif($status == 'Gagal Terverifikasi') <span class="badge bg-danger ms-2">Gagal</span> @endif
                            </div>
                        </div>

                        <!-- Step 4: Penetapan / Approval -->
                        @php
                            $step4Color = $c_muted;
                            $step4Icon = 'feather-award'; 
                            if ($level == 4) {
                                if ($status == 'Disetujui') {
                                    $step4Color = $c_success;
                                    $step4Icon = 'feather-check-square';
                                } elseif ($status == 'Ditolak' || $status == 'Ditolak BPD') {
                                    $step4Color = $c_danger;
                                    $step4Icon = 'feather-x-square';
                                } else {
                                    $step4Color = $c_primary;
                                }
                            }
                        @endphp
                        <div class="d-flex align-items-center position-relative">
                            <div class="position-absolute start-0 top-0 translate-middle-x bg-white" style="z-index: 2;">
                                <i class="{{ $step4Icon }} fs-4 text-{{ $step4Color }}"></i>
                            </div>
                            <div class="ms-4">
                                <h6 class="mb-0 {{ $level == 4 ? 'fw-bold text-dark' : 'text-muted' }}">Penetapan</h6>
                                <small class="text-muted">Peraturan Desa</small>
                                @if($status == 'Disetujui') 
                                    <span class="badge bg-success ms-2">DITETAPKAN</span>
                                @elseif($status == 'Ditolak' || $status == 'Ditolak BPD') 
                                    <span class="badge bg-danger ms-2">DITOLAK</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
