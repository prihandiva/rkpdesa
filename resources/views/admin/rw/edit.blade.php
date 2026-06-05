@extends('admin.layout')

@section('title', 'Edit RW')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10 fw-bold text-dark">Edit RW</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rw.index') }}">RW</a></li>
                    <li class="breadcrumb-item">Edit</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold text-primary"><i class="feather-edit-2 me-2"></i>Form Edit RW</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('rw.show', $rw->id_rw) }}" class="btn btn-sm btn-outline-info">
                        <i class="feather-eye me-1"></i>Detail
                    </a>
                    <a href="{{ route('rw.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="feather-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('rw.update', $rw->id_rw) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Dusun --}}
                    <div class="mb-4">
                        <label for="id_dusun" class="form-label fw-semibold">
                            Dusun <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('id_dusun') is-invalid @enderror"
                                id="id_dusun" name="id_dusun" required>
                            <option value="">-- Pilih Dusun --</option>
                            @foreach($dusun as $d)
                                <option value="{{ $d->id_dusun }}"
                                    {{ old('id_dusun', $rw->id_dusun) == $d->id_dusun ? 'selected' : '' }}>
                                    {{ $d->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_dusun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama RW --}}
                    <div class="mb-4">
                        <label for="nama_rw" class="form-label fw-semibold">
                            Nama / Nomor RW <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nama_rw') is-invalid @enderror"
                               id="nama_rw" name="nama_rw"
                               value="{{ old('nama_rw', $rw->nama_rw) }}"
                               placeholder="Contoh: RW 01 atau RW Mawar"
                               required>
                        @error('nama_rw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="feather-save me-1"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('rw.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-semibold"><i class="feather-clock me-2 text-muted"></i>Info Data</h6>
            </div>
            <div class="card-body p-4">
                <dl class="row mb-0 small">
                    <dt class="col-5 text-muted">ID RW</dt>
                    <dd class="col-7">{{ $rw->id_rw }}</dd>
                    <dt class="col-5 text-muted">Dibuat</dt>
                    <dd class="col-7">{{ $rw->created_at ? $rw->created_at->format('d M Y H:i') : '-' }}</dd>
                    <dt class="col-5 text-muted">Diperbarui</dt>
                    <dd class="col-7 mb-0">{{ $rw->updated_at ? $rw->updated_at->format('d M Y H:i') : '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
