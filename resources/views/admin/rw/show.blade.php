@extends('admin.layout')

@section('title', 'Detail RW - ' . $rw->nama_rw)

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10 fw-bold text-dark">Detail RW</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rw.index') }}">RW</a></li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Kartu Informasi Utama --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold text-primary"><i class="feather-map-pin me-2"></i>Informasi RW</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('rw.edit', $rw->id_rw) }}" class="btn btn-sm btn-warning">
                        <i class="feather-edit-2 me-1"></i>Edit
                    </a>
                    <a href="{{ route('rw.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="feather-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="small text-muted text-uppercase fw-semibold">Nama / Nomor RW</label>
                        <p class="fs-4 fw-bold text-primary mb-0">{{ $rw->nama_rw }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted text-uppercase fw-semibold">Dusun</label>
                        <p class="mb-0 fw-semibold">
                            <i class="feather-home me-1 text-muted"></i>
                            {{ $rw->dusun->nama ?? '-' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted text-uppercase fw-semibold">Jumlah RT</label>
                        <p class="mb-0">
                            <span class="badge bg-info fs-6">{{ $rw->rt->count() }} RT</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar RT di bawah RW ini --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold"><i class="feather-list me-2 text-muted"></i>Daftar RT dalam {{ $rw->nama_rw }}</h6>
            </div>
            <div class="card-body p-0">
                @if($rw->rt->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th style="width:5%">No</th>
                                    <th>Nama RT</th>
                                    <th>Dusun</th>
                                    <th class="text-center" style="width:15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rw->rt as $key => $rt)
                                    <tr>
                                        <td class="text-muted small">{{ $key + 1 }}</td>
                                        <td class="fw-semibold">{{ $rt->nama_rt }}</td>
                                        <td class="text-muted small">{{ $rt->dusun->nama ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('rt.show', $rt->id_rt) }}"
                                               class="btn btn-sm bg-light-primary text-primary border-0" title="Detail">
                                                <i class="feather-eye"></i>
                                            </a>
                                            <a href="{{ route('rt.edit', $rt->id_rt) }}"
                                               class="btn btn-sm bg-light-warning text-warning border-0" title="Edit">
                                                <i class="feather-edit-2"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-5 text-center text-muted">
                        <i class="feather-inbox d-block mb-2" style="font-size:2rem;"></i>
                        Belum ada RT yang terdaftar dalam RW ini.
                        <br>
                        <a href="{{ route('rt.create') }}" class="btn btn-sm btn-primary mt-3">
                            <i class="feather-plus me-1"></i>Tambah RT
                        </a>
                    </div>
                @endif
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
                    <dt class="col-5 text-muted">ID RW</dt>
                    <dd class="col-7 font-monospace">{{ $rw->id_rw }}</dd>

                    <dt class="col-5 text-muted">Dibuat</dt>
                    <dd class="col-7">{{ $rw->created_at ? $rw->created_at->format('d M Y H:i') : '-' }}</dd>

                    <dt class="col-5 text-muted">Diperbarui</dt>
                    <dd class="col-7 mb-0">{{ $rw->updated_at ? $rw->updated_at->format('d M Y H:i') : '-' }}</dd>
                </dl>
            </div>
        </div>

        {{-- Aksi Cepat --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-semibold"><i class="feather-zap me-2 text-muted"></i>Aksi Cepat</h6>
            </div>
            <div class="card-body p-4 d-grid gap-2">
                <a href="{{ route('rw.edit', $rw->id_rw) }}" class="btn btn-warning btn-sm">
                    <i class="feather-edit-2 me-1"></i>Edit Data RW Ini
                </a>
                <a href="{{ route('rt.create') }}" class="btn btn-outline-primary btn-sm">
                    <i class="feather-plus me-1"></i>Tambah RT Baru
                </a>
                <a href="{{ route('rw.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="feather-list me-1"></i>Semua Data RW
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
