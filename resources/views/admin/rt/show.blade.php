@extends('admin.layout')

@section('title', 'Detail RT - ' . $rt->nama_rt)

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10 fw-bold text-dark">Detail RT</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rt.index') }}">RT</a></li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Kartu Informasi Utama --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold text-primary"><i class="feather-map-pin me-2"></i>Informasi RT</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('rt.edit', $rt->id_rt) }}" class="btn btn-sm btn-warning">
                        <i class="feather-edit-2 me-1"></i>Edit
                    </a>
                    <a href="{{ route('rt.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="feather-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                {{-- Nama RT besar --}}
                <div class="mb-4">
                    <label class="small text-muted text-uppercase fw-semibold">Nama / Nomor RT</label>
                    <p class="fs-3 fw-bold text-primary mb-0">{{ $rt->nama_rt }}</p>
                </div>

                <div class="row g-3">
                    {{-- Dusun --}}
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <label class="small text-muted text-uppercase fw-semibold d-block mb-1">
                                <i class="feather-home me-1"></i>Dusun
                            </label>
                            <p class="fw-semibold mb-0 fs-6">
                                {{ $rt->dusun->nama ?? '-' }}
                            </p>
                        </div>
                    </div>

                    {{-- RW --}}
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <label class="small text-muted text-uppercase fw-semibold d-block mb-1">
                                <i class="feather-map-pin me-1"></i>RW
                            </label>
                            <p class="fw-semibold mb-0 fs-6">
                                @if($rt->rw)
                                    <a href="{{ route('rw.show', $rt->rw->id_rw) }}" class="text-decoration-none">
                                        {{ $rt->rw->nama_rw }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Hierarki Wilayah --}}
                <div class="mt-4 p-3 border rounded-3 bg-light-primary">
                    <label class="small text-muted text-uppercase fw-semibold d-block mb-2">
                        <i class="feather-git-branch me-1"></i>Hierarki Wilayah
                    </label>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="badge bg-secondary">{{ $rt->dusun->nama ?? 'Dusun -' }}</span>
                        <i class="feather-chevron-right text-muted" style="font-size:12px;"></i>
                        <span class="badge bg-info">{{ $rt->rw->nama_rw ?? 'RW -' }}</span>
                        <i class="feather-chevron-right text-muted" style="font-size:12px;"></i>
                        <span class="badge bg-primary">{{ $rt->nama_rt }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Informasi Tambahan --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-semibold"><i class="feather-info me-2 text-muted"></i>Informasi Tambahan</h6>
            </div>
            <div class="card-body p-4">
                <dl class="row mb-0 small">
                    <dt class="col-5 text-muted">ID RT</dt>
                    <dd class="col-7 font-monospace">{{ $rt->id_rt }}</dd>

                    <dt class="col-5 text-muted">ID RW</dt>
                    <dd class="col-7 font-monospace">{{ $rt->id_rw }}</dd>

                    <dt class="col-5 text-muted">ID Dusun</dt>
                    <dd class="col-7 font-monospace">{{ $rt->id_dusun }}</dd>

                    <dt class="col-5 text-muted">Dibuat</dt>
                    <dd class="col-7">{{ $rt->created_at ? $rt->created_at->format('d M Y H:i') : '-' }}</dd>

                    <dt class="col-5 text-muted">Diperbarui</dt>
                    <dd class="col-7 mb-0">{{ $rt->updated_at ? $rt->updated_at->format('d M Y H:i') : '-' }}</dd>
                </dl>
            </div>
        </div>

        {{-- Aksi Cepat --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-semibold"><i class="feather-zap me-2 text-muted"></i>Aksi Cepat</h6>
            </div>
            <div class="card-body p-4 d-grid gap-2">
                <a href="{{ route('rt.edit', $rt->id_rt) }}" class="btn btn-warning btn-sm">
                    <i class="feather-edit-2 me-1"></i>Edit Data RT Ini
                </a>
                @if($rt->rw)
                    <a href="{{ route('rw.show', $rt->rw->id_rw) }}" class="btn btn-outline-info btn-sm">
                        <i class="feather-eye me-1"></i>Lihat RW {{ $rt->rw->nama_rw }}
                    </a>
                @endif
                <a href="{{ route('rt.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="feather-list me-1"></i>Semua Data RT
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
