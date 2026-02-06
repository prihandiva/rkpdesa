@extends('admin.layout')

@section('title', 'Dashboard - RKP Desa')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Dashboard</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Dashboard</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <!-- Welcome Card -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h4">Selamat datang, {{ session('user_name') }}! 👋</h2>
                    <p class="text-muted mb-0">Anda telah berhasil login ke Sistem Rencana Kerja Pembangunan Desa</p>
                </div>
            </div>
        </div>

        <!-- Dashboard Widgets -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <span class="text-muted">Status</span>
                        </div>
                        <div class="avatar-text avatar-sm bg-light-primary text-primary rounded">
                            <i class="feather-check-circle"></i>
                        </div>
                    </div>
                    <h3 class="mb-2">Aktif</h3>
                    <p class="text-xs text-muted mb-0">Akun Anda aktif</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <span class="text-muted">Peran</span>
                        </div>
                        <div class="avatar-text avatar-sm bg-light-success text-success rounded">
                            <i class="feather-user"></i>
                        </div>
                    </div>
                    <h3 class="mb-2 text-capitalize">{{ session('user_role') }}</h3>
                    <p class="text-xs text-muted mb-0">Akses level {{ session('user_role') }}</p>
                </div>
            </div>
        </div>

        <!-- User Information -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h6 class="mb-0">Informasi Pengguna</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="avatar-lg bg-light-primary rounded-circle d-flex align-items-center justify-content-center">
                                <span class="fs-3 text-primary">{{ substr(session('user_name', 'U'), 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1">{{ session('user_name') }}</h5>
                            <p class="text-muted mb-0">{{ session('user_role') }}</p>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted py-2" width="120">ID User</td>
                                    <td class="fw-bold py-2">{{ session('user_id') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-2">Waktu Login</td>
                                    <td class="fw-bold py-2">{{ now()->format('d M Y H:i:s') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h6 class="mb-0">Akses Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                         @if(session('user_role') !== 'operator_desa') <!-- Example condition -->
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                                <i class="feather-layout me-2"></i> Ke Dashboard Admin
                            </a>
                        @endif
                         <!-- Add more buttons as needed based on logic -->
                         <button class="btn btn-outline-secondary">
                             <i class="feather-settings me-2"></i> Pengaturan Akun
                         </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
