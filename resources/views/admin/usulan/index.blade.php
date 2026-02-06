@extends('admin.layout')

@section('title', 'Daftar Usulan')

@section('content')
    <div class="container-fluid">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Usulan</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Daftar Usulan</li>
                    </ul>
                    @if(isset($currentUser))
                        <div class="mt-2">
                            <span class="badge bg-info text-white">Role: {{ $currentUser->role }}</span>
                        </div>
                    @endif
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
                            @if(isset($currentUser) && ($currentUser->role == 'operator_dusun' || $currentUser->role == 'admin'))
                                <a href="{{ route('usulan.create') }}" class="btn btn-md btn-primary">
                                    <i class="feather-plus me-2"></i>
                                    <span>Tambah Usulan</span>
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

        <!--! [Start] Main Content Card !-->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <!--! [Start] Card Header !-->
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">Data Usulan Pembangunan Desa</h6>
                        <div class="btn-group" role="group">
                           {{-- Filter/Export placehodlers --}}
                        </div>
                    </div>
                    <!--! [End] Card Header !-->

                    <!--! [Start] Card Body !-->
                    <div class="card-body p-0">
                        {{-- Form pembungkus untuk 'Masuk ke RKP Desa' --}}
                        <form action="{{ route('rkp.store_from_usulan') }}" method="POST" id="form-rkp">
                            @csrf
                            
                            {{-- Button Masuk RKP hanya untuk Operator Desa / Admin --}}
                            @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                            <div class="p-3 bg-light border-bottom d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary" id="btn-masuk-rkp" disabled onclick="return confirm('Pindahkan item terpilih ke RKP Desa?')">
                                    <i class="feather-check-square me-1"></i> Masuk ke RKP Desa
                                </button>
                            </div>
                            @endif

                            <div class="accordion" id="accordionDusun">
                                @forelse($dusuns as $dusun)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $dusun->id_dusun }}">
                                            <div class="d-flex align-items-center justify-content-between w-100 p-3">
                                                <button class="accordion-button collapsed flex-grow-1 me-3" type="button" 
                                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $dusun->id_dusun }}" 
                                                    aria-expanded="false" aria-controls="collapse{{ $dusun->id_dusun }}">
                                                    {{ $dusun->nama }} <span class="badge bg-secondary ms-2">{{ $dusun->usulan->count() }} Usulan</span>
                                                </button>
                                                
                                                <!-- Aksi di baris Dusun (Optional/View Only) -->
                                            </div>
                                        </h2>
                                        <div id="collapse{{ $dusun->id_dusun }}" class="accordion-collapse collapse" 
                                            aria-labelledby="heading{{ $dusun->id_dusun }}" data-bs-parent="#accordionDusun">
                                            <div class="accordion-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                {{-- Checkbox Column only for Operator Desa --}}
                                                                @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                                                                    <th width="50" class="text-center">#</th>
                                                                @endif
                                                                <th>ID</th>
                                                                <th>Jenis Kegiatan</th>
                                                                <th>RW/RT</th>
                                                                <th>Tahun</th>
                                                                <th>Prioritas</th>
                                                                <th>Status</th>
                                                                <th>Berita Acara</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($dusun->usulan as $usulan)
                                                                <tr>
                                                                    {{-- Checkbox Input --}}
                                                                    @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                                                                        <td class="text-center">
                                                                            @if($usulan->status == 'Proses')
                                                                                <input type="checkbox" name="id_usulan[]" value="{{ $usulan->id_usulan }}" class="form-check-input usulan-checkbox">
                                                                            @else
                                                                                <i class="feather-check text-success"></i>
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                    
                                                                    <td>{{ $usulan->id_usulan }}</td>
                                                                    <td>{{ $usulan->jenis_kegiatan }}</td>
                                                                    <td>RW: {{ $usulan->id_rw }} / RT: {{ $usulan->id_rt }}</td>
                                                                    <td>{{ $usulan->tahun }}</td>
                                                                    <td>{{ $usulan->prioritas }}</td>
                                                                    <td>
                                                                        @php
                                                                            $badgeClass = 'bg-secondary';
                                                                            if($usulan->status == 'Proses') $badgeClass = 'bg-primary'; // Biru
                                                                            elseif($usulan->status == 'Pending') $badgeClass = 'bg-warning'; // Kuning (Masuk RKP)
                                                                            elseif($usulan->status == 'Terverifikasi') $badgeClass = 'bg-purple'; // Ungu (Custom CSS needed or allow purple)
                                                                            elseif($usulan->status == 'Gagal Terverifikasi') $badgeClass = 'bg-danger'; // Merah
                                                                            elseif($usulan->status == 'Disetujui') $badgeClass = 'bg-success'; // Hijau
                                                                            elseif($usulan->status == 'Menunggu persetujuan BPD') $badgeClass = 'bg-light text-dark border'; // Putih
                                                                        @endphp
                                                                        <span class="badge {{ $badgeClass }}">
                                                                            {{ $usulan->status }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        @if($usulan->file_berita_acara)
                                                                            <a href="{{ asset($usulan->file_berita_acara) }}" target="_blank" class="btn btn-xs btn-outline-primary" title="Download Berita Acara">
                                                                                <i class="feather-download"></i>
                                                                            </a>
                                                                        @else
                                                                            <span class="text-muted">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex gap-2">
                                                                            <a href="{{ route('usulan.show', $usulan->id_usulan) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                                                                <i class="feather-eye"></i> Show
                                                                            </a>
                                                                             @if(isset($currentUser) && ($currentUser->role == 'operator_dusun' || $currentUser->role == 'admin'))
                                                                                <a href="{{ route('usulan.edit', $usulan->id_usulan) }}"
                                                                                    class="btn btn-sm btn-outline-warning">
                                                                                    <i class="feather-edit"></i>
                                                                                </a>
                                                                                <form action="{{ route('usulan.destroy', $usulan->id_usulan) }}" method="POST"
                                                                                    class="d-inline" onsubmit="return confirm('Yakin hapus usulan ini?')">
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
                                                                    <td colspan="9" class="text-center py-3">Tidak ada usulan untuk dusun ini.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-3 text-center">Belum ada data dusun / Akses terbatas.</div>
                                @endforelse
                            </div>
                        </form>
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
        .bg-purple {
            background-color: #6f42c1 !important;
            color: white;
        }
    </style>
@endsection



@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.usulan-checkbox');
        const btnMasukRKP = document.getElementById('btn-masuk-rkp');

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
        }
    });
</script>
@endpush
