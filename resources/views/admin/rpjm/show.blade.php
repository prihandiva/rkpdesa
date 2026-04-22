@extends('admin.layout')

@section('title', 'Detail RPJM')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10 fw-bold text-dark">Detail RPJM</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rpjm.index') }}">RPJM</a></li>
                    <li class="breadcrumb-item">Detail</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                         @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                            <a href="{{ route('rpjm.edit', $rpjm->id_rpjm) }}" class="btn btn-warning shadow-sm">
                                <i class="feather-edit me-2"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route('rpjm.index') }}" class="btn btn-secondary shadow-sm">
                            <i class="feather-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ page-header ] end -->

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom p-4">
                        <h6 class="m-0 fw-bold text-primary">Informasi RPJM</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="width: 200px;">Jenis Kegiatan</th>
                                        <td class="fw-bold fs-5">{{ $rpjm->jenis_kegiatan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bidang</th>
                                        <td>{{ $rpjm->masterBidang->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sub Bidang</th>
                                        <td>{{ $rpjm->subbidang ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi</th>
                                        <td>{{ $rpjm->lokasi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Volume</th>
                                        <td>{{ $rpjm->volume ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sasaran</th>
                                        <td>{{ $rpjm->sasaran ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tahun Pelaksanaan</th>
                                        <td>{{ $rpjm->tahun_pelaksanaan ? 'Tahun ke-' . $rpjm->tahun_pelaksanaan : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Waktu Pelaksanaan</th>
                                        <td>{{ $rpjm->waktu ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Perkiraan Biaya</th>
                                        <td>Rp {{ number_format($rpjm->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sumber Dana</th>
                                        <td>
                                            @if($rpjm->sumberBiayaModels->count() > 0)
                                                {{ $rpjm->sumberBiayaModels->pluck('nama')->implode(', ') }}
                                            @else
                                                {{ is_array($rpjm->sumber_biaya) ? implode(', ', $rpjm->sumber_biaya) : ($rpjm->sumber_biaya ?? '-') }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Pola Pelaksanaan</th>
                                        <td>{{ $rpjm->masterPola->nama ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-light border-bottom p-4">
                        <h6 class="m-0 fw-bold text-primary">Status & Prioritas</h6>
                    </div>
                    <div class="card-body">
                        <!-- Priority Section -->
                        <div class="mb-4 text-center border-bottom pb-4">
                            <label class="d-block text-muted small mb-2">Prioritas</label>
                            @php
                                $prioVal = $rpjm->prioritas;
                                $prioColor = match(true) {
                                    $prioVal >= 5 => 'danger',
                                    $prioVal >= 4 => 'warning',
                                    $prioVal >= 3 => 'info',
                                    default => 'success'
                                };
                            @endphp
                            <div class="d-flex justify-content-center align-items-center position-relative">
                                <h1 class="display-3 fw-bold text-{{ $prioColor }} mb-0">{{ $prioVal ?? '-' }}</h1>
                                
                                @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
                                    <button type="button" class="btn btn-sm btn-light border position-absolute top-0 end-0" 
                                        data-bs-toggle="modal" data-bs-target="#editPrioritasModal" title="Edit Prioritas">
                                        <i class="feather-edit-2"></i>
                                    </button>
                                @endif
                            </div>
                            <span class="badge bg-light text-muted border mt-2">Skala Prioritas</span>
                        </div>



                         <!-- Vertical Timeline (Stepper) -->
                         <div class="position-relative ps-3 mt-4">
                            @php
                                $status = $rpjm->status;
                                $level = 1;
                                if ($status == 'Pending') $level = 2;
                                elseif (in_array($status, ['Terverifikasi', 'Gagal Terverifikasi'])) $level = 3;
                                elseif (in_array($status, ['Menunggu persetujuan BPD', 'Disetujui', 'Ditolak BPD'])) $level = 4;
                                
                                $c_muted = 'muted';
                                $c_primary = 'primary';
                                $c_success = 'success';
                                $c_danger = 'danger';
                            @endphp

                            <!-- Step 1: Input RPJM (Proses) -->
                            <div class="d-flex align-items-center mb-4 position-relative">
                                <div class="position-absolute start-0 top-0 translate-middle-x bg-white" style="z-index: 2;">
                                    <i class="feather-file-text fs-4 text-{{ $level >= 1 ? $c_primary : $c_muted }}"></i>
                                </div>
                                <div class="border-start border-3 border-{{ $level > 1 ? $c_primary : $c_muted }} position-absolute start-0 h-100" style="left: -1px; top: 10px; z-index: 1;"></div>
                                <div class="ms-4">
                                    <h6 class="mb-0 {{ $level >= 1 ? 'fw-bold text-dark' : 'text-muted' }}">Input RPJM</h6>
                                    <small class="text-muted">Data Masuk</small>
                                    @if($status == 'Proses') <span class="badge badge-status-proses ms-2">Saat Ini</span> @endif
                                </div>
                            </div>

                            <!-- Step 2: Masuk RKP (Pending) -->
                            <div class="d-flex align-items-center mb-4 position-relative">
                                <div class="position-absolute start-0 top-0 translate-middle-x bg-white" style="z-index: 2;">
                                    <i class="feather-inbox fs-4 text-{{ $level >= 2 ? $c_primary : $c_muted }}"></i>
                                </div>
                                <div class="border-start border-3 border-{{ $level > 2 ? $c_primary : $c_muted }} position-absolute start-0 h-100" style="left: -1px; top: 10px; z-index: 1;"></div>
                                <div class="ms-4">
                                    <h6 class="mb-0 {{ $level >= 2 ? 'fw-bold text-dark' : 'text-muted' }}">Masuk RKP Desa</h6>
                                    <small class="text-muted">Menunggu Verifikasi</small>
                                    @if($status == 'Pending') <span class="badge badge-status-pending ms-2">Saat Ini</span> @endif
                                </div>
                            </div>
                            
                            <!-- Step 3: Verifikasi Teknis -->
                             @php
                                $step3Color = $c_muted;
                                $step3Icon = 'feather-check-circle';
                                if ($level > 3) {
                                    $step3Color = $c_primary;
                                } elseif ($level == 3) {
                                    $step3Color = $status == 'Gagal Terverifikasi' ? $c_danger : $c_primary;
                                    $step3Icon = $status == 'Gagal Terverifikasi' ? 'feather-x-circle' : 'feather-check-circle';
                                }
                            @endphp
                            <div class="d-flex align-items-center mb-4 position-relative">
                                <div class="position-absolute start-0 top-0 translate-middle-x bg-white" style="z-index: 2;">
                                    <i class="{{ $step3Icon }} fs-4 text-{{ $step3Color }}"></i>
                                </div>
                                <div class="border-start border-3 border-{{ $level > 3 ? $c_primary : $c_muted }} position-absolute start-0 h-100" style="left: -1px; top: 10px; z-index: 1;"></div>
                                <div class="ms-4">
                                    <h6 class="mb-0 {{ $level >= 3 ? 'fw-bold text-dark' : 'text-muted' }}">Verifikasi Teknis</h6>
                                    <small class="text-muted">Tim Verifikasi</small>
                                    @if($status == 'Terverifikasi') <span class="badge badge-status-terverifikasi ms-2">OK</span>
                                    @elseif($status == 'Gagal Terverifikasi') <span class="badge badge-status-gagal ms-2">Gagal</span> @endif
                                </div>
                            </div>

                             <!-- Step 4: Approval BPD -->
                            @php
                                $step4Color = $c_muted;
                                $step4Icon = 'feather-thumbs-up';
                                if ($level == 4) {
                                    if ($status == 'Disetujui') {
                                        $step4Color = $c_success;
                                        $step4Icon = 'feather-check-square';
                                    } elseif ($status == 'Ditolak BPD') {
                                        $step4Color = $c_danger;
                                        $step4Icon = 'feather-x-square';
                                    } else {
                                        $step4Color = $c_primary; 
                                        $step4Icon = 'feather-clock';
                                    }
                                }
                            @endphp
                            <div class="d-flex align-items-center position-relative">
                                <div class="position-absolute start-0 top-0 translate-middle-x bg-white" style="z-index: 2;">
                                    <i class="{{ $step4Icon }} fs-4 text-{{ $step4Color }}"></i>
                                </div>
                                <div class="ms-4">
                                    <h6 class="mb-0 {{ $level == 4 ? 'fw-bold text-dark' : 'text-muted' }}">Approval BPD</h6>
                                    <small class="text-muted">Keputusan Akhir</small>
                                    @if($status == 'Disetujui') 
                                        <span class="badge badge-status-disetujui ms-2">DISETUJUI</span>
                                    @elseif($status == 'Ditolak BPD') 
                                        <span class="badge badge-status-ditolak-bpd ms-2">DITOLAK</span>
                                    @elseif($status == 'Menunggu persetujuan BPD')
                                        <span class="badge badge-status-menunggu-bpd ms-2">Menunggu</span>
                                    @endif
                                </div>
                            </div>

                         </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center p-4">
                        <h6 class="m-0 fw-bold text-primary">Riwayat Aktivitas</h6>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($logs as $log)
                                @php
                                    $colorClass = 'text-primary bg-light-primary';
                                    $statusStr = strtolower($log->status ?? '');
                                    $judulStr = strtolower($log->judul ?? '');
                                    $deskripsiStr = strtolower($log->deskripsi ?? '');
                                    $jenis = strtolower($log->jenis ?? '');
                                    
                                    if (str_contains($statusStr, 'pending') || str_contains($judulStr, 'pending') || str_contains($deskripsiStr, 'pending')) {
                                        $colorClass = 'badge-status-pending';
                                    } elseif (str_contains($statusStr, 'gagal terverifikasi') || str_contains($judulStr, 'gagal terverifikasi') || str_contains($deskripsiStr, 'gagal terverifikasi')) {
                                        $colorClass = 'badge-status-gagal';
                                    } elseif (str_contains($statusStr, 'terverifikasi') || str_contains($judulStr, 'terverifikasi') || str_contains($deskripsiStr, 'terverifikasi')) {
                                        $colorClass = 'badge-status-terverifikasi';
                                    } elseif (str_contains($statusStr, 'menunggu persetujuan bpd') || str_contains($judulStr, 'menunggu persetujuan bpd') || str_contains($deskripsiStr, 'menunggu persetujuan bpd')) {
                                        $colorClass = 'badge-status-menunggu-bpd';
                                    } elseif (str_contains($statusStr, 'disetujui') || str_contains($judulStr, 'disetujui') || str_contains($deskripsiStr, 'disetujui')) {
                                        $colorClass = 'badge-status-disetujui';
                                    } elseif (str_contains($statusStr, 'ditolak bpd') || str_contains($judulStr, 'ditolak bpd') || str_contains($deskripsiStr, 'ditolak bpd')) {
                                        $colorClass = 'badge-status-ditolak-bpd';
                                    } elseif (str_contains($statusStr, 'proses') || str_contains($judulStr, 'proses') || str_contains($deskripsiStr, 'proses') || str_contains($judulStr, 'baru') || $statusStr == 'info') {
                                        $colorClass = 'badge-status-proses';
                                    } elseif ($statusStr == 'danger') {
                                        $colorClass = 'badge-status-gagal';
                                    } elseif ($statusStr == 'warning') {
                                        $colorClass = 'badge-status-pending';
                                    } elseif ($statusStr == 'success') {
                                        $colorClass = 'badge-status-disetujui';
                                    } else {
                                        $colorClass = 'badge-status-proses';
                                    }
                                    
                                    $icon = 'bell';
                                    
                                    if($jenis == 'usulan' || str_contains($judulStr, 'usulan')) {
                                        $icon = 'edit-2';
                                    } elseif($jenis == 'rpjm' || str_contains($judulStr, 'rpjm')) {
                                        $icon = 'file-text';
                                    } elseif($jenis == 'rkpdesa' || str_contains($judulStr, 'rkp')) {
                                        $icon = 'file';
                                    } elseif($jenis == 'beritaacara' || str_contains($judulStr, 'berita acara')) {
                                        $icon = 'book-open';
                                    }
                                @endphp
                                <li class="list-group-item d-flex align-items-start gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="{{ $colorClass }} rounded d-flex justify-content-center align-items-center flex-shrink-0" style="width: 32px; height: 32px;">
                                        <i class="feather-{{ $icon }}" style="font-size: 14px; margin: 0; line-height: 1;"></i>
                                    </div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <div class="m-0 text-wrap text-break fw-bold lh-sm pe-2 text-primary" style="font-size: 11px;">{{ $log->judul ?? 'Update' }}</div>
                                            <span class="f-10 text-muted fw-normal flex-shrink-0 text-end" style="font-size: 11px;">{{ $log->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="m-0 text-wrap text-break text-muted fw-normal f-11 lh-sm">{{ $log->deskripsi }}</p>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted py-4">
                                    <span class="small">Belum ada aktivitas.</span>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom p-4">
                         <h6 class="m-0 fw-bold text-primary">Informasi Tambahan</h6>
                    </div>
                     <div class="card-body">
                         <dl class="row mb-0">
                             <dt class="col-sm-5 text-muted small">Dibuat Pada</dt>
                             <dd class="col-sm-7 small">{{ $rpjm->created_at ? $rpjm->created_at->format('d M Y H:i') : '-' }}</dd>
 
                             <dt class="col-sm-5 text-muted small">Terakhir Update</dt>
                             <dd class="col-sm-7 small">{{ $rpjm->updated_at ? $rpjm->updated_at->format('d M Y H:i') : '-' }}</dd>
                         </dl>
                     </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit Prioritas (Moved outside to fix z-index) -->
    @if(isset($currentUser) && ($currentUser->role == 'operator_desa' || $currentUser->role == 'admin'))
    <div class="modal fade" id="editPrioritasModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Prioritas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rpjm.update_prioritas', $rpjm->id_rpjm) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Prioritas (Unik per Bidang)</label>
                            <input type="number" name="prioritas" class="form-control" value="{{ $rpjm->prioritas }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection
