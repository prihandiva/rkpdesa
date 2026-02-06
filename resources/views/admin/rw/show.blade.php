@extends('admin.layout')

@section('title', 'Detail RW')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Detail RW</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rw.index') }}">RW</a></li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="{{ route('rw.index') }}" class="btn btn-md btn-secondary">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali</span>
                        </a>
                        <a href="{{ route('rw.edit', $item->id_rw ?? $rw->id_rw) }}" class="btn btn-md btn-warning">
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
                        <h6 class="mb-0">Informasi RW</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Nama RW</th>
                                        <td class="fw-bold fs-5">{{ $rw->nama_rw }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dusun</th>
                                        <td>{{ $rw->dusun->nama ?? '-' }}</td>
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
                            <dt class="col-sm-5 text-muted small">ID RW</dt>
                            <dd class="col-sm-7 small">{{ $rw->id_rw }}</dd>

                            <dt class="col-sm-5 text-muted small">Dibuat Pada</dt>
                            <dd class="col-sm-7 small">{{ $rw->created_at ? $rw->created_at->format('d M Y H:i') : '-' }}</dd>

                            <dt class="col-sm-5 text-muted small">Terakhir Update</dt>
                            <dd class="col-sm-7 small">{{ $rw->updated_at ? $rw->updated_at->format('d M Y H:i') : '-' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
