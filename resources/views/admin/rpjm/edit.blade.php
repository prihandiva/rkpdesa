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
                        <form action="{{ route('rpjm.update', $rpjm->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Assumed fields based on create, adjusted if needed. RPJM model fillable was empty but traditionally these fields are here -->
                             <div class="mb-3">
                                <label for="judul" class="form-label">Judul RPJM</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="judul" name="judul" value="{{ old('judul', $rpjm->judul ?? '') }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                             <div class="mb-3">
                                <label for="tahun_id" class="form-label">Tahun</label>
                                <select class="form-select @error('tahun_id') is-invalid @enderror" name="tahun_id" required>
                                    <option value="">-- Pilih Tahun --</option>
                                    @foreach(\App\Models\Tahun::all() as $t)
                                        <option value="{{ $t->id_tahun }}" {{ old('tahun_id', $rpjm->tahun_id ?? '') == $t->id_tahun ? 'selected' : '' }}>{{ $t->tahun }}</option>
                                    @endforeach
                                </select>
                                @error('tahun_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                             <div class="mb-3">
                                <label class="form-label">Periode Tahun <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Tahun Awal"
                                            name="tahun_awal" value="{{ old('tahun_awal', $rpjm->tahun_awal ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Tahun Akhir"
                                            name="tahun_akhir" value="{{ old('tahun_akhir', $rpjm->tahun_akhir ?? '') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" rows="4" placeholder="Masukkan deskripsi RPJM" name="deskripsi">{{ old('deskripsi', $rpjm->deskripsi ?? '') }}</textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('rpjm.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
