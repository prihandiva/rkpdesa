<!--! ================================================================ !-->
<!--! [Start] Navigation Menu !-->
<!--! ================================================================ !-->
<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <!--! [Start] Brand Logo !-->
        <div class="m-header">
            <a href="{{ route('admin.dashboard') }}" class="b-brand">
                <!-- Change your logo here -->
                <img src="{{ asset('admin-template/assets/images/siperdes.png') }}" alt="Logo" class="logo logo-lg" />
                <img src="{{ asset('admin-template/assets/images/logo_siperdes.png') }}" alt="Logo"
                    class="logo logo-sm" />
            </a>
        </div>
        <!--! [End] Brand Logo !-->
        <!--! [Start] Navbar Content !-->
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <!--! [Start] Menu Caption !-->
                <li class="nxl-item nxl-caption">
                    <label>Menu Utama</label>
                </li>
                <!--! [End] Menu Caption !-->

                <!--! [Start] Dashboard Menu !-->
                <li class="nxl-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-airplay"></i></span>
                        <span class="nxl-mtext">Dashboard</span>
                    </a>
                </li>
                <!--! [End] Dashboard Menu !-->

                <!--! [Start] Usulan Menu !-->
                <li class="nxl-item {{ request()->routeIs('usulan.*') ? 'active' : '' }}">
                    <a href="{{ route('usulan.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-edit-2"></i></span>
                        <span class="nxl-mtext">Usulan</span>
                    </a>
                </li>
                <!--! [End] Usulan Menu !-->

                <!--! [Start] RPJM Desa Menu !-->
                <li class="nxl-item {{ request()->routeIs('rpjm.*') ? 'active' : '' }}">
                    <a href="{{ route('rpjm.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-file-text"></i></span>
                        <span class="nxl-mtext">RPJM Desa</span>
                    </a>
                </li>
                <!--! [End] RPJM Desa Menu !-->

                <!--! [Start] RKP Desa Menu !-->
                <li class="nxl-item {{ request()->routeIs('rkpdesa.*') ? 'active' : '' }}">
                    <a href="{{ route('rkpdesa.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-send"></i></span>
                        <span class="nxl-mtext">RKP Desa</span>
                    </a>
                </li>
                <!--! [End] RKP Desa Menu !-->

                <!--! [Start] Berita Acara Menu !-->
                <li class="nxl-item {{ request()->routeIs('berita-acara.*') ? 'active' : '' }}">
                    <a href="{{ route('berita-acara.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-book-open"></i></span>
                        <span class="nxl-mtext">Berita Acara</span>
                    </a>
                </li>
                <!--! [End] Berita Acara Menu !-->

                @if(strtolower(session('user_role')) === 'admin')
                <!--! [Start] Menu Caption !-->
                <li class="nxl-item nxl-caption">
                    <label>Manajemen Data</label>
                </li>
                <!--! [End] Menu Caption !-->

                <!--! [Start] Tahun Menu !-->
                <li class="nxl-item {{ request()->routeIs('tahun.*') ? 'active' : '' }}">
                    <a href="{{ route('tahun.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-calendar"></i></span>
                        <span class="nxl-mtext">Tahun</span>
                    </a>
                </li>
                <!--! [End] Tahun Menu !-->

                <!--! [Start] Users Menu !-->
                <li class="nxl-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span>
                        <span class="nxl-mtext">Pengguna</span>
                    </a>
                </li>
                <!--! [End] Users Menu !-->

                <!--! [Start] Additional Data Management Menus !-->
                <li class="nxl-item {{ request()->routeIs('bidang.*') ? 'active' : '' }}">
                    <a href="{{ route('bidang.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-grid"></i></span>
                        <span class="nxl-mtext">Bidang</span>
                    </a>
                </li>

                <li class="nxl-item {{ request()->routeIs('sumber-biaya.*') ? 'active' : '' }}">
                    <a href="{{ route('sumber-biaya.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-credit-card"></i></span>
                        <span class="nxl-mtext">Sumber Biaya</span>
                    </a>
                </li>

                <li class="nxl-item {{ request()->routeIs('pola-pelaksanaan.*') ? 'active' : '' }}">
                    <a href="{{ route('pola-pelaksanaan.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-layers"></i></span>
                        <span class="nxl-mtext">Pola pelaksanaan</span>
                    </a>
                </li>

                <li class="nxl-item {{ request()->routeIs('dusun.*') ? 'active' : '' }}">
                    <a href="{{ route('dusun.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-map"></i></span>
                        <span class="nxl-mtext">Dusun</span>
                    </a>
                </li>

                <li class="nxl-item {{ request()->routeIs('rt.*') ? 'active' : '' }}">
                    <a href="{{ route('rt.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-home"></i></span>
                        <span class="nxl-mtext">RT</span>
                    </a>
                </li>

                <li class="nxl-item {{ request()->routeIs('rw.*') ? 'active' : '' }}">
                    <a href="{{ route('rw.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-home"></i></span>
                        <span class="nxl-mtext">RW</span>
                    </a>
                </li>

                <li class="nxl-item {{ request()->routeIs('pegawai.*') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-briefcase"></i></span>
                        <span class="nxl-mtext">Pegawai</span>
                    </a>
                </li>

                <li class="nxl-item {{ request()->routeIs('monitoring.*') ? 'active' : '' }}">
                    <a href="{{ route('monitoring.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-monitor"></i></span>
                        <span class="nxl-mtext">Monitoring Sistem</span>
                    </a>
                </li>
                <!--! [End] Additional Data Management Menus !-->
                @endif

                <!--! [Start] Menu Caption !-->
                <li class="nxl-item nxl-caption">
                    <label>Pengaturan</label>
                </li>
                <!--! [End] Menu Caption !-->

                <!--! [Start] Profile Menu !-->
                <li class="nxl-item {{ request()->routeIs('profil.*') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-settings"></i></span>
                        <span class="nxl-mtext">Pengaturan</span>
                    </a>
                </li>
                <!--! [End] Profile Menu !-->
            </ul>

            <!--! [Start] Download Card !-->
            <!-- <div class="card text-center">
                <div class="card-body">
                    <i class="feather-sunrise fs-4 text-dark"></i>
                    <h6 class="mt-4 text-dark fw-bolder">RKP Desa System</h6>
                    <p class="fs-11 my-3 text-dark">Sistem manajemen RKP Desa terpadu dengan template Duralux.</p>
                    <a href="#" class="btn btn-primary text-white w-100">Bantuan</a>
                </div>
            </div> -->
            <!--! [End] Download Card !-->
        </div>
        <!--! [End] Navbar Content !-->
    </div>
</nav>
<!--! ================================================================ !-->
<!--! [End] Navigation Menu !-->
<!--! ================================================================ !-->
<!-- DEBUG: Role in session is '{{ session('user_role') }}' -->
