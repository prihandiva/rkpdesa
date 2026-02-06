@extends('admin.layout')

@section('title', 'Monitoring Sistem')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Monitoring Sistem</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Monitoring</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <!-- Login Activity Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Aktivitas Login (7 Hari Terakhir)</h5>
                </div>
                <div class="card-body">
                    <div id="loginActivityChart"></div>
                </div>
            </div>
        </div>

        <!-- Activity Distribution Chart -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Distribusi Aktivitas</h5>
                </div>
                <div class="card-body">
                    <div id="activityDistributionChart"></div>
                </div>
            </div>
        </div>

        <!-- Activity Log Table -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Log Aktivitas Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Aktivitas</th>
                                    <th>IP Address</th>
                                    <th>User Agent</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d M Y H:i:s') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-primary fw-bold">{{ substr($log->user->nama ?? 'U', 0, 1) }}</span>
                                            </div>
                                            <span>{{ $log->user->nama ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light-info text-info">{{ $log->user->role ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        @if($log->activity_type == 'login')
                                            <span class="badge bg-success">Login</span>
                                        @else
                                            <span class="badge bg-warning">Logout</span>
                                        @endif
                                    </td>
                                    <td>{{ $log->ip_address }}</td>
                                    <td class="text-truncate" style="max-width: 200px;" title="{{ $log->user_agent }}">
                                        {{ $log->user_agent }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data aktivitas.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Line Chart: User Logins
        var loginOptions = {
            series: [{
                name: 'Logins',
                data: @json($chartData)
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: { enabled: false },
                toolbar: { show: false }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth' },
            colors: ['#4b3bdb'],
            xaxis: {
                categories: @json($categories),
            },
            yaxis: {
                min: 0,
                forceNiceScale: true
            }
        };

        var loginChart = new ApexCharts(document.querySelector("#loginActivityChart"), loginOptions);
        loginChart.render();

        // Pie Chart: Distribution
        var pieOptions = {
            series: @json($pieSeries),
            chart: {
                width: 380,
                type: 'pie',
                toolbar: { show: false }
            },
            labels: @json($pieLabels),
            colors: ['#28a745', '#ffc107', '#dc3545'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: { width: 300 },
                    legend: { position: 'bottom' }
                }
            }]
        };

        var pieChart = new ApexCharts(document.querySelector("#activityDistributionChart"), pieOptions);
        pieChart.render();
    });
</script>
@endpush
@endsection
