@extends('admin.layout')

@section('title', 'Pengaturan')

@section('content')
<div class="container-fluid">
    <!-- [ page-header ] start -->
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Pengaturan</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Pengaturan</li>
            </ul>
        </div>
    </div>
    <!-- [ page-header ] end -->

    <div class="row">
        <!-- Theme Settings -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom px-4 py-3">
                    <h6 class="mb-0 fw-bold"><i class="feather-moon me-2 text-primary"></i>Tema Tampilan</h6>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-4">Pilih tema tampilan yang paling nyaman untuk mata Anda. Pengaturan ini akan disimpan secara otomatis di browser Anda.</p>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="theme-card border rounded p-3 text-center cursor-pointer active" id="theme-light-btn" onclick="setTheme('light')">
                                <div class="bg-light rounded mb-3" style="height: 100px; border: 2px solid #e3e6f0;">
                                    <div class="p-2 border-bottom d-flex gap-1">
                                        <div class="bg-secondary opacity-25 rounded-circle" style="width:8px;height:8px;"></div>
                                        <div class="bg-secondary opacity-25 rounded-circle" style="width:8px;height:8px;"></div>
                                    </div>
                                    <div class="p-2">
                                        <div class="bg-secondary opacity-10 rounded mb-1" style="height:10px;width:70%;"></div>
                                        <div class="bg-secondary opacity-10 rounded" style="height:10px;width:40%;"></div>
                                    </div>
                                </div>
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input" type="radio" name="theme_choice" id="theme_light" value="light">
                                    <label class="form-check-label ms-2 fw-bold" for="theme_light">Light Mode</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="theme-card border rounded p-3 text-center cursor-pointer" id="theme-dark-btn" onclick="setTheme('dark')">
                                <div class="bg-dark rounded mb-3" style="height: 100px; border: 2px solid #2d3748;">
                                    <div class="p-2 border-bottom border-secondary d-flex gap-1" style="opacity:0.3;">
                                        <div class="bg-light rounded-circle" style="width:8px;height:8px;"></div>
                                        <div class="bg-light rounded-circle" style="width:8px;height:8px;"></div>
                                    </div>
                                    <div class="p-2" style="opacity:0.2;">
                                        <div class="bg-light rounded mb-1" style="height:10px;width:70%;"></div>
                                        <div class="bg-light rounded" style="height:10px;width:40%;"></div>
                                    </div>
                                </div>
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input" type="radio" name="theme_choice" id="theme_dark" value="dark">
                                    <label class="form-check-label ms-2 fw-bold" for="theme_dark">Dark Mode</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Settings -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom px-4 py-3">
                    <h6 class="mb-0 fw-bold"><i class="feather-bell me-2 text-primary"></i>Pengaturan Notifikasi</h6>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-4">Atur jenis pemberitahuan yang ingin Anda lihat di panel notifikasi header. Pengaturan ini berlaku selama sesi login aktif.</p>
                    
                    <form action="{{ route('pengaturan.notifikasi.update') }}" method="POST">
                        @csrf
                        <div class="list-group list-group-flush border rounded overflow-hidden">
                            <div class="list-group-item p-3 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="mb-1 fw-bold">RPJM Desa</h6>
                                    <p class="text-muted small mb-0">Notifikasi pembuatan dan perubahan RPJM Desa.</p>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="notif_rpjm" id="notif_rpjm" {{ $notifPreferences['rpjm'] ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="list-group-item p-3 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="mb-1 fw-bold">Usulan Kegiatan</h6>
                                    <p class="text-muted small mb-0">Pemberitahuan usulan baru dari Operator Dusun.</p>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="notif_usulan" id="notif_usulan" {{ $notifPreferences['usulan'] ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="list-group-item p-3 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="mb-1 fw-bold">RKP Desa</h6>
                                    <p class="text-muted small mb-0">Update status verifikasi dan penetapan RKP Desa.</p>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="notif_rkpdesa" id="notif_rkpdesa" {{ $notifPreferences['rkpdesa'] ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="list-group-item p-3 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="mb-1 fw-bold">Berita Acara</h6>
                                    <p class="text-muted small mb-0">Notifikasi terkait dokumen Berita Acara Musyawarah.</p>
                                </div>
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" name="notif_berita_acara" id="notif_berita_acara" {{ $notifPreferences['berita_acara'] ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="feather-save me-2"></i>Simpan Notifikasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .theme-card {
        transition: all 0.2s ease;
        border-width: 2px !important;
    }
    .theme-card:hover {
        border-color: var(--bs-primary) !important;
        background-color: rgba(75, 59, 219, 0.02);
    }
    .theme-card.active {
        border-color: var(--bs-primary) !important;
        background-color: rgba(75, 59, 219, 0.05);
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endsection

@push('scripts')
<script>
    function setTheme(theme) {
        // Apply theme to document
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('admin-theme', theme);
        
        // Update UI
        updateThemeUI(theme);
        
        // Optional: Show toast
        Swal.fire({
            icon: 'success',
            title: 'Tema Berhasil Diubah',
            text: 'Tema ' + (theme === 'dark' ? 'Gelap' : 'Terang') + ' telah diterapkan.',
            timer: 1500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }

    function updateThemeUI(theme) {
        document.querySelectorAll('.theme-card').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('input[name="theme_choice"]').forEach(el => el.checked = false);
        
        if (theme === 'dark') {
            document.getElementById('theme-dark-btn').classList.add('active');
            document.getElementById('theme_dark').checked = true;
        } else {
            document.getElementById('theme-light-btn').classList.add('active');
            document.getElementById('theme_light').checked = true;
        }
    }

    // Initialize UI on load
    document.addEventListener('DOMContentLoaded', function() {
        const currentTheme = localStorage.getItem('admin-theme') || 'light';
        updateThemeUI(currentTheme);
    });
</script>
@endpush
