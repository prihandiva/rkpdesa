@extends('admin.layout')

@section('title', 'Daftar RPJM')

@section('content')
    <div class="container-fluid">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10 fw-bold text-dark">RPJM Desa</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Daftar RPJM</li>
                    </ul>
                    @if(isset($currentUser))
                        <div class="mt-2">
                            <!-- <span class="badge bg-info text-white">Role: {{ $currentUser->role }}</span> -->
                        </div>
                    @endif
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                         <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                                <button type="button" class="btn btn-md btn-outline-success shadow-sm me-2 btn-cetak-rpjm" data-bs-toggle="modal" data-bs-target="#exportExcelRpjmModal">
                                    <i class="feather-printer me-2"></i>
                                    <span>Cetak RPJM (Excel)</span>
                                </button>
                                <a href="{{ route('rpjm.create') }}" class="btn btn-md btn-primary shadow-sm">
                                    <i class="feather-plus me-2"></i>
                                    <span>Tambah RPJM</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->
        <!--! [Start] Info Guide Card !-->
        @include('admin.components.info-card', [
            'icon'  => 'feather-book-open',
            'title' => 'Panduan pengisian data RPJM Desa',
            'steps' => [
                ['text' => 'Operator Desa dapat menambahkan data baru dengan klik button {BTN:feather-plus:Tambah RPJM:primary}'],
                ['text' => 'Lihat Detail {BTN:feather-eye::info}, Edit {BTN:feather-edit::warning}, dan Hapus {BTN:feather-trash-2::danger} tersedia pada setiap baris data'],
                ['text' => 'Unduh seluruh data dalam format Excel dengan klik {BTN:feather-printer:Cetak RPJM (Excel):success} lalu pilih Periode yang diinginkan'],
            ]
        ])
        <!--! [End] Info Guide Card !-->

        <!--! [Start] Main Content Card !-->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <!--! [Start] Card Header !-->
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between p-4">
                        <h6 class="m-0 fw-bold text-primary">Data RPJM Desa</h6>
                    </div>
                    <!--! [End] Card Header !-->
                    
                    <!-- Filter Section -->
                    <div class="card-body border-bottom bg-light py-2">
                        <form method="GET" action="{{ route('rpjm.index') }}" class="d-flex align-items-center gap-2">
                            <label class="form-label mb-0 fw-bold">Filter Periode:</label>
                            <select name="periode" class="form-select form-select-sm" style="width: auto; min-width: 150px;" onchange="this.form.submit()">
                                <option value="">Semua Periode</option>
                                @foreach($periodes ?? [] as $p)
                                    <option value="{{ $p }}" {{ request('periode') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <!--! [Start] Card Body !-->
                    <div class="card-body p-0">
                        {{-- Hidden Form untuk 'Masuk ke RKP Desa' --}}
                        <form action="{{ route('rkp.store_from_rpjm') }}" method="POST" id="form-rkp-bulk" style="display: none;">
                            @csrf
                            <div id="bulk-inputs"></div>
                        </form>
                        
                        {{-- Button Masuk RKP hanya untuk Operator Desa / Admin --}}
                        {{-- @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                        <div class="p-3 bg-light border-bottom d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="btn-masuk-rkp" disabled>
                                <i class="feather-check-square me-1"></i> Masuk ke RKP Desa
                            </button>
                        </div>
                        @endif --}}

                        <div class="accordion" id="accordionBidang">
                            @forelse($bidangs as $bidang)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $bidang->id_bidang }}">
                                        <div class="d-flex align-items-center justify-content-between w-100 p-3">
                                            <button class="accordion-button collapsed flex-grow-1 me-3" type="button" 
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $bidang->id_bidang }}" 
                                                aria-expanded="false" aria-controls="collapse{{ $bidang->id_bidang }}">
                                                {{ $bidang->nama }} <span class="badge bg-secondary ms-2">{{ $bidang->rpjm->count() }} Kegiatan</span>
                                            </button>
                                        </div>
                                    </h2>
                                    <div id="collapse{{ $bidang->id_bidang }}" class="accordion-collapse collapse" 
                                        aria-labelledby="heading{{ $bidang->id_bidang }}">
                                        <div class="accordion-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            {{-- Checkbox Column only for Operator Desa --}}
                                                            {{-- @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                                                                <th width="50" class="text-center">#</th>
                                                            @endif --}}
                                                            <th style="min-width: 220px; max-width: 320px;">Jenis Kegiatan</th>
                                                            <th>Lokasi</th>
                                                            <th>Volume</th>
                                                            <th>Tahun ke-</th>
                                                            <th>Biaya</th>
                                                            <!-- <th>Status</th> -->
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($bidang->rpjm as $rpjm)
                                                            <tr>
                                                                {{-- Checkbox Input --}}
                                                                {{-- @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                                                                    <td class="text-center">
                                                                        @if($rpjm->status == 'Proses')
                                                                            <input type="checkbox" value="{{ $rpjm->id_rpjm }}" class="form-check-input rpjm-checkbox">
                                                                        @else
                                                                            <i class="feather-check text-success"></i>
                                                                        @endif
                                                                    </td>
                                                                @endif --}}
                                                                
                                                                <td style="min-width: 220px; max-width: 320px; white-space: normal; word-break: break-word;">{{ $rpjm->jenis_kegiatan }}</td>
                                                                <td>{{ $rpjm->lokasi }}</td>
                                                                <td>{{ $rpjm->volume }}</td>
                                                                <td>{{ $rpjm->tahun_pelaksanaan ? 'Tahun ke-' . $rpjm->tahun_pelaksanaan : '-' }}</td>
                                                                <td>Rp {{ number_format($rpjm->jumlah, 0, ',', '.') }}</td>
                                                                 <!-- <td>
                                                                    @php
                                                                        $statusColor = 'secondary';
                                                                        switch($rpjm->status) {
                                                                            case 'Proses': $statusColor = 'primary'; break; // Biru
                                                                            case 'Pending': $statusColor = 'warning'; break; // Kuning
                                                                            case 'Terverifikasi': $statusColor = 'purple'; break; // Ungu
                                                                            case 'Gagal Terverifikasi': $statusColor = 'danger'; break; // Merah
                                                                            case 'Disetujui': $statusColor = 'success'; break; // Hijau
                                                                            case 'Menunggu persetujuan BPD': $statusColor = 'light text-dark border'; break; // Putih
                                                                            case 'Ditolak': $statusColor = 'dark'; break; // Hitam
                                                                            default: $statusColor = 'secondary';
                                                                        }
                                                                    @endphp
                                                                    <span class="badge bg-{{ $statusColor }}">{{ $rpjm->status ?? 'Proses' }}</span>
                                                                </td> -->
                                                                <td>
                                                                    <div class="d-flex gap-2">
                                                                        <a href="{{ route('rpjm.show', $rpjm->id_rpjm) }}" class="btn btn-sm bg-light-info text-info border-0" title="Detail">
                                                                            <i class="feather-eye"></i>
                                                                        </a>
                                                                         @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                                                                            <a href="{{ route('rpjm.edit', $rpjm->id_rpjm) }}"
                                                                                class="btn btn-sm bg-light-warning text-warning border-0" title="Edit">
                                                                                <i class="feather-edit"></i>
                                                                            </a>
                                                                            <form action="{{ route('rpjm.destroy', $rpjm->id_rpjm) }}" method="POST"
                                                                                class="d-inline" data-name="{{ $rpjm->jenis_kegiatan }}">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-sm bg-light-danger text-danger border-0" title="Hapus">
                                                                                    <i class="feather-trash-2"></i>
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8" class="text-center py-3">Tidak ada kegiatan untuk bidang ini.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-3 text-center">Belum ada data bidang.</div>
                            @endforelse
                        </div>
                    </div>
                    <!--! [End] Card Body !-->
                </div>
            </div>
        </div>
        <!--! [End] Main Content Card !-->
    </div>

    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
        .btn-cetak-rpjm {
            transition: all 0.2s ease-in-out;
        }
        .btn-cetak-rpjm:hover {
            background-color: #198754;
            color: #fff;
        }
    </style>
