@extends('admin.layout')

@section('title', 'Daftar RPJM')

@section('content')
    <div class="container-fluid">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">RPJM Desa</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Daftar RPJM</li>
                    </ul>
                    @if(isset($currentUser))
                        <div class="mt-2">
                            <span class="badge bg-info text-white">Role: {{ $currentUser->role }}</span>
                        </div>
                    @endif
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                         <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                                <a href="{{ route('rpjm.create') }}" class="btn btn-md btn-primary">
                                    <i class="feather-plus me-2"></i>
                                    <span>Tambah RPJM</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->

        <!--! [Start] Main Content Card !-->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <!--! [Start] Card Header !-->
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">Data RPJM Desa Grouped by Bidang</h6>
                    </div>
                    <!--! [End] Card Header !-->

                    <!--! [Start] Card Body !-->
                    <div class="card-body p-0">
                        {{-- Hidden Form untuk 'Masuk ke RKP Desa' --}}
                        <form action="{{ route('rkp.store_from_rpjm') }}" method="POST" id="form-rkp-bulk" style="display: none;">
                            @csrf
                            <div id="bulk-inputs"></div>
                        </form>
                        
                        {{-- Button Masuk RKP hanya untuk Operator Desa / Admin --}}
                        @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                        <div class="p-3 bg-light border-bottom d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="btn-masuk-rkp" disabled>
                                <i class="feather-check-square me-1"></i> Masuk ke RKP Desa
                            </button>
                        </div>
                        @endif

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
                                        aria-labelledby="heading{{ $bidang->id_bidang }}" data-bs-parent="#accordionBidang">
                                        <div class="accordion-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            {{-- Checkbox Column only for Operator Desa --}}
                                                            @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                                                                <th width="50" class="text-center">#</th>
                                                            @endif
                                                            <th>Jenis Kegiatan</th>
                                                            <th>Lokasi</th>
                                                            <th>Volume</th>
                                                            <th>Waktu</th>
                                                            <th>Biaya</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($bidang->rpjm as $rpjm)
                                                            <tr>
                                                                {{-- Checkbox Input --}}
                                                                @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                                                                    <td class="text-center">
                                                                        @if($rpjm->status == 'Proses')
                                                                            <input type="checkbox" value="{{ $rpjm->id_rpjm }}" class="form-check-input rpjm-checkbox">
                                                                        @else
                                                                            <i class="feather-check text-success"></i>
                                                                        @endif
                                                                    </td>
                                                                @endif
                                                                
                                                                <td>{{ $rpjm->jenis_kegiatan }}</td>
                                                                <td>{{ $rpjm->lokasi }}</td>
                                                                <td>{{ $rpjm->volume }}</td>
                                                                <td>{{ $rpjm->waktu }}</td>
                                                                <td>Rp {{ number_format($rpjm->jumlah, 0, ',', '.') }}</td>
                                                                 <td>
                                                                    @php
                                                                        $statusColor = 'secondary';
                                                                        switch($rpjm->status) {
                                                                            case 'Proses': $statusColor = 'primary'; break; // Biru
                                                                            case 'Pending': $statusColor = 'warning'; break; // Kuning
                                                                            case 'Terverifikasi': $statusColor = 'purple'; break; // Ungu
                                                                            case 'Gagal Terverifikasi': $statusColor = 'danger'; break; // Merah
                                                                            case 'Disetujui': $statusColor = 'success'; break; // Hijau
                                                                            case 'Menunggu persetujuan BPD': $statusColor = 'light text-dark border'; break; // Putih
                                                                            case 'Ditolak BPD': $statusColor = 'dark'; break; // Hitam
                                                                            default: $statusColor = 'secondary';
                                                                        }
                                                                    @endphp
                                                                    <span class="badge bg-{{ $statusColor }}">{{ $rpjm->status ?? 'Proses' }}</span>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-2">
                                                                        <a href="{{ route('rpjm.show', $rpjm->id_rpjm) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                                                            <i class="feather-eye"></i>
                                                                        </a>
                                                                         @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                                                                            <a href="{{ route('rpjm.edit', $rpjm->id_rpjm) }}"
                                                                                class="btn btn-sm btn-outline-warning">
                                                                                <i class="feather-edit"></i>
                                                                            </a>
                                                                            <form action="{{ route('rpjm.destroy', $rpjm->id_rpjm) }}" method="POST"
                                                                                class="d-inline" onsubmit="return confirm('Yakin hapus RPJM ini?')">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-sm btn-outline-danger">
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
    </style>
@endsection

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
                
                if(confirm('Pindahkan item terpilih ke RKP Desa?')) {
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
                        bulkForm.submit();
                    }
                }
            });
        }
    });
</script>
@endpush
