@extends('admin.layout')

@section('title', 'Pengaturan Profil')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Pengaturan Profil</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Profil</li>
                </ul>
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
                        <!-- No Actions -->
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

        <!--! [Start] Main Content !-->
        <div class="row">
            <div class="col-lg-4">
                <!--! [Start] Profile Card !-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom text-center">
                        <h6 class="mb-0">Profil Pengguna</h6>
                    </div>
                    <div class="card-body text-center p-4">
                        <div
                            class="avatar-xl bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                            <i class="feather-user fs-1"></i>
                        </div>
                        <h6 class="mb-1">{{ auth()->user()->name ?? 'User' }}</h6>
                        <p class="text-muted mb-3">{{ auth()->user()->email ?? 'email@example.com' }}</p>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editProfileModal">
                            <i class="feather-edit-2 me-1"></i>Edit Profil
                        </button>
                    </div>
                </div>
                <!--! [End] Profile Card !-->
            </div>

            <div class="col-lg-8">
                <!--! [Start] Settings Card !-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Pengaturan Umum</h6>
                    </div>
                    <div class="card-body p-4">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name ?? '' }}"
                                    disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email ?? '' }}"
                                    disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <input type="text" class="form-control" value="Administrator" disabled>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Bergabung Sejak</label>
                                <input type="text" class="form-control" value="1 Februari 2026" disabled>
                            </div>
                        </form>
                    </div>
                </div>
                <!--! [End] Settings Card !-->

                <!--! [Start] Security Card !-->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Keamanan</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                            <div>
                                <h6 class="mb-1">Ubah Kata Sandi</h6>
                                <p class="text-muted mb-0">Perbarui kata sandi akun Anda secara berkala</p>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#changePasswordModal">
                                Ubah
                            </button>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1">Verifikasi Dua Faktor</h6>
                                <p class="text-muted mb-0">Tingkatkan keamanan akun dengan verifikasi dua faktor</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="twoFactorCheck">
                            </div>
                        </div>
                    </div>
                </div>
                <!--! [End] Security Card !-->
            </div>
        </div>
        <!--! [End] Main Content !-->
    </div>

    <!--! [Start] Modal Edit Profil !-->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan nama lengkap"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan email" required>
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
    <!--! [End] Modal Edit Profil !-->

    <!--! [Start] Modal Ubah Kata Sandi !-->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Kata Sandi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kata Sandi Saat Ini</label>
                            <input type="password" class="form-control" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kata Sandi Baru</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Kata Sandi</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ubah Kata Sandi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--! [End] Modal Ubah Kata Sandi !-->

    <style>
        .avatar-xl {
            width: 100px;
            height: 100px;
        }

        .bg-light-primary {
            background-color: rgba(75, 59, 219, 0.1);
        }
    </style>
@endsection
