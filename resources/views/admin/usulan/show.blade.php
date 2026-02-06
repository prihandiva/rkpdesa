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
                                    <tr>
                                        <th>Bidang</th>
                                        <td>{{ $usulan->bidang ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $usulan->deskripsi ?? '-' }}</td> <!-- Assuming 'deskripsi' column exists or handled via logic -->
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
                        <div class="mb-4">
                            <label class="d-block text-muted small mb-2">Status Saat Ini</label>
                            <span class="badge {{ $usulan->status == 'Setuju' ? 'bg-success' : ($usulan->status == 'Tolak' ? 'bg-danger' : 'bg-warning') }} fs-6 p-2 w-100">
                                {{ $usulan->status }}
                            </span>
                        </div>
                        <div>
                            <label class="d-block text-muted small mb-2">Prioritas</label>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-info" role="progressbar" 
                                    style="width: {{ $usulan->prioritas * 20 }}%;" 
                                    aria-valuenow="{{ $usulan->prioritas }}" aria-valuemin="0" aria-valuemax="5">
                                    {{ $usulan->prioritas }} / 5
                                </div>
                            </div>
                            <small class="text-muted mt-1 d-block text-end">Skala 1 (Rendah) - 5 (Sangat Tinggi)</small>
                        </div>
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
