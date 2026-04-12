@extends('admin.layout')

@section('title', 'Semua Notifikasi')

@section('content')
<div class="container-fluid">
    <!-- [ page-header ] start -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Notifikasi</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Notifikasi</li>
            </ul>
        </div>
        <div class="page-header-right ms-auto">
            <a href="{{ route('admin.notifications.markAllRead') }}" class="btn btn-primary d-flex align-items-center">
                <i class="feather-check-circle me-2"></i> Tandai Semua Dibaca
            </a>
        </div>
    </div>
    <!-- [ page-header ] end -->

    <!-- Main Content -->
    <div class="row justify-content-center mt-3">
        <div class="col-lg-10 col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom p-4">
                    <h6 class="mb-0 fw-bold">Riwayat Notifikasi Sistem</h6>
                    <p class="text-muted small mb-0 mt-1">Lacak semua pembaharuan, status kegiatan, dan riwayat revisi pada aplikasi.</p>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($notifikasis as $notification)
                            @php
                                $isUnread = false;
                                if ($notification->id_penerima) {
                                    $arr = explode(',', $notification->id_penerima);
                                    if (in_array($user->id_user ?? '', $arr)) {
                                        $isUnread = true;
                                    }
                                } elseif ($notification->dibaca == 0) {
                                    $isUnread = true;
                                }
                                $bgClass = $isUnread ? 'bg-light border-start border-4 border-primary' : 'bg-white';
                                
                                $colorClass = 'text-primary bg-light-primary';
                                $statusStr = strtolower($notification->status ?? '');
                                $judulStr = strtolower($notification->judul ?? '');
                                $deskripsiStr = strtolower($notification->deskripsi ?? '');
                                
                                // Evaluasi berdasarkan status dashboard yang persis
                                if (str_contains($statusStr, 'pending') || str_contains($judulStr, 'pending') || str_contains($deskripsiStr, 'pending')) {
                                    $colorClass = 'text-dark bg-warning';
                                } elseif (str_contains($statusStr, 'gagal terverifikasi') || str_contains($judulStr, 'gagal terverifikasi') || str_contains($deskripsiStr, 'gagal terverifikasi')) {
                                    $colorClass = 'text-white bg-danger';
                                } elseif (str_contains($statusStr, 'terverifikasi') || str_contains($judulStr, 'terverifikasi') || str_contains($deskripsiStr, 'terverifikasi')) {
                                    $colorClass = 'text-white bg-purple';
                                } elseif (str_contains($statusStr, 'menunggu persetujuan bpd') || str_contains($judulStr, 'menunggu persetujuan bpd') || str_contains($deskripsiStr, 'menunggu persetujuan bpd')) {
                                    $colorClass = 'text-dark bg-light border';
                                } elseif (str_contains($statusStr, 'disetujui') || str_contains($judulStr, 'disetujui') || str_contains($deskripsiStr, 'disetujui')) {
                                    $colorClass = 'text-white bg-success';
                                } elseif (str_contains($statusStr, 'ditolak bpd') || str_contains($judulStr, 'ditolak bpd') || str_contains($deskripsiStr, 'ditolak bpd')) {
                                    $colorClass = 'text-white bg-dark';
                                } elseif (str_contains($statusStr, 'proses') || str_contains($judulStr, 'proses') || str_contains($deskripsiStr, 'proses')) {
                                    $colorClass = 'text-white bg-primary';
                                } elseif ($statusStr == 'danger') {
                                    $colorClass = 'text-white bg-danger';
                                } elseif ($statusStr == 'warning') {
                                    $colorClass = 'text-dark bg-warning';
                                } elseif ($statusStr == 'success') {
                                    $colorClass = 'text-white bg-success';
                                } else {
                                    $colorClass = 'text-primary bg-light-primary';
                                }
                                
                                $icon = 'bell';
                                $jenis = strtolower($notification->jenis ?? '');
                                
                                if($jenis == 'usulan' || str_contains($judulStr, 'usulan')) {
                                    $icon = 'edit-2';
                                } elseif($jenis == 'rpjm' || str_contains($judulStr, 'rpjm')) {
                                    $icon = 'file-text';
                                } elseif($jenis == 'rkpdesa' || str_contains($judulStr, 'rkp')) {
                                    $icon = 'send';
                                } elseif($jenis == 'beritaacara' || str_contains($judulStr, 'berita acara')) {
                                    $icon = 'book-open';
                                }
                            @endphp
                            
                            <a href="{{ route('admin.notifications.read', $notification->id_notif) }}" class="list-group-item list-group-item-action d-flex align-items-start gap-3 p-3 {{ $bgClass }} {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="{{ $colorClass }} rounded d-flex justify-content-center align-items-center flex-shrink-0 mt-1" style="width: 40px; height: 40px;">
                                    <i class="feather-{{ $icon }}" style="font-size: 18px; margin: 0; line-height: 1;"></i>
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="m-0 text-wrap text-break {{ $isUnread ? 'fw-bold text-dark' : 'fw-medium text-dark' }} f-14 lh-sm pe-3">{{ $notification->judul }}</h6>
                                        <div class="text-end flex-shrink-0">
                                            <span class="f-12 text-muted fw-normal d-block mb-1">{{ $notification->created_at->format('d M Y') }}</span>
                                            <span class="f-11 text-muted fw-normal">{{ $notification->created_at->format('H:i') }}</span>
                                        </div>
                                    </div>
                                    <p class="m-0 text-wrap text-break text-muted fw-normal f-13 lh-base">{{ $notification->deskripsi }}</p>
                                    @if($isUnread)
                                        <span class="badge bg-light-primary text-primary mt-3 px-2 py-1"><i class="feather-circle me-1" style="font-size: 10px;"></i> Belum dibaca</span>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <div class="p-5 text-center">
                                <i class="feather-bell-off text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted fw-bold mb-1">Tidak ada Notifikasi.</h5>
                                <p class="text-muted mb-0">Anda belum memiliki riwayat aktivitas saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                @if($notifikasis->hasPages())
                <div class="card-footer bg-white p-4 border-top">
                    {{ $notifikasis->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
