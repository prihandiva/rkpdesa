@extends('admin.layout')

@section('title', 'Daftar RKP Desa')

@section('content')
    <div class="container-fluid">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">RKP Desa</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">RKP Desa</li>
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
                            <a href="{{ route('rkpdesa.create') }}" class="btn btn-md btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Tambah RKP</span>
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
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">Rencana Kerja Pembangunan Desa</h6>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="feather-filter me-1"></i>Filter
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="feather-download me-1"></i>Export
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!--! [Start] Table Responsive !-->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Tahun</th>
                                        <th>Judul RKP</th>
                                        <th>Berita Acara</th>
                                        <th>Status</th>
                                        <th style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rkp_desa as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->tahun ?? '-' }}</td>
                                            <td>{{ $item->nama ?? '-' }}</td>
                                            <td>
                                                @if($item->file_berita_acara_musrenbang)
                                                    <a href="{{ asset($item->file_berita_acara_musrenbang) }}" target="_blank" class="btn btn-xs btn-outline-primary">
                                                        <i class="feather-file-text me-1"></i>Lihat
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $item->status == 'Selesai' ? 'bg-success' : ($item->status == 'Berjalan' ? 'bg-primary' : 'bg-warning') }}">
                                                    {{ $item->status ?? 'Menunggu' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('rkpdesa.show', $item->id_kegiatan) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="feather-eye"></i>
                                                    </a>
                                                    <a href="{{ route('rkpdesa.edit', $item->id_kegiatan) }}"
                                                        class="btn btn-sm btn-outline-warning">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <form action="{{ route('rkpdesa.destroy', $item->id_kegiatan) }}" method="POST"
                                                        class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="feather-trash-2"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="alert alert-light mb-0" role="alert">
                                                    <i class="feather-inbox me-2"></i>Belum ada data RKP
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!--! [End] Table Responsive !-->
                    </div>
                    <!--! [End] Card Body !-->

                    <!--! [Start] Card Footer - Pagination !-->
                    <div class="card-footer bg-light border-top">
                        <nav aria-label="Page navigation" class="mb-0">
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="javascript:void(0);">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="javascript:void(0);">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!--! [End] Card Footer - Pagination !-->
                </div>
            </div>
        </div>
        <!--! [End] Main Content Card !-->
    </div>

    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
    </style>
@endsection
