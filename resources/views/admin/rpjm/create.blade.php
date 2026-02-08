@extends('admin.layout')

@section('title', 'Tambah RPJM Desa')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Tambah RPJM Desa</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rpjm.index') }}">RPJM Desa</a></li>
                    <li class="breadcrumb-item">Tambah</li>
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

        <!--! [Start] Main Form Card !-->
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <!--! [Start] Card Header !-->
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Formulir RPJM Desa</h6>
                    </div>
                    <!--! [End] Card Header !-->

                    <!--! [Start] Card Body !-->
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('rpjm.store') }}">
                            @csrf

                            <!--! [Start] Form Group 1 !-->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tahun Mulai <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" placeholder="Contoh: 2025" name="tahun_mulai" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tahun Selesai <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" placeholder="Contoh: 2030" name="tahun_selesai" required>
                                </div>
                            </div>
                            <!--! [End] Form Group 1 !-->

                            <!--! [Start] Form Group 2 !-->
                            <div class="mb-3">
                                <label class="form-label">Visi <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" placeholder="Masukkan Visi" name="visi" required></textarea>
                            </div>
                            <!--! [End] Form Group 2 !-->

                             <!--! [Start] Form Group 3 !-->
                            <div class="mb-3">
                                <label class="form-label">Misi <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="5" placeholder="Masukkan Misi" name="misi" required></textarea>
                            </div>
                            <!--! [End] Form Group 3 !-->

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="Proses">Proses</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Terverifikasi">Terverifikasi</option>
                                        <option value="Disetujui">Disetujui</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prioritas (1-5)</label>
                                    <input type="number" class="form-control" name="prioritas" min="1" max="5" placeholder="1-5">
                                </div>
                            </div>

                            <!--! [Start] Form Actions !-->
                            <div class="d-flex gap-2 justify-content-between">
                                <a href="{{ route('rpjm.index') }}" class="btn btn-secondary">
                                    <i class="feather-x me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather-save me-1"></i>Simpan
                                </button>
                            </div>
                            <!--! [End] Form Actions !-->
                        </form>
                    </div>
                    <!--! [End] Card Body !-->
                </div>
            </div>

            <div class="col-lg-4">
                <!--! [Start] Info Card !-->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-light border-bottom">
                        <h6 class="mb-0">Panduan Pengisian</h6>
                    </div>
                    <div class="card-body p-3">
                        <p class="text-muted small mb-2">
                            <strong>Tahun:</strong> Pilih tahun untuk RPJM yang akan dibuat.
                        </p>
                        <p class="text-muted small mb-2">
                            <strong>Judul RPJM:</strong> Isi dengan judul rencana jangka menengah desa.
                        </p>
                        <p class="text-muted small mb-2">
                            <strong>Periode Tahun:</strong> Masukkan tahun awal dan akhir periode perencanaan (biasanya 5
                            tahun).
                        </p>
                        <p class="text-muted small mb-0">
                            <strong>Deskripsi:</strong> Jelaskan secara ringkas tentang RPJM yang direncanakan.
                        </p>
                    </div>
                </div>
                <!--! [End] Info Card !-->
            </div>
        </div>
        <!--! [End] Main Form Card !-->
    </div>
@endsection
