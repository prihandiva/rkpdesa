@extends('admin.layout')

@section('title', 'Detail Dusun')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Detail Dusun</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dusun.index') }}">Dusun</a></li>
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
                        <a href="{{ route('dusun.index') }}" class="btn btn-md btn-secondary">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali</span>
                        </a>
                        <a href="{{ route('dusun.edit', $dusun->id_dusun) }}" class="btn btn-md btn-warning">
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
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Informasi Dusun</h6>
                    </div>
                    <div class="card-body">
                         <div class="row mb-4">
                            <div class="col-sm-3 text-muted">Nama Dusun</div>
                            <div class="col-sm-9 fw-bold">{{ $dusun->nama }}</div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-3 text-muted">Jumlah RW</div>
                            <div class="col-sm-9">{{ $dusun->class_rw ?? 0 }} RW</div>
                        </div>

                        <hr>
                        <h6 class="mb-3">Daftar Usulan di Dusun Ini</h6>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Jenis Kegiatan</th>
                                        <th>Tahun</th>
                                        <th>Prioritas</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dusun->usulan as $usulan)
                                        <tr>
                                            <td>{{ $usulan->jenis_kegiatan }}</td>
                                            <td>{{ $usulan->tahun }}</td>
                                            <td>{{ $usulan->prioritas }}</td>
                                            <td>
                                                <span class="badge {{ $usulan->status == 'Setuju' ? 'bg-success' : ($usulan->status == 'Tolak' ? 'bg-danger' : 'bg-warning') }}">
                                                    {{ $usulan->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('usulan.show', $usulan->id_usulan) }}"  class="btn btn-sm btn-outline-info">
                                                    <i class="feather-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-3">Tidak ada usulan untuk dusun ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
