@extends('admin.layout')

@section('title', 'Daftar RKP Desa')

@section('content')
    <div class="container-fluid">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10 fw-bold text-dark">RKP Desa</h5>
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
                            <form method="GET" action="{{ route('rkpdesa.index') }}" class="d-flex align-items-center gap-2 me-2">
                                <label for="tahun" class="small fw-bold text-muted mb-0">Tahun:</label>
                                <select name="tahun" id="tahun" class="form-select form-select-sm" style="min-width: 120px;" onchange="this.form.submit()">
                                    @foreach($tahuns as $th)
                                        <option value="{{ $th->id_tahun }}" {{ $selectedTahunId == $th->id_tahun ? 'selected' : '' }}>
                                            {{ $th->tahun }} {{ $th->status == 'Aktif' ? '★' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                            @if(in_array(session('user_role'), ['tim_penyusun', 'penyusunrkp', 'admin']))
                                <button type="button" class="btn btn-md btn-warning shadow-sm text-dark" onclick="submitToBPD()">
                                    <i class="feather-send me-2"></i>
                                    <span>Ajukan Persetujuan BPD</span>
                                </button>
                                <form id="bulkSubmitForm" action="{{ route('rkpdesa.submit_bpd') }}" method="POST" style="display: none;">
                                    @csrf
                                    <!-- Inputs will be appended here via JS -->
                                </form>
                            @endif

                            @if(in_array(session('user_role'), ['operator_desa', 'admin']))
                                <a href="{{ route('rkpdesa.create') }}" class="btn btn-md btn-primary shadow-sm">
                                    <i class="feather-plus me-2"></i>
                                    <span>Tambah RKP</span>
                                </a>
                            @endif
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

        <!--! [Start] Info Guide Card !-->
        @include('admin.components.info-card', [
            'icon'  => 'feather-layers',
            'title' => 'Panduan alur verifikasi dan penyusunan RKP Desa',
            'steps' => [
                ['text' => 'Operator Desa input prioritas: klik {BTN:feather-eye::info} pada setiap kegiatan, lalu klik icon {BTN:feather-edit::secondary} di bagian Prioritas'],
                ['text' => 'Tim Verifikator buka {BTN:feather-eye::info} setiap kegiatan, isi bagian Verifikasi Usulan dengan status {BTN:feather-clock:Pending:warning} {BTN:feather-check:Terverifikasi:success} {BTN:feather-x:Gagal Terverifikasi:danger} beserta Catatan Verifikasi'],
                ['text' => 'Tim Penyusun RKP melengkapi data kegiatan berstatus {BTN:feather-check:Terverifikasi:success} dengan buka {BTN:feather-eye::info} lalu klik {BTN:feather-edit:Edit Data RKP:success} - perhatikan kolom Kelengkapan untuk melihat persentase pengisian data (icon {BTN:feather-check-circle::success} muncul jika 100% lengkap)'],
                ['text' => 'Centang kegiatan {BTN:feather-check-square::secondary} lalu klik {BTN:feather-send:Ajukan Persetujuan BPD:warning} - status berubah menjadi Menunggu Persetujuan BPD dan dapat dicetak sebagai Rancangan RKP Desa'],
                ['text' => 'BPD melakukan approval akhir: buka {BTN:feather-eye::info} setiap kegiatan, pilih {BTN:feather-check:Disetujui:success} atau {BTN:feather-x:Ditolak:danger} sebagai status final'],
            ]
        ])
        <!--! [End] Info Guide Card !-->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between p-4">
                        <h6 class="m-0 fw-bold text-primary">Rencana Kerja Pembangunan Desa</h6>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#exportRkpdesaModal">
                                <i class="feather-download me-1"></i>Cetak RKP Desa
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!-- Filter Section -->
                        <div class="p-3 border-bottom bg-light">
                            <form action="{{ route('rkpdesa.index') }}" method="GET">
                                <!-- Pertahankan parameter pencarian/tahun jika ada -->
                                @if(request('tahun'))
                                    <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                                @endif
                                
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <div style="min-width: 120px;">
                                        <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="10" {{ request('per_page', '10') == '10' ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                                            <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Semua</option>
                                        </select>
                                    </div>
                                    <div style="min-width: 200px;">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="">Semua Status</option>
                                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="Terverifikasi" {{ request('status') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                            <option value="Gagal Terverifikasi" {{ request('status') == 'Gagal Terverifikasi' ? 'selected' : '' }}>Gagal Terverifikasi</option>
                                            <option value="Menunggu persetujuan BPD" {{ request('status') == 'Menunggu persetujuan BPD' ? 'selected' : '' }}>Menunggu persetujuan BPD</option>
                                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            
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
                                        <th>Kegiatan</th>
                                        <th style="width: 150px;">Kelengkapan</th>
                                        <th class="text-center">
                                            <a href="{{ route('rkpdesa.index', array_merge(request()->except('sort'), ['sort' => request('sort') == 'prioritas_desc' ? 'prioritas_asc' : 'prioritas_desc'])) }}" class="text-dark text-decoration-none">
                                                Prioritas
                                                <span class="d-inline-flex flex-column align-items-center ms-1" style="vertical-align: middle; line-height: 1; height: 14px; justify-content: center;">
                                                    <i class="feather-chevron-up {{ request('sort') == 'prioritas_asc' ? 'text-dark fw-bold' : 'text-muted' }}" style="font-size: 9px;"></i>
                                                    <i class="feather-chevron-down {{ request('sort') == 'prioritas_desc' ? 'text-dark fw-bold' : 'text-muted' }}" style="font-size: 9px; margin-top: -2px;"></i>
                                                </span>
                                            </a>
                                        </th>
                                        <!-- <th>Sumber</th> -->
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
                                                <div class="fw-bold text-dark" style="max-width: 250px; white-space: normal;">
                                                    {{ $item->jenis_kegiatan }}
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $completion = $item->completion_percentage;
                                                    $isComplete = $item->isComplete();
                                                @endphp
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="progress flex-grow-1" style="height: 6px; background-color: #e9ecef; border-radius: 10px;">
                                                        <div class="progress-bar {{ $isComplete ? 'bg-success' : 'bg-primary' }}" role="progressbar" style="width: {{ $completion }}%; border-radius: 10px;" aria-valuenow="{{ $completion }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <small class="text-muted fw-bold" style="font-size: 11px; width: 30px; text-align: right;">{{ $completion }}%</small>
                                                    @if($isComplete)
                                                        <i class="feather-check-circle text-success" style="font-size: 14px;" title="Data Lengkap & Siap Diajukan ke BPD"></i>
                                                    @endif
                                                </div>
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
                                            <!-- <td>
                                                @if($item->id_usulan)
                                                    <span class="badge bg-info text-dark">Usulan Masyarakat</span>
                                                @elseif($item->id_rpjm)
                                                    <span class="badge bg-primary">RPJM Desa</span>
                                                @else
                                                    <span class="badge bg-secondary">Lainnya</span>
                                                @endif
                                            </td> -->
                                            <td>
                                                {{ $item->usulan?->dusun?->nama ?? ($item->lokasi ?? '-') }}
                                            </td>
                                            <td>
                                                @php
                                                    $status = $item->status;
                                                    $badgeClass = 'bg-secondary text-white';
                                                    
                                                    switch($status) {
                                                        case 'Proses': $badgeClass = 'badge-status-proses'; break;
                                                        case 'Pending': $badgeClass = 'badge-status-pending'; break;
                                                        case 'Terverifikasi': $badgeClass = 'badge-status-terverifikasi'; break;
                                                        case 'Gagal Terverifikasi': $badgeClass = 'badge-status-gagal'; break;
                                                        case 'Disetujui': $badgeClass = 'badge-status-disetujui'; break;
                                                        case 'Menunggu persetujuan BPD': $badgeClass = 'badge-status-menunggu-bpd'; break;
                                                        case 'Ditolak': $badgeClass = 'badge-status-ditolak-bpd'; break;
                                                        default: $badgeClass = 'bg-secondary text-white';
                                                    }
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('rkpdesa.show', $item->id_kegiatan) }}"
                                                        class="btn btn-sm bg-light-info text-info border-0" title="Lihat">
                                                        <i class="feather-eye"></i>
                                                    </a>
                                                    <!-- <a href="{{ route('rkpdesa.edit', $item->id_kegiatan) }}"
                                                        class="btn btn-sm bg-light-warning text-warning border-0" title="Edit">
                                                        <i class="feather-edit"></i>
                                                    </a> -->
                                                    @if(in_array(strtolower(session('user_role')), ['admin', 'operator_desa']) || (auth()->check() && in_array(auth()->user()->role, ['admin', 'operator_desa'])))
                                                    <form action="{{ route('rkpdesa.destroy', $item->id_kegiatan) }}" method="POST"
                                                        class="d-inline" data-name="{{ $item->jenis_kegiatan }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm bg-light-danger text-danger border-0" title="Hapus Sementara">
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
                    @if ($rkp_desa->hasPages())
                        <div class="card-footer bg-light border-top">
                            {{ $rkp_desa->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
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
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Pilih setidaknya satu item yang statusnya Terverifikasi.',
                    confirmButtonColor: '#4b3bdb'
                });
                return;
            }

            Swal.fire({
                title: 'Ajukan ke BPD?',
                text: 'Apakah Anda yakin ingin mengajukan data yang dipilih (' + selected.length + ' item) untuk persetujuan BPD?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Ajukan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
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

                    Swal.fire({
                        title: 'Memproses...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    form.submit();
                }
            });
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

    @push('modals')
    <!-- Modal Export Excel -->
    <div class="modal fade" id="exportRkpdesaModal" tabindex="-1" aria-labelledby="exportRkpdesaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('rkpdesa.export_excel') }}" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportRkpdesaModalLabel">Cetak RKP Desa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="export_tahun" class="form-label">Tahun</label>
                            <select name="tahun" id="export_tahun" class="form-select">
                                <option value="">Semua Tahun</option>
                                @foreach($tahuns as $th)
                                    <option value="{{ $th->tahun }}">{{ $th->tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="export_status" class="form-label">Status (Jenis Cetakan)</label>
                            <select name="status" id="export_status" class="form-select">
                                <option value="Disetujui">Rencana Kerja Pemerintahan Desa (Disetujui)</option>
                                <option value="Menunggu persetujuan BPD">Rancangan Rencana Kerja Pemerintahan Desa (Menunggu Persetujuan BPD)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success"><i class="feather-printer me-2"></i>Cetak Excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endpush
@endsection
