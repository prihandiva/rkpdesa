<!--! ================================================================ !-->
<!--! [Start] Header !-->
<!--! ================================================================ !-->
<header class="nxl-header">
    <div class="header-wrapper">
        <!--! [Start] Header Left !-->
        <div class="header-left d-flex align-items-center gap-4">
            <!--! [Start] nxl-head-mobile-toggler !-->
            <a href="javascript:void(0);" class="nxl-head-mobile-toggler d-lg-none" id="mobile-collapse">
                <div class="hamburger hamburger--arrowturn">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </a>
            <!--! [End] nxl-head-mobile-toggler !-->
            <!--! [Start] nxl-navigation-toggle !-->
            <div class="nxl-navigation-toggle d-none d-lg-flex">
                <a href="javascript:void(0);" id="menu-mini-button">
                    <i class="feather-align-left"></i>
                </a>
                <a href="javascript:void(0);" id="menu-expend-button" style="display: none">
                    <i class="feather-arrow-right"></i>
                </a>
            </div>
            <!--! [End] nxl-navigation-toggle !-->
        </div>
        <!--! [End] Header Left !-->
        <!--! [Start] Header Right !-->
        <div class="header-right ms-auto d-flex align-items-center gap-3">
            <!--! [Start] Header Search !-->
            <!-- <div class="nxl-h-item d-none d-md-flex">
                <div class="input-group search-form">
                    <span class="input-group-text">
                        <i class="feather-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Search here...">
                </div>
            </div> -->
            <!--! [End] Header Search !-->
            <!--! [Start] Header Notifications !-->
            @php
                $currentUser = auth()->user();
                if (!$currentUser && session('user_id')) {
                    $currentUser = \App\Models\User::find(session('user_id'));
                }
                $userName = $currentUser ? $currentUser->nama : 'User';
                $userImage = $currentUser ? $currentUser->profile_image : null;

                $userNotifs = collect();
                $unreadCount = 0;
                if ($currentUser) {
                    $userNotifs = \App\Models\Notifikasi::orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
                    
                    $unreadCount = \App\Models\Notifikasi::where(function($query) use ($currentUser) {
                        $query->whereRaw('FIND_IN_SET(?, id_penerima)', [$currentUser->id_user])
                              ->orWhereNull('id_penerima')->where('dibaca', 0);
                    })
                    ->count();
                }
            @endphp
            <div class="nxl-h-item">
                <div class="dropdown">
                    <a href="javascript:void(0);" class="nxl-head-link" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <div class="avatar-text avatar-md bg-light-primary text-primary rounded-pill">
                            <i class="feather-bell"></i>
                            @if($currentUser)
                                @if($unreadCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                                        {{ $unreadCount }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                @endif
                            @endif
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown text-center border-0 p-0" style="width: 320px; left: auto; right: 0;">
                        <div class="dropdown-header d-flex align-items-center justify-content-between p-3 border-bottom">
                            <h6 class="m-0">Notifications</h6>
                            <a href="{{ route('admin.notifications.markAllRead') }}" class="text-muted text-decoration-none f-12">Mark all as read</a>
                        </div>
                        <div class="dropdown-body nxl-h-dropdown-scroll" style="max-height: 500px; overflow-y: auto;">
                            @if($currentUser)
                                @php
                                    $prefs = session('notif_preferences', [
                                        'rpjm' => true,
                                        'usulan' => true,
                                        'rkpdesa' => true,
                                        'berita_acara' => true
                                    ]);
                                    
                                    // Use $userNotifs as the source
                                    $filteredNotifs = $userNotifs->filter(function($notif) use ($prefs) {
                                        $type = strtolower($notif->jenis ?? '');
                                        if ($type == 'rpjm') return $prefs['rpjm'];
                                        if ($type == 'usulan') return $prefs['usulan'];
                                        if ($type == 'rkp' || $type == 'rkpdesa') return $prefs['rkpdesa'];
                                        if ($type == 'berita_acara' || $type == 'ba') return $prefs['berita_acara'];
                                        return true; // default show
                                    });
                                @endphp
                                @forelse($filteredNotifs as $notification)
                                    @php
                                        $isUnread = false;
                                        if ($notification->id_penerima) {
                                            $arr = explode(',', $notification->id_penerima);
                                            if (in_array($currentUser->id_user, $arr)) {
                                                $isUnread = true;
                                            }
                                        } elseif ($notification->dibaca == 0) {
                                            $isUnread = true;
                                        }
                                        $bgClass = $isUnread ? 'bg-light border-start border-3 border-primary' : 'bg-white';
                                    @endphp
                                    <a href="{{ route('admin.notifications.read', $notification->id_notif) }}" class="dropdown-item d-flex align-items-start gap-3 p-3 border-bottom text-start {{ $bgClass }}">
                                    @php
                                        // Map status to vibrant bg/text matching the new badge-status palette
                                        $notifBg    = '#dbeafe'; // default: indigo/proses
                                        $notifColor = '#1d4ed8';
                                        $statusStr  = strtolower($notification->status ?? '');
                                        $judulStr   = strtolower($notification->judul ?? '');
                                        $deskripsiStr = strtolower($notification->deskripsi ?? '');

                                        if (str_contains($statusStr, 'gagal terverifikasi') || str_contains($judulStr, 'gagal') || str_contains($deskripsiStr, 'gagal terverifikasi')) {
                                            $notifBg = '#fee2e2'; $notifColor = '#991b1b'; // Red
                                        } elseif (str_contains($statusStr, 'terverifikasi') || str_contains($judulStr, 'terverifikasi') || str_contains($deskripsiStr, 'terverifikasi')) {
                                            $notifBg = '#d1fae5'; $notifColor = '#065f46'; // Emerald
                                        } elseif (str_contains($statusStr, 'Ditolak') || str_contains($judulStr, 'ditolak') || str_contains($deskripsiStr, 'ditolak')) {
                                            $notifBg = '#fce7f3'; $notifColor = '#9d174d'; // Rose
                                        } elseif (str_contains($statusStr, 'disetujui') || str_contains($judulStr, 'disetujui') || str_contains($deskripsiStr, 'disetujui')) {
                                            $notifBg = '#dcfce7'; $notifColor = '#166534'; // Green
                                        } elseif (str_contains($statusStr, 'menunggu') || str_contains($judulStr, 'menunggu') || str_contains($deskripsiStr, 'menunggu bpd')) {
                                            $notifBg = '#ede9fe'; $notifColor = '#5b21b6'; // Violet
                                        } elseif (str_contains($statusStr, 'pending') || str_contains($judulStr, 'pending') || str_contains($deskripsiStr, 'pending')) {
                                            $notifBg = '#fef3c7'; $notifColor = '#92400e'; // Amber
                                        } elseif (str_contains($statusStr, 'hapus') || str_contains($judulStr, 'hapus') || str_contains($deskripsiStr, 'dihapus')) {
                                            $notifBg = '#fee2e2'; $notifColor = '#991b1b'; // Red for delete
                                        } elseif (str_contains($statusStr, 'proses') || str_contains($judulStr, 'baru') || str_contains($judulStr, 'dibuat') || str_contains($deskripsiStr, 'dibuat')) {
                                            $notifBg = '#dbeafe'; $notifColor = '#1d4ed8'; // Indigo for new/proses
                                        } elseif ($statusStr == 'danger') {
                                            $notifBg = '#fee2e2'; $notifColor = '#991b1b';
                                        } elseif ($statusStr == 'warning') {
                                            $notifBg = '#fef3c7'; $notifColor = '#92400e';
                                        } elseif ($statusStr == 'success') {
                                            $notifBg = '#dcfce7'; $notifColor = '#166534';
                                        }

                                        $icon = 'bell';
                                        $jenis = strtolower($notification->jenis ?? '');
                                        if ($jenis == 'usulan' || str_contains($judulStr, 'usulan')) {
                                            $icon = 'edit-2';
                                        } elseif ($jenis == 'rpjm' || str_contains($judulStr, 'rpjm')) {
                                            $icon = 'file-text';
                                        } elseif ($jenis == 'rkpdesa' || str_contains($judulStr, 'rkp')) {
                                            $icon = 'file';
                                        } elseif ($jenis == 'beritaacara' || str_contains($judulStr, 'berita acara')) {
                                            $icon = 'book-open';
                                        }
                                    @endphp
                                        <div class="rounded d-flex justify-content-center align-items-center flex-shrink-0"
                                             style="width:36px;height:36px;background:{{ $notifBg }};color:{{ $notifColor }};">
                                            <i class="feather-{{ $icon }}" style="font-size:15px;margin:0;line-height:1;"></i>
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <div class="m-0 text-wrap text-break fw-bold lh-sm pe-2 text-primary" style="font-size: 11px;">{{ $notification->judul }}</div>
                                                <span class="f-10 text-muted fw-normal flex-shrink-0 text-end" style="font-size: 11px;">{{ date('d/m/Y', strtotime($notification->created_at)) }}</span>
                                            </div>
                                            <p class="m-0 text-wrap text-break text-muted fw-normal f-11 lh-sm" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">{{ $notification->deskripsi }}</p>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-4 text-center">
                                        <i class="feather-bell-off fs-1 text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Tidak ada notifikasi baru</p>
                                    </div>
                                @endforelse
                            @else
                                <div class="p-4 text-center">
                                    <p class="text-muted mb-0">Silahkan login untuk melihat notifikasi.</p>
                                </div>
                            @endif
                        </div>
                        <div class="dropdown-footer p-2 border-top">
                            <a href="{{ route('notifikasi.index') }}" class="btn btn-sm btn-primary w-100">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--! [End] Header Notifications !-->
            <!--! [Start] Header Profile !-->
            <div class="nxl-h-item nxl-profile-menu">
                <div class="dropdown">
                    <a href="javascript:void(0);" data-bs-toggle="dropdown" role="button" data-bs-auto-close="outside">
                        
                        @if($userImage)
                            <img src="{{ asset('storage/' . $userImage) }}" alt="user-image" class="avatar-md rounded-circle border" style="object-fit: cover;">
                        @else
                            <div class="avatar-text avatar-md bg-primary text-white rounded-pill d-flex align-items-center justify-content-center">
                                <span>{{ substr($userName, 0, 1) }}</span>
                            </div>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown">
                        <div class="dropdown-header d-flex flex-column align-items-center p-3">
                            @if($userImage)
                                <img src="{{ asset('storage/' . $userImage) }}" alt="user-image" class="avatar-lg rounded-circle mb-2 border" style="object-fit: cover; width: 60px; height: 60px;">
                            @else
                                <div class="avatar-text avatar-lg bg-primary text-white rounded-circle mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">
                                    <span>{{ substr($userName, 0, 1) }}</span>
                                </div>
                            @endif
                            <h6 class="m-0">{{ $userName }}</h6>
                            <span class="text-muted f-12">{{ $currentUser ? $currentUser->email : '' }}</span>
                        </div>
                        <div class="dropdown-divider mt-0"></div>
                        <a href="{{ route('profile.index') }}" class="dropdown-item">
                            <i class="feather-user me-2"></i>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('pengaturan.index') }}" class="dropdown-item">
                            <i class="feather-settings me-2"></i>
                            <span>Settings</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <button type="button" id="btn-logout" class="dropdown-item"
                                style="cursor: pointer; border: none; background: none; width: 100%; text-align: left;">
                            <i class="feather-log-out me-2"></i>
                            <span>Sign Out</span>
                        </button>
                        <form id="form-logout" method="POST" action="{{ route('admin.logout') }}" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            <!--! [End] Header Profile !-->
        </div>
        <!--! [End] Header Right !-->
    </div>
</header>
<!--! ================================================================ !-->
<!--! [End] Header !-->
<!--! ================================================================ !-->

<script>
document.addEventListener('DOMContentLoaded', function () {
    // === Logout Confirmation ===
    const btnLogout = document.getElementById('btn-logout');
    if (btnLogout) {
        btnLogout.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Sign Out?',
                text: 'Apakah Anda yakin ingin keluar dari sistem?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="feather-log-out me-1"></i> Ya, Keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Logging out...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => Swal.showLoading()
                    });
                    document.getElementById('form-logout').submit();
                }
            });
        });
    }

    // === AJAX Session Expiry Handler ===
    // Intercept all fetch/XHR 401 responses and redirect to login
    const originalFetch = window.fetch;
    window.fetch = function (...args) {
        return originalFetch.apply(this, args).then(response => {
            if (response.status === 401) {
                response.clone().json().then(data => {
                    if (data.session_expired) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Session Habis',
                            text: 'Session Anda telah habis, silahkan login kembali.',
                            confirmButtonColor: '#4b3bdb',
                            confirmButtonText: 'Login'
                        }).then(() => {
                            window.location.href = data.redirect || '/admin/login';
                        });
                    }
                }).catch(() => {});
            }
            return response;
        });
    };
});
</script>