@endsection

@push('modals')
<!-- Modal Export Excel RPJM -->
<div class="modal fade" id="exportExcelRpjmModal" tabindex="-1" aria-labelledby="exportExcelRpjmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('rpjm.export_excel') }}" method="GET" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportExcelRpjmModalLabel">
                        <i class="feather-printer me-2 text-success"></i>Cetak RPJM (Excel)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="export_rpjm_periode" class="form-label fw-bold">Pilih Periode</label>
                        <select name="periode" id="export_rpjm_periode" class="form-select">
                            <option value="">Semua Periode</option>
                            @foreach($periodes ?? [] as $p)
                                <option value="{{ $p }}" {{ request('periode') == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                        <div class="form-text text-muted">Pilih periode untuk mencetak data RPJM tertentu, atau biarkan "Semua Periode" untuk mencetak seluruh data.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="feather-download me-2"></i>Unduh Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.rpjm-checkbox');
        const btnMasukRKP = document.getElementById('btn-masuk-rkp');
        const bulkForm = document.getElementById('form-rkp-bulk');
        const bulkInputsContainer = document.getElementById('bulk-inputs');

        if(btnMasukRKP) {
            function updateButtonState() {
                let anyChecked = false;
                checkboxes.forEach(chk => {
                    if(chk.checked) anyChecked = true;
                });
                
                if(anyChecked) {
                    btnMasukRKP.removeAttribute('disabled');
                } else {
                    btnMasukRKP.setAttribute('disabled', 'disabled');
                }
            }

            checkboxes.forEach(chk => {
                chk.addEventListener('change', updateButtonState);
            });

            btnMasukRKP.addEventListener('click', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Pindahkan ke RKP Desa?',
                    text: 'Item terpilih akan dipindahkan ke RKP Desa.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4b3bdb',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Pindahkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Clear previous inputs
                        bulkInputsContainer.innerHTML = '';
                        
                        let hasItems = false;
                        checkboxes.forEach(chk => {
                            if(chk.checked) {
                                hasItems = true;
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'id_rpjm[]';
                                input.value = chk.value;
                                bulkInputsContainer.appendChild(input);
                            }
                        });

                        if(hasItems) {
                            Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                            bulkForm.submit();
                        }
                    }
                });
            });
        }
    });
</script>
@endpush
