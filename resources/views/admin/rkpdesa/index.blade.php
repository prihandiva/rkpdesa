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
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center">Prioritas</th>
                                        <th>Sumber</th>
                                        <th>Dusun</th>
                                        <th>Status</th>
                                        <th style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rkp_desa as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="fw-bold">{{ $item->nama }}</div>
                                            </td>
                                            <td class="text-center">
                                                @if($item->prioritas)
                                                    <span class="badge rounded-pill bg-{{ $item->prioritas >= 4 ? 'danger' : ($item->prioritas >= 3 ? 'warning text-dark' : 'success') }} fs-6">
                                                        {{ $item->prioritas }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->id_usulan)
                                                    <span class="badge bg-info text-dark">Usulan Masyarakat</span>
                                                @elseif($item->id_rpjm)
                                                    <span class="badge bg-primary">RPJM Desa</span>
                                                @else
                                                    <span class="badge bg-secondary">Lainnya</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->usulan?->dusun?->nama ?? ($item->lokasi ?? '-') }}
                                            </td>
                                            <td>
                                                @php
                                                    $status = $item->status;
                                                    $badgeClass = 'bg-secondary text-white';
                                                    
                                                    switch($status) {
                                                        case 'Proses': $badgeClass = 'bg-primary'; break;
                                                        case 'Pending': $badgeClass = 'bg-warning text-dark'; break;
                                                        case 'Terverifikasi': $badgeClass = 'bg-purple text-white'; break;
                                                        case 'Gagal Terverifikasi': $badgeClass = 'bg-danger'; break;
                                                        case 'Disetujui': $badgeClass = 'bg-success'; break;
                                                        case 'Menunggu persetujuan BPD': $badgeClass = 'bg-light text-dark border'; break;
                                                        case 'Ditolak BPD': $badgeClass = 'bg-dark text-white'; break;
                                                        default: $badgeClass = 'bg-secondary';
                                                    }
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('rkpdesa.show', $item->id_kegiatan) }}"
                                                        class="btn btn-sm btn-outline-info" title="Lihat">
                                                        <i class="feather-eye"></i>
                                                    </a>
                                                    <!-- <a href="{{ route('rkpdesa.edit', $item->id_kegiatan) }}"
                                                        class="btn btn-sm btn-outline-warning" title="Edit">
                                                        <i class="feather-edit"></i>
                                                    </a> -->
                                                    @if(auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->role == 'operator_desa'))
                                                    <form action="{{ route('rkpdesa.destroy', $item->id_kegiatan) }}" method="POST"
                                                        class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                            <i class="feather-trash-2"></i>
                                                        </button>
                                                    </form>
                                                    @endif
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
        .bg-purple {
            background-color: #6f42c1 !important;
            color: #fff !important;
        }
    </style>
@endsection
