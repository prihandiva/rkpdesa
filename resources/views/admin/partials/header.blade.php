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
            <!--! [Start] Header Notifications !-->
            <div class="nxl-h-item">
                <div class="dropdown">
                    <a href="javascript:void(0);" class="nxl-head-link" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <div class="avatar-text avatar-md bg-light-primary text-primary rounded-pill">
                            <i class="feather-bell"></i>
                            @auth
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                @endif
                            @endauth
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown text-center border-0 p-0" style="width: 350px; left: auto; right: 0;">
                        <div class="dropdown-header d-flex align-items-center justify-content-between p-3 border-bottom">
                            <h6 class="m-0">Notifications</h6>
                            <a href="javascript:void(0);" class="text-muted text-decoration-none f-12">Mark all as read</a>
                        </div>
                        <div class="dropdown-body nxl-h-dropdown-scroll" style="max-height: 400px; overflow-y: auto;">
                            @auth
                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <a href="{{ $notification->data['url'] ?? '#' }}" class="dropdown-item d-flex align-items-center gap-3 p-3 border-bottom text-start">
                                        <div class="avatar-text avatar-md bg-soft-primary text-primary rounded">
                                            {{-- Map Color based on data or fallback --}}
                                            @php
                                                $colorClass = 'text-primary bg-light-primary';
                                                if(isset($notification->data['color'])) {
                                                    switch($notification->data['color']) {
                                                        case 'primary': $colorClass = 'text-primary bg-light-primary'; break;
                                                        case 'warning': $colorClass = 'text-warning bg-light-warning'; break;
                                                        case 'purple': $colorClass = 'text-white bg-purple'; break;
                                                        case 'danger': $colorClass = 'text-danger bg-light-danger'; break; // or text-white bg-danger
                                                        case 'success': $colorClass = 'text-success bg-light-success'; break;
                                                        case 'light': $colorClass = 'text-dark bg-light'; break;
                                                        case 'dark': $colorClass = 'text-white bg-dark'; break;
                                                        default: $colorClass = 'text-primary bg-light-primary';
                                                    }
                                                }
                                            @endphp
                                            <div class="avatar-text avatar-sm {{ $colorClass }} rounded">
                                                <i class="feather-{{ $notification->data['icon'] ?? 'activity' }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 text-wrap text-break lh-base f-14">{{ $notification->data['message'] ?? 'No Message' }}</h6>
                                            <span class="f-12 text-muted">{{ $notification->created_at->diffForHumans() }}</span>
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
                            @endauth
                        </div>
                        <div class="dropdown-footer p-3 border-top">
                            <a href="javascript:void(0);" class="btn btn-primary w-100">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--! [End] Header Notifications !-->
            <!--! [Start] Header Profile !-->
            <div class="nxl-h-item nxl-profile-menu">
                <div class="dropdown">
                    <a href="javascript:void(0);" data-bs-toggle="dropdown" role="button" data-bs-auto-close="outside">
                        @php
                            $currentUser = auth()->user();
                            if (!$currentUser && session('user_id')) {
                                $currentUser = \App\Models\User::find(session('user_id'));
                            }
                            $userName = $currentUser ? $currentUser->nama : 'User';
                            $userImage = $currentUser ? $currentUser->profile_image : null;
                        @endphp
                        
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
