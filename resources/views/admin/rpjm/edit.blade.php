@extends('admin.layout')

@section('title', 'Edit RPJM Desa')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Edit RPJM Desa</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rpjm.index') }}">RPJM Desa</a></li>
                    <li class="breadcrumb-item">Edit</li>
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
                        <a href="{{ route('rpjm.index') }}" class="btn btn-md btn-secondary">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali</span>
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
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Form Edit RPJM Desa</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rpjm.update', $rpjm->id_rpjm) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tahun Mulai <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="tahun_mulai" value="{{ old('tahun_mulai', $rpjm->tahun_mulai) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tahun Selesai <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="tahun_selesai" value="{{ old('tahun_selesai', $rpjm->tahun_selesai) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Visi <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" name="visi" required>{{ old('visi', $rpjm->visi) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Misi <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="5" name="misi" required>{{ old('misi', $rpjm->misi) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="Proses" {{ $rpjm->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="Pending" {{ $rpjm->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Terverifikasi" {{ $rpjm->status == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                        <option value="Disetujui" {{ $rpjm->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prioritas (1-5)</label>
                                    <input type="number" class="form-control" name="prioritas" value="{{ old('prioritas', $rpjm->prioritas) }}" min="1" max="5" placeholder="1-5">
                                </div>
                            </div>

                            <div class="d-flex gap-2 justify-content-between">
                                <a href="{{ route('rpjm.index') }}" class="btn btn-secondary">
                                    <i class="feather-x me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather-save me-1"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
