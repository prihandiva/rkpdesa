@extends('admin.layout')

@section('title', 'Daftar Usulan')

@section('content')
    <div class="container-fluid">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10 fw-bold text-dark">Usulan</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Daftar Usulan</li>
                    </ul>
                    @if(isset($currentUser))
                        <div class="mt-2">
                            <!-- <span class="badge bg-info text-white">Role: {{ $currentUser->role }}</span> -->
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
                            <form method="GET" action="{{ route('usulan.index') }}" class="d-flex align-items-center gap-2 me-2">
                                <label for="tahun" class="small fw-bold text-muted mb-0">Tahun:</label>
                                <select name="tahun" id="tahun" class="form-select form-select-sm" style="min-width: 120px;" onchange="this.form.submit()">
                                    @foreach($tahuns as $th)
                                        <option value="{{ $th->id_tahun }}" {{ $selectedTahunId == $th->id_tahun ? 'selected' : '' }}>
                                            {{ $th->tahun }} {{ $th->status == 'Aktif' ? '★' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                            @if(isset($currentUser) && ($currentUser->role == 'operator_dusun' || $currentUser->role == 'admin'))
                                <a href="{{ route('usulan.create') }}" class="btn btn-md btn-primary shadow-sm">
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
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between p-4">
                        <h6 class="m-0 fw-bold text-primary">Data Usulan Pembangunan Desa</h6>
                        <div class="btn-group" role="group">
                           {{-- Filter/Export placehodlers --}}
                        </div>
                    </div>
                    <!--! [End] Card Header !-->

                    <!--! [Start] Card Body !-->
                    <div class="card-body p-0">
                        {{-- Form pembungkus untuk 'Masuk ke RKP Desa' --}}
                        <form action="{{ route('rkp.store_from_usulan') }}" method="POST" id="form-rkp" class="no-swal">
                            @csrf
                            
                            {{-- Button Masuk RKP hanya untuk Operator Desa / Admin --}}
                            @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                            <div class="p-3 bg-light border-bottom d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary" id="btn-masuk-rkp" disabled>
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
                                            aria-labelledby="heading{{ $dusun->id_dusun }}">
                                            <div class="accordion-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                {{-- Checkbox Column only for Operator Desa --}}
                                                                @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                                                                    <th width="50" class="text-center">#</th>
                                                                @endif
                                                                <th>No</th>
                                                                <th>Jenis Kegiatan</th>
                                                                <th>RW/RT</th>
                                                                <th>Tahun</th>
                                                                <th>Prioritas</th>
                                                                <th>Status</th>
                                                                <!-- <th>Berita Acara</th> -->
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
                                                                    
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $usulan->jenis_kegiatan }}</td>
                                                                    <td>RW: {{ $usulan->id_rw }} / RT: {{ $usulan->id_rt }}</td>
                                                                    <td>{{ $usulan->tahun }}</td>
                                                                    <td>{{ $usulan->prioritas }}</td>
                                                                    <td>
                                                                        @php
                                                                            $status = $usulan->status;
                                                                            $badgeClass = 'bg-secondary text-white';
                                                                            
                                                                            switch($status) {
                                                                                case 'Proses': 
                                                                                    $badgeClass = 'badge-status-proses';
                                                                                    break;
                                                                                case 'Pending': 
                                                                                    $badgeClass = 'badge-status-pending';
                                                                                    break;
                                                                                case 'Terverifikasi': 
                                                                                    $badgeClass = 'badge-status-terverifikasi';
                                                                                    break;
                                                                                case 'Gagal Terverifikasi': 
                                                                                    $badgeClass = 'badge-status-gagal';
                                                                                    break;
                                                                                case 'Disetujui': 
                                                                                    $badgeClass = 'badge-status-disetujui';
                                                                                    break;
                                                                                case 'Menunggu persetujuan BPD': 
                                                                                    $badgeClass = 'badge-status-menunggu-bpd';
                                                                                    break;
                                                                                case 'Ditolak BPD': 
                                                                                    $badgeClass = 'badge-status-ditolak-bpd';
                                                                                    break;
                                                                                default:
                                                                                    $badgeClass = 'bg-secondary text-white';
                                                                            }
                                                                        @endphp
                                                                        <span class="badge {{ $badgeClass }}">
                                                                            {{ $usulan->status }}
                                                                        </span>
                                                                    </td>
                                                                    <!-- <td>
                                                                        @if($usulan->file_berita_acara)
                                                                            <a href="{{ asset($usulan->file_berita_acara) }}" target="_blank" class="btn btn-xs btn-outline-primary" title="Download Berita Acara">
                                                                                <i class="feather-download"></i>
                                                                            </a>
                                                                        @else
                                                                            <span class="text-muted">-</span>
                                                                        @endif
                                                                    </td> -->
                                                                    <td>
                                                                        <div class="d-flex gap-2">
                                                                            <a href="{{ route('usulan.show', $usulan->id_usulan) }}" class="btn btn-sm bg-light-info text-info border-0" title="Detail">
                                                                                <i class="feather-eye"></i>
                                                                            </a>
                                                                             @if(isset($currentUser) && ($currentUser->role == 'operator_dusun' || $currentUser->role == 'admin'))
                                                                                <a href="{{ route('usulan.edit', $usulan->id_usulan) }}"
                                                                                    class="btn btn-sm bg-light-warning text-warning border-0" title="Edit">
                                                                                    <i class="feather-edit"></i>
                                                                                </a>
                                                                                <button type="button" 
                                                                                    class="btn btn-sm bg-light-danger text-danger border-0 btn-hapus-usulan" 
                                                                                    title="Hapus"
                                                                                    data-id="{{ $usulan->id_usulan }}"
                                                                                    data-name="{{ $usulan->jenis_kegiatan }}"
                                                                                    data-url="{{ route('usulan.destroy', $usulan->id_usulan) }}">
                                                                                    <i class="feather-trash-2"></i>
                                                                                </button>
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

    </style>

    {{-- Hidden form untuk hapus usulan (di luar form-rkp agar tidak nested) --}}
    <form id="form-hapus-usulan" method="POST" action="" class="d-none no-swal">
        @csrf
        @method('DELETE')
    </form>
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

        // Handler untuk tombol hapus usulan (nested form workaround)
        document.body.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-hapus-usulan');
            if (!btn) return;

            const dataName = btn.getAttribute('data-name') || 'usulan ini';
            const url = btn.getAttribute('data-url');

            Swal.fire({
                title: 'Hapus Data?',
                text: 'anda akan menghapus "' + dataName + '" pemulihan hanya bisa dilakukan admin.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('form-hapus-usulan');
                    form.action = url;
                    Swal.fire({ title: 'Menghapus...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
