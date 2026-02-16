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
                            @if(in_array(session('user_role'), ['tim_penyusun', 'penyusunrkp', 'admin']))
                                <button type="button" class="btn btn-md btn-warning text-dark" onclick="submitToBPD()">
                                    <i class="feather-send me-2"></i>
                                    <span>Ajukan Persetujuan BPD</span>
                                </button>
                                <form id="bulkSubmitForm" action="{{ route('rkpdesa.submit_bpd') }}" method="POST" style="display: none;">
                                    @csrf
                                    <!-- Inputs will be appended here via JS -->
                                </form>
                            @endif

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
                                <i class="feather-download me-1"></i>Export
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!-- Filter Section -->
                        <div class="p-3 border-bottom bg-light">
                            <form action="{{ route('rkpdesa.index') }}" method="GET">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <div style="min-width: 200px;">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="">Semua Status</option>
                                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="Terverifikasi" {{ request('status') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                            <option value="Gagal Terverifikasi" {{ request('status') == 'Gagal Terverifikasi' ? 'selected' : '' }}>Gagal Terverifikasi</option>
                                            <option value="Menunggu persetujuan BPD" {{ request('status') == 'Menunggu persetujuan BPD' ? 'selected' : '' }}>Menunggu persetujuan BPD</option>
                                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                            <option value="Ditolak BPD" {{ request('status') == 'Ditolak BPD' ? 'selected' : '' }}>Ditolak BPD</option>
                                            
                                        </select>
                                    </div>
                                    <div style="min-width: 150px;">
                                        <select name="jenis" class="form-select form-select-sm">
                                            <option value="">Semua Jenis</option>
                                            <option value="Fisik" {{ request('jenis') == 'Fisik' ? 'selected' : '' }}>Fisik</option>
                                            <option value="Non Fisik" {{ request('jenis') == 'Non Fisik' ? 'selected' : '' }}>Non Fisik</option>
                                        </select>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="feather-filter me-1"></i>Terapkan
                                        </button>
                                        <a href="{{ route('rkpdesa.index') }}" class="btn btn-sm btn-light border">
                                            <i class="feather-refresh-cw me-1"></i>Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!--! [Start] Table Responsive !-->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <!-- Checkbox Column -->
                                        @if(in_array(session('user_role'), ['tim_penyusun', 'penyusunrkp', 'admin']))
                                        <th style="width: 40px; text-align: center;">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                            </div>
                                        </th>
                                        @endif
                                        <th style="width: 50px;">No</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center">
                                            <a href="{{ route('rkpdesa.index', array_merge(request()->except('sort'), ['sort' => request('sort') == 'prioritas_desc' ? 'prioritas_asc' : 'prioritas_desc'])) }}" class="text-dark text-decoration-none">
                                                Prioritas
                                                <span class="d-inline-flex flex-column align-items-center ms-1" style="vertical-align: middle; line-height: 1; height: 14px; justify-content: center;">
                                                    <i class="feather-chevron-up {{ request('sort') == 'prioritas_asc' ? 'text-dark fw-bold' : 'text-muted' }}" style="font-size: 9px;"></i>
                                                    <i class="feather-chevron-down {{ request('sort') == 'prioritas_desc' ? 'text-dark fw-bold' : 'text-muted' }}" style="font-size: 9px; margin-top: -2px;"></i>
                                                </span>
                                            </a>
                                        </th>
                                        <th>Sumber</th>
                                        <th>Dusun</th>
                                        <th>Status</th>
                                        <th style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rkp_desa as $item)
                                        <tr>
                                            <!-- Checkbox Check -->
                                            @if(in_array(session('user_role'), ['tim_penyusun', 'penyusunrkp', 'admin']))
                                            <td class="text-center">
                                                @if($item->status == 'Terverifikasi')
                                                    <div class="form-check d-flex justify-content-center">
                                                        <input class="form-check-input row-checkbox" type="checkbox" value="{{ $item->id_kegiatan }}">
                                                    </div>
                                                @else
                                                    <span class="text-muted" style="font-size: 0.8em;">-</span>
                                                @endif
                                            </td>
                                            @endif
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="fw-bold">{{ $item->jenis_kegiatan }}</div>
                                            </td>
                                            <td class="text-center">
                                                @if($item->prioritas)
                                                    <span class="fs-6 fw-bold text-dark">
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
                                            <td colspan="{{ in_array(session('user_role'), ['tim_penyusun', 'penyusunrkp', 'admin']) ? 7 : 6 }}" class="text-center py-5">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            if(selectAll) {
                selectAll.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.row-checkbox');
                    checkboxes.forEach(cb => cb.checked = this.checked);
                });
            }
        });

        function submitToBPD() {
            const selected = [];
            document.querySelectorAll('.row-checkbox:checked').forEach(cb => {
                selected.push(cb.value);
            });

            if (selected.length === 0) {
                alert('Pilih setidaknya satu item yang statusnya Terverifikasi.');
                return;
            }

            if (!confirm('Apakah Anda yakin ingin mengajukan data yang dipilih (' + selected.length + ' item) untuk persetujuan BPD?')) {
                return;
            }

            const form = document.getElementById('bulkSubmitForm');
            // Remove previous inputs if any (clean state)
            form.innerHTML = '';
            
            // Add CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            // Add selected IDs
            selected.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                form.appendChild(input);
            });

            form.submit();
        }
    </script>

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
