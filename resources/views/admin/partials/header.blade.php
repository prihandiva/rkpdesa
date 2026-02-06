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
            <div class="nxl-h-item d-none d-md-flex">
                <div class="input-group search-form">
                    <span class="input-group-text">
                        <i class="feather-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Search here...">
                </div>
            </div>
            <!--! [End] Header Search !-->
            <!--! [Start] Header Notifications !-->
            <div class="nxl-h-item">
                <a href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#nxl-offcanvas-element">
                    <div class="avatar-text avatar-md bg-light-primary text-primary rounded-pill">
                        <i class="feather-bell"></i>
                    </div>
                </a>
            </div>
            <!--! [End] Header Notifications !-->
            <!--! [Start] Header Profile !-->
            <div class="nxl-h-item nxl-profile-menu">
                <div class="dropdown">
                    <a href="javascript:void(0);"
                        class="avatar-text avatar-md bg-primary text-white rounded-pill d-flex align-items-center justify-content-center"
                        data-bs-toggle="dropdown">
                        <span>{{ auth()->user()->name ?? 'User' }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown">
                        <a href="javascript:void(0);" class="dropdown-item">
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
