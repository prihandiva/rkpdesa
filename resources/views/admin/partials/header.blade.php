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
                                @forelse($userNotifs as $notification)
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
                                            $colorClass = 'text-primary bg-light-primary';
                                            $statusStr = strtolower($notification->status ?? '');
                                            $judulStr = strtolower($notification->judul ?? '');
                                            $deskripsiStr = strtolower($notification->deskripsi ?? '');
                                            
                                            // Evaluasi berdasarkan status
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
                                            $jenis = strtolower($notification->jenis ?? '');
                                            
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
                                        <div class="{{ $colorClass }} rounded d-flex justify-content-center align-items-center flex-shrink-0" style="width: 34px; height: 34px;">
                                            <i class="feather-{{ $icon }}" style="font-size: 15px; margin: 0; line-height: 1;"></i>
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
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="feather-settings me-2"></i>
                            <span>Settings</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="dropdown-item"
                                style="cursor: pointer; border: none; background: none; width: 100%; text-align: left;">
                                <i class="feather-log-out me-2"></i>
                                <span>Sign Out</span>
                            </button>
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
