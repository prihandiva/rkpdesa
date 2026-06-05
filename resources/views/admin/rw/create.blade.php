@extends('admin.layout')

@section('title', 'Tambah RW')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10 fw-bold text-dark">Tambah RW</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rw.index') }}">RW</a></li>
                    <li class="breadcrumb-item">Tambah</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold text-primary"><i class="feather-map-pin me-2"></i>Form Tambah RW</h6>
                <a href="{{ route('rw.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="feather-arrow-left me-1"></i>Kembali
                </a>
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

                <form action="{{ route('rw.store') }}" method="POST">
                    @csrf

                    {{-- Dusun --}}
                    <div class="mb-4">
                        <label for="id_dusun" class="form-label fw-semibold">
                            Dusun <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('id_dusun') is-invalid @enderror"
                                id="id_dusun" name="id_dusun" required>
                            <option value="">-- Pilih Dusun --</option>
                            @foreach($dusun as $d)
                                <option value="{{ $d->id_dusun }}" {{ old('id_dusun') == $d->id_dusun ? 'selected' : '' }}>
                                    {{ $d->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_dusun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih dusun tempat RW ini berada.</div>
                    </div>

                    {{-- Nama RW --}}
                    <div class="mb-4">
                        <label for="nama_rw" class="form-label fw-semibold">
                            Nama / Nomor RW <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nama_rw') is-invalid @enderror"
                               id="nama_rw" name="nama_rw"
                               value="{{ old('nama_rw') }}"
                               placeholder="Contoh: RW 01 atau RW Mawar"
                               required>
                        @error('nama_rw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="feather-save me-1"></i>Simpan
                        </button>
                        <a href="{{ route('rw.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Side info --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-light-primary">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="feather-info me-2 text-primary"></i>Panduan Pengisian</h6>
                <ul class="mb-0 small text-muted ps-3">
                    <li class="mb-2">Pilih <strong>Dusun</strong> tempat RW ini secara administratif berada.</li>
                    <li class="mb-2">Isi <strong>Nama/Nomor RW</strong>, misalnya <em>RW 01</em> atau <em>RW Sejahtera</em>.</li>
                    <li>Setiap RW dapat memiliki beberapa RT di bawahnya.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
