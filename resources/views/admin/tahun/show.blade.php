@extends('admin.layout')

@section('title', 'Detail Tahun')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Detail Tahun</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('tahun.index') }}">Tahun</a></li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="{{ route('tahun.index') }}" class="btn btn-md btn-secondary">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali</span>
                        </a>
                        <a href="{{ route('tahun.edit', $tahun->id_tahun) }}" class="btn btn-md btn-warning">
                            <i class="feather-edit me-2"></i>
                            <span>Edit</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ page-header ] end -->

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Informasi Tahun</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Tahun</th>
                                        <td class="fw-bold fs-5">{{ $tahun->tahun }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge {{ strtolower($tahun->status) == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($tahun->status ?? 'Nonaktif') }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td>{{ $tahun->keterangan ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Informasi Tambahan</h6>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-5 text-muted small">ID Tahun</dt>
                            <dd class="col-sm-7 small">{{ $tahun->id_tahun }}</dd>

                            <dt class="col-sm-5 text-muted small">Dibuat Pada</dt>
                            <dd class="col-sm-7 small">{{ $tahun->created_at ? $tahun->created_at->format('d M Y H:i') : '-' }}</dd>

                            <dt class="col-sm-5 text-muted small">Terakhir Update</dt>
                            <dd class="col-sm-7 small">{{ $tahun->updated_at ? $tahun->updated_at->format('d M Y H:i') : '-' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
