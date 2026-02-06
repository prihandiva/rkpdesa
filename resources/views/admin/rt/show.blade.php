@extends('admin.layout')

@section('title', 'Detail RT')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Detail RT</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rt.index') }}">RT</a></li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="{{ route('rt.index') }}" class="btn btn-md btn-secondary">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali</span>
                        </a>
                        <a href="{{ route('rt.edit', $rt->id_rt) }}" class="btn btn-md btn-warning">
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
                        <h6 class="mb-0">Informasi RT</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Nama RT</th>
                                        <td class="fw-bold fs-5">{{ $rt->nama_rt }}</td>
                                    </tr>
                                    <tr>
                                        <th>RW</th>
                                        <td>{{ $rt->rw->nama_rw ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dusun</th>
                                        <td>{{ $rt->dusun->nama ?? '-' }}</td>
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
                            <dt class="col-sm-5 text-muted small">ID RT</dt>
                            <dd class="col-sm-7 small">{{ $rt->id_rt }}</dd>

                            <dt class="col-sm-5 text-muted small">Dibuat Pada</dt>
                            <dd class="col-sm-7 small">{{ $rt->created_at ? $rt->created_at->format('d M Y H:i') : '-' }}</dd>

                            <dt class="col-sm-5 text-muted small">Terakhir Update</dt>
                            <dd class="col-sm-7 small">{{ $rt->updated_at ? $rt->updated_at->format('d M Y H:i') : '-' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
