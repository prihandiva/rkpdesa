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
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
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
                        <span class="badge bg-primary">Selamat Datang, {{ session('user_name') }}! 👋</span>
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

        <!-- Filter Row -->
        <div class="row border-bottom pb-4 mb-4 g-4 d-flex justify-content-between align-items-center">
            <div class="col-md-6">
                 <h4 class="mb-0 fw-bold">Statistik Data {{ $selectedTahun ? $selectedTahun->tahun : 'Semua Tahun' }}</h4>
            </div>
            <div class="col-md-auto">
                 <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center bg-white p-2 rounded shadow-sm border">
                     <i class="feather-filter text-primary me-2 ms-1"></i>
                     <label for="tahun" class="me-3 fw-bold mb-0 text-dark">Tahun Data:</label>
                     <select name="tahun" id="tahun" class="form-select form-select-sm border-0 bg-light" onchange="this.form.submit()" style="min-width: 150px; cursor:pointer;">
                         @foreach($tahunList as $tahun)
                             <option value="{{ $tahun->id_tahun }}" {{ $selectedTahunId == $tahun->id_tahun ? 'selected' : '' }}>
                                 {{ $tahun->tahun }} {{ $tahun->status == 'Aktif' ? '(Aktif)' : '' }}
                             </option>
                         @endforeach
                     </select>
                 </form>
             </div>
        </div>

        <!--! [Start] Main Dashboard Card !-->
        <div class="row">

            <div class="col-lg-4">
                <!--! [Start] Info Card 1 !-->
                <div class="card border-0 shadow-sm mb-4 bg-primary text-white overflow-hidden position-relative">
                    <div class="card-body p-4 position-relative z-1">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 fw-bold text-white-50">Total Pengguna</h6>
                            <i class="feather-users fs-3 text-white-50"></i>
                        </div>
                        <h2 class="mb-0 fw-bolder">{{ number_format($totalUsers) }}</h2>
                    </div>
                    <div class="position-absolute" style="right: -20px; bottom: -20px; opacity: 0.2; transform: rotate(-15deg);">
                        <i class="feather-users" style="font-size: 100px;"></i>
                    </div>
                </div>
                <!--! [End] Info Card 1 !-->
            </div>

            <div class="col-lg-4">
                <!--! [Start] Info Card 2 !-->
                <div class="card border-0 shadow-sm mb-4 bg-success text-white overflow-hidden position-relative">
                    <div class="card-body p-4 position-relative z-1">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 fw-bold text-white-50">Total Usulan</h6>
                            <i class="feather-edit-2 fs-3 text-white-50"></i>
                        </div>
                        <h2 class="mb-0 fw-bolder">{{ number_format($totalUsulan) }}</h2>
                    </div>
                     <div class="position-absolute" style="right: -20px; bottom: -20px; opacity: 0.2; transform: rotate(-15deg);">
                        <i class="feather-edit-2" style="font-size: 100px;"></i>
                    </div>
                </div>
                <!--! [End] Info Card 2 !-->
            </div>
            
            <div class="col-lg-4">
                <!--! [Start] Info Card 3 !-->
                <div class="card border-0 shadow-sm bg-info text-white overflow-hidden position-relative mb-4">
                    <div class="card-body p-4 position-relative z-1">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                             <h6 class="mb-0 fw-bold text-white-50">Total RKP Desa</h6>
                             <i class="feather-send fs-3 text-white-50"></i>
                         </div>
                         <h2 class="mb-0 fw-bolder">{{ number_format($totalRkp) }}</h2>
                    </div>
                    <div class="position-absolute" style="right: -20px; bottom: -20px; opacity: 0.2; transform: rotate(-15deg);">
                        <i class="feather-send" style="font-size: 100px;"></i>
                    </div>
                </div>
                <!--! [End] Info Card 3 !-->
                 
            </div>
        </div>

        <div class="row">
            <!-- Chart 1: Usulan per Dusun -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom p-3 d-flex align-items-center">
                        <div class="avatar-sm bg-light-primary text-primary rounded d-flex align-items-center justify-content-center me-2">
                             <i class="feather-pie-chart"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Jumlah Usulan dr. Dusun</h6>
                    </div>
                    <div class="card-body p-4">
                        @if($usulanPerDusunData->isEmpty())
                             <div class="text-center text-muted py-5">
                                 <i class="feather-inbox fs-1 mb-2"></i>
                                 <p>Tidak ada data usulan untuk tahun ini.</p>
                             </div>
                        @else
                            <div id="usulanPerDusunChart" style="min-height: 350px; width: 100%;"></div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Chart 2: Usulan per Status -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom p-3 d-flex align-items-center">
                         <div class="avatar-sm bg-light-success text-success rounded d-flex align-items-center justify-content-center me-2">
                             <i class="feather-bar-chart-2"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Status Usulan ({{ $selectedTahun ? $selectedTahun->tahun : 'Semua Tahun' }})</h6>
                    </div>
                    <div class="card-body p-4">
                        @if($usulanPerStatusData->isEmpty())
                             <div class="text-center text-muted py-5">
                                 <i class="feather-inbox fs-1 mb-2"></i>
                                 <p>Tidak ada data usulan untuk tahun ini.</p>
                             </div>
                        @else
                            <div id="usulanPerStatusChart" style="min-height: 350px; width: 100%;"></div>
                        @endif
                    </div>
                </div>
            </div>

             <!-- Chart 3: RKP Desa per Status -->
             <div class="col-lg-12 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom p-3 d-flex align-items-center">
                        <div class="avatar-sm bg-light-info text-info rounded d-flex align-items-center justify-content-center me-2">
                             <i class="feather-pie-chart"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Status Kegiatan RKP Desa ({{ $selectedTahun ? $selectedTahun->tahun : 'Semua Tahun' }})</h6>
                    </div>
                    <div class="card-body p-4">
                        @if($rkpPerStatusData->isEmpty())
                            <div class="text-center text-muted py-5">
                                 <i class="feather-inbox fs-1 mb-2"></i>
                                 <p>Tidak ada data RKP Desa untuk tahun ini.</p>
                             </div>
                        @else
                            <div id="rkpPerStatusChart" style="min-height: 350px; width: 100%;"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--! [End] Main Dashboard Card !-->
    </div>

    <style>
        .avatar-sm { width: 32px; height: 32px; flex-shrink: 0; }
        .bg-light-primary { background-color: rgba(75, 59, 219, 0.1); }
        .bg-light-success { background-color: rgba(40, 167, 69, 0.1); }
        .bg-light-info { background-color: rgba(23, 162, 184, 0.1); }
        
        /* ApexChart overrides for cleaner look */
        .apexcharts-toolbar { z-index: 10 !important; }
        .apexcharts-legend-text { font-family: 'Inter', sans-serif !important; color: #6c757d !important; }
        .apexcharts-tooltip { font-family: 'Inter', sans-serif !important; border-radius: 8px !important; box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important; border: 0 !important; }
    </style>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- 1. Usulan Per Dusun (Pie Chart) ---
        var usulanDusunData = {!! json_encode($usulanPerDusunData ?? []) !!};
        if (usulanDusunData && usulanDusunData.length > 0) {
            var dusunLabels = usulanDusunData.map(item => item.dusun);
            var dusunSeries = usulanDusunData.map(item => parseInt(item.total));
            
            var optionsDusun = {
                series: dusunSeries,
                labels: dusunLabels,
                chart: {
                    type: 'donut',
                    height: 350
                },
                colors: ['#4b3bdb', '#28a745', '#17a2b8', '#ffc107', '#dc3545', '#6c757d', '#e83e8c', '#fd7e14']
            };
            var chartDusun = new ApexCharts(document.querySelector("#usulanPerDusunChart"), optionsDusun);
            chartDusun.render();
        }

        // --- 2. Usulan Per Status (Bar Chart) ---
        var usulanStatusData = {!! json_encode($usulanPerStatusData ?? []) !!};
        if (usulanStatusData && usulanStatusData.length > 0) {
            var statusLabels = usulanStatusData.map(item => item.status);
            var statusSeries = usulanStatusData.map(item => parseInt(item.total));
            
            var optionsStatus = {
                series: [{ name: 'Jumlah', data: statusSeries }],
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        columnWidth: '45%',
                        distributed: true,
                    }
                },
                dataLabels: { enabled: false },
                legend: { show: false },
                xaxis: {
                    categories: statusLabels,
                    labels: {
                        style: {
                            colors: '#6c757d',
                            fontSize: '12px'
                        }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                     labels: { style: { colors: '#6c757d' } }
                },
                colors: ['#4b3bdb', '#28a745', '#ffc107', '#17a2b8', '#dc3545', '#6c757d'],
                grid: {
                    borderColor: '#f1f1f1',
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } }
                }
            };
            var chartStatus = new ApexCharts(document.querySelector("#usulanPerStatusChart"), optionsStatus);
            chartStatus.render();
        }

        // --- 3. RKP Desa Per Status (Donut Chart) ---
        var rkpStatusData = {!! json_encode($rkpPerStatusData ?? []) !!};
        if (rkpStatusData && rkpStatusData.length > 0) {
            var rkpLabels = rkpStatusData.map(item => item.status);
            var rkpSeries = rkpStatusData.map(item => parseInt(item.total));
            
            var optionsRkpStatus = {
                series: rkpSeries,
                labels: rkpLabels,
                chart: {
                    type: 'donut',
                    height: 350
                },
                colors: ['#17a2b8', '#28a745', '#ffc107', '#4b3bdb', '#dc3545', '#6c757d']
            };
            var chartRkpStatus = new ApexCharts(document.querySelector("#rkpPerStatusChart"), optionsRkpStatus);
            chartRkpStatus.render();
        }
    });
</script>
@endpush

