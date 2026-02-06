@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Dashboard</li>
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
                        <span class="badge bg-primary">Selamat Datang</span>
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

        <!--! [Start] Main Dashboard Card !-->
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0"><i class="feather-info me-2"></i>Selamat Datang di Panel Admin</h6>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="mb-3">RKP Desa Management System</h5>
                        <p class="text-muted">Sistem Manajemen RKP (Rencana Kerja Pembangunan) Desa terpadu dengan template
                            Duralux.</p>

                        <div class="alert alert-light border" role="alert">
                            <strong>Informasi:</strong> Template admin ini menggunakan framework Bootstrap 5 dengan Duralux
                            Admin Template untuk tampilan modern dan responsif.
                        </div>

                        <h6 class="mt-4 mb-3">Menu Utama yang Tersedia:</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="feather-edit-2 text-primary me-2"></i>
                                <strong>Usulan</strong> - Kelola data usulan pembangunan desa
                            </li>
                            <li class="list-group-item">
                                <i class="feather-file-text text-primary me-2"></i>
                                <strong>RPJM Desa</strong> - Kelola Rencana Pembangunan Jangka Menengah
                            </li>
                            <li class="list-group-item">
                                <i class="feather-send text-primary me-2"></i>
                                <strong>RKP Desa</strong> - Kelola Rencana Kerja Pembangunan Desa
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!--! [Start] Info Card 1 !-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div
                                class="avatar-lg bg-light-primary text-primary rounded-3 d-flex align-items-center justify-content-center me-3">
                                <i class="feather-users fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Total Pengguna</h6>
                                <h4 class="mb-0">0</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!--! [End] Info Card 1 !-->

                <!--! [Start] Info Card 2 !-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div
                                class="avatar-lg bg-light-success text-success rounded-3 d-flex align-items-center justify-content-center me-3">
                                <i class="feather-edit-2 fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Total Usulan</h6>
                                <h4 class="mb-0">0</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!--! [End] Info Card 2 !-->

                <!--! [Start] Info Card 3 !-->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div
                                class="avatar-lg bg-light-info text-info rounded-3 d-flex align-items-center justify-content-center me-3">
                                <i class="feather-send fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Total RKP</h6>
                                <h4 class="mb-0">0</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!--! [End] Info Card 3 !-->
            </div>
        </div>
        <!--! [End] Main Dashboard Card !-->
    </div>

    <style>
        .avatar-lg {
            width: 60px;
            height: 60px;
        }

        .bg-light-primary {
            background-color: rgba(75, 59, 219, 0.1);
        }

        .bg-light-success {
            background-color: rgba(40, 167, 69, 0.1);
        }

        .bg-light-info {
            background-color: rgba(23, 162, 184, 0.1);
        }

        .rounded-3 {
            border-radius: 0.5rem !important;
        }
    </style>
@endsection
