@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4 pt-4 pb-4">

    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- HERO GREETING BAR                                        --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    <div class="db-hero mb-3">
        <div class="db-hero-left">
            <div class="db-hero-avatar">
                <i class="feather-home"></i>
            </div>
            <div>
                <p class="db-hero-sub">Selamat Datang Kembali 👋</p>
                <h4 class="db-hero-title">{{ session('user_name', 'Admin') }}</h4>
            </div>
        </div>
        <div class="db-hero-right">
            <form method="GET" action="{{ route('dashboard') }}" class="db-filter-form">
                <i class="feather-calendar"></i>
                <label for="tahun" class="db-filter-label">Tahun:</label>
                <select name="tahun" id="tahun" class="db-filter-select" onchange="this.form.submit()">
                    @foreach($tahunList as $tahun)
                        <option value="{{ $tahun->id_tahun }}" {{ $selectedTahunId == $tahun->id_tahun ? 'selected' : '' }}>
                            {{ $tahun->tahun }} {{ $tahun->status == 'Aktif' ? '★' : '' }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- STAT CARDS                                              --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-3">
        <div class="col-lg-4 col-md-6">
            <div class="db-stat-card db-stat-indigo">
                <div class="db-stat-body">
                    <p class="db-stat-label">Total RPJM</p>
                    <h2 class="db-stat-num">{{ number_format($totalRpjm) }}</h2>
                    <p class="db-stat-desc">Rencana Pembangunan Jangka Menengah</p>
                </div>
                <div class="db-stat-icon-wrap">
                    <i class="feather-file-text db-stat-icon"></i>
                </div>
                <div class="db-stat-glow"></div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="db-stat-card db-stat-emerald">
                <div class="db-stat-body">
                    <p class="db-stat-label">Total Usulan</p>
                    <h2 class="db-stat-num">{{ number_format($totalUsulan) }}</h2>
                    <p class="db-stat-desc">Usulan dari seluruh dusun</p>
                </div>
                <div class="db-stat-icon-wrap">
                    <i class="feather-edit-2 db-stat-icon"></i>
                </div>
                <div class="db-stat-glow"></div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="db-stat-card db-stat-cyan">
                <div class="db-stat-body">
                    <p class="db-stat-label">Total RKP Desa</p>
                    <h2 class="db-stat-num">{{ number_format($totalRkp) }}</h2>
                    <p class="db-stat-desc">Rencana Kerja Pemerintah Desa</p>
                </div>
                <div class="db-stat-icon-wrap">
                    <i class="feather-send db-stat-icon"></i>
                </div>
                <div class="db-stat-glow"></div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- TIMELINE + STATUS LEGEND                                --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-3">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom px-4 py-3 d-flex align-items-center gap-3">
                    <span class="db-card-icon-badge db-badge-indigo">
                        <i class="feather-git-commit"></i>
                    </span>
                    <h6 class="mb-0 fw-bold">Alur Pengajuan RKP Desa</h6>
                </div>
                <div class="card-body px-4 py-4">
                    <div class="db-timeline">
                        @php
                        $steps = [
                            ['num'=>1,'color'=>'#4f46e5','title'=>'Penyusunan RPJM Desa','desc'=>'RPJM Desa dibuat oleh Operator Desa.'],
                            ['num'=>2,'color'=>'#10b981','title'=>'Input Usulan','desc'=>'Usulan diinput oleh Operator Dusun.'],
                            ['num'=>3,'color'=>'#06b6d4','title'=>'Pemilihan Usulan Kegiatan','desc'=>'Dilakukan oleh Operator Desa ketika musyawarah.'],
                            ['num'=>4,'color'=>'#8b5cf6','title'=>'Verifikasi Kegiatan','desc'=>'Diverifikasi oleh Tim Verifikasi.'],
                            ['num'=>5,'color'=>'#f59e0b','title'=>'Penyusunan RKP Desa','desc'=>'RKP Desa disusun oleh Tim Penyusun RKP Desa.'],
                            ['num'=>6,'color'=>'#ef4444','title'=>'Approval BPD','desc'=>'Oleh BPD Desa Pandan Landung.'],
                        ];
                        @endphp
                        @foreach($steps as $i => $step)
                        <div class="db-tl-item {{ $i == count($steps)-1 ? 'db-tl-last' : '' }}">
                            <div class="db-tl-dot" style="background:{{ $step['color'] }};">{{ $step['num'] }}</div>
                            <div class="db-tl-line" style="{{ $i == count($steps)-1 ? 'display:none;' : "background: linear-gradient(to bottom, {$step['color']}44, transparent);" }}"></div>
                            <div class="db-tl-content">
                                <h6 class="fw-bold mb-1" style="color:{{ $step['color'] }}">{{ $step['title'] }}</h6>
                                <p class="text-muted mb-0 small">{{ $step['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Legend --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom px-4 py-3 d-flex align-items-center gap-3">
                    <span class="db-card-icon-badge db-badge-cyan">
                        <i class="feather-info"></i>
                    </span>
                    <h6 class="mb-0 fw-bold">Keterangan Status</h6>
                </div>
                <div class="card-body px-4 py-3">
                    @php
                    $statuses = [
                        ['label'=>'Proses','desc'=>'Sudah tersubmit ke database','bg'=>'#dbeafe','color'=>'#1d4ed8'],
                        ['label'=>'Pending','desc'=>'Masuk daftar tunggu RKP Desa','bg'=>'#fef3c7','color'=>'#92400e'],
                        ['label'=>'Terverifikasi','desc'=>'Diverifikasi oleh Tim Verifikasi','bg'=>'#d1fae5','color'=>'#065f46'],
                        ['label'=>'Gagal Terverifikasi','desc'=>'Gagal proses verifikasi','bg'=>'#fee2e2','color'=>'#991b1b'],
                        ['label'=>'Menunggu persetujuan BPD','desc'=>'Menunggu approval BPD','bg'=>'#ede9fe','color'=>'#5b21b6'],
                        ['label'=>'Disetujui','desc'=>'Telah disetujui oleh BPD','bg'=>'#dcfce7','color'=>'#166534'],
                        ['label'=>'Ditolak BPD','desc'=>'BPD menolak usulan terkait','bg'=>'#fce7f3','color'=>'#9d174d'],
                    ];
                    @endphp
                    <div class="d-flex flex-column gap-2">
                        @foreach($statuses as $s)
                        <div class="db-status-row">
                            <span class="db-status-pill" style="background:{{ $s['bg'] }};color:{{ $s['color'] }};">
                                {{ $s['label'] }}
                            </span>
                            <span class="db-status-desc">{{ $s['desc'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- CHARTS                                                   --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-3">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom px-4 py-3 d-flex align-items-center gap-3">
                    <span class="db-card-icon-badge db-badge-indigo">
                        <i class="feather-pie-chart"></i>
                    </span>
                    <div>
                        <h6 class="mb-0 fw-bold">Jumlah Usulan per Dusun</h6>
                        <p class="mb-0 small text-muted">{{ $selectedTahun ? $selectedTahun->tahun : 'Semua Tahun' }}</p>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($usulanPerDusunData->isEmpty())
                        <div class="db-empty-state">
                            <i class="feather-inbox"></i>
                            <p>Tidak ada data usulan</p>
                        </div>
                    @else
                        <div id="usulanPerDusunChart" style="min-height:340px;"></div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Chart 2: Usulan per Status --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom px-4 py-3 d-flex align-items-center gap-3">
                    <span class="db-card-icon-badge db-badge-emerald">
                        <i class="feather-bar-chart-2"></i>
                    </span>
                    <div>
                        <h6 class="mb-0 fw-bold">Status Usulan</h6>
                        <p class="mb-0 small text-muted">{{ $selectedTahun ? $selectedTahun->tahun : 'Semua Tahun' }}</p>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($usulanPerStatusData->isEmpty())
                        <div class="db-empty-state">
                            <i class="feather-inbox"></i>
                            <p>Tidak ada data usulan</p>
                        </div>
                    @else
                        <div id="usulanPerStatusChart" style="min-height:340px;"></div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Chart 3: RKP per Status --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom px-4 py-3 d-flex align-items-center gap-3">
                    <span class="db-card-icon-badge db-badge-cyan">
                        <i class="feather-activity"></i>
                    </span>
                    <div>
                        <h6 class="mb-0 fw-bold">Status Kegiatan RKP Desa</h6>
                        <p class="mb-0 small text-muted">{{ $selectedTahun ? $selectedTahun->tahun : 'Semua Tahun' }}</p>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($rkpPerStatusData->isEmpty())
                        <div class="db-empty-state">
                            <i class="feather-inbox"></i>
                            <p>Tidak ada data RKP Desa</p>
                        </div>
                    @else
                        <div id="rkpPerStatusChart" style="min-height:340px;"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════════════════ --}}
{{-- STYLES                                                         --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<style>
/* ─── Hero Greeting ─── */
.db-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #06b6d4 100%);
    border-radius: 14px;
    padding: 18px 24px;
    color: #fff;
    box-shadow: 0 4px 20px rgba(79,70,229,0.25);
}
.db-hero-left { display: flex; align-items: center; gap: 14px; }
.db-hero-avatar {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    backdrop-filter: blur(4px);
}
.db-hero-sub { margin: 0; font-size: 12px; opacity: 0.8; }
.db-hero-title { margin: 2px 0 0; font-size: 18px; font-weight: 700; color: #fff;}

.db-filter-form {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 10px;
    padding: 6px 14px;
}
.db-filter-form i { font-size: 14px; opacity: 0.9; }
.db-filter-label { font-size: 13px; font-weight: 600; margin: 0; white-space: nowrap; }
.db-filter-select {
    background: transparent;
    border: none;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    outline: none;
    min-width: 120px;
}
.db-filter-select option { color: #1e293b; background: #fff; }

/* ─── Stat Cards ─── */
.db-stat-card {
    border-radius: 14px;
    padding: 20px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
    color: #fff;
    box-shadow: 0 4px 16px rgba(0,0,0,0.10);
    transition: transform 0.2s, box-shadow 0.2s;
    height: 100%;
}
.db-stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,0.15); }

.db-stat-indigo { background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); }
.db-stat-emerald { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
.db-stat-cyan    { background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%); }

.db-stat-label { margin: 0 0 2px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; opacity: 0.85; color: #fff !important; }
.db-stat-num   { font-size: 36px; font-weight: 800; margin: 0 0 2px; line-height: 1.1; color: #fff !important; }
.db-stat-desc  { margin: 0; font-size: 11px; opacity: 0.75; color: #fff !important; }

.db-stat-icon-wrap {
    width: 56px; height: 56px;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.db-stat-icon { font-size: 24px; opacity: 0.9; }
.db-stat-glow {
    position: absolute;
    width: 130px; height: 130px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
    bottom: -40px; left: -30px;
    pointer-events: none;
}

/* ─── Card Icon Badge ─── */
.db-card-icon-badge {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
}
.db-badge-indigo { background: rgba(79,70,229,0.12); color: #4f46e5; }
.db-badge-emerald { background: rgba(5,150,105,0.12); color: #059669; }
.db-badge-cyan { background: rgba(8,145,178,0.12); color: #0891b2; }

/* ─── Timeline ─── */
.db-timeline { position: relative; }
.db-tl-item {
    display: flex;
    gap: 16px;
    position: relative;
    padding-bottom: 24px;
}
.db-tl-last { padding-bottom: 0; }
.db-tl-dot {
    width: 34px; height: 34px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 14px; color: #fff;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    position: relative; z-index: 1;
}
.db-tl-line {
    position: absolute;
    left: 16px;
    top: 34px;
    width: 2px;
    height: calc(100% - 10px);
}
.db-tl-content { padding-top: 6px; }

/* ─── Status Legend ─── */
.db-status-row {
    display: flex;
    align-items: center;
    gap: 10px;
}
.db-status-pill {
    font-size: 11px;
    font-weight: 600;
    border-radius: 20px;
    padding: 4px 10px;
    white-space: nowrap;
    flex-shrink: 0;
    min-width: 130px;
    text-align: center;
}
.db-status-desc {
    font-size: 12px;
    color: #64748b;
    line-height: 1.3;
}

/* ─── Empty State ─── */
.db-empty-state {
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; padding: 60px 20px; color: #94a3b8;
}
.db-empty-state i { font-size: 48px; margin-bottom: 12px; }
.db-empty-state p { margin: 0; font-size: 14px; }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {

    // ─── Vibrant color palette ───
    const vibrantColors = [
        '#4f46e5', '#10b981', '#06b6d4', '#f59e0b',
        '#ef4444', '#8b5cf6', '#ec4899', '#f97316',
        '#14b8a6', '#6366f1'
    ];

    const statusColorsMap = {
        'Proses':                      '#4f46e5',
        'Pending':                     '#f59e0b',
        'Terverifikasi':               '#10b981',
        'Gagal Terverifikasi':         '#ef4444',
        'Disetujui':                   '#059669',
        'Menunggu persetujuan BPD':    '#8b5cf6',
        'Ditolak BPD':                 '#ec4899'
    };
    const getStatusColor = (s) => statusColorsMap[s] || '#64748b';

    const chartDefaults = {
        fontFamily: 'Inter, sans-serif',
        toolbar: { show: false },
        dropShadow: { enabled: false }
    };

    // ─── Chart 1: Usulan per Dusun (Donut) ───
    var usulanDusunData = {!! json_encode($usulanPerDusunData ?? []) !!};
    if (usulanDusunData && usulanDusunData.length > 0) {
        var chart1 = new ApexCharts(document.querySelector("#usulanPerDusunChart"), {
            series: usulanDusunData.map(d => parseInt(d.total)),
            labels: usulanDusunData.map(d => d.dusun),
            chart: { ...chartDefaults, type: 'donut', height: 340 },
            colors: vibrantColors,
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Usulan',
                                fontSize: '13px',
                                fontWeight: 600,
                                color: '#64748b',
                                formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                            }
                        }
                    }
                }
            },
            legend: { position: 'bottom', fontSize: '13px', fontWeight: 500 },
            dataLabels: {
                enabled: true,
                formatter: (val) => Math.round(val) + '%',
                dropShadow: { enabled: false }
            },
            stroke: { width: 2, colors: ['#fff'] },
            tooltip: {
                y: { formatter: (val) => val + ' usulan' }
            }
        });
        chart1.render();
    }

    // ─── Chart 2: Usulan per Status (Bar) ───
    var usulanStatusData = {!! json_encode($usulanPerStatusData ?? []) !!};
    if (usulanStatusData && usulanStatusData.length > 0) {
        var statusLabels = usulanStatusData.map(d => d.status);
        var statusValues = usulanStatusData.map(d => parseInt(d.total));
        var statusMax    = Math.max(...statusValues, 1); // minimal 1 agar tidak error
        var chart2 = new ApexCharts(document.querySelector("#usulanPerStatusChart"), {
            series: [{ name: 'Jumlah', data: statusValues }],
            chart: { ...chartDefaults, type: 'bar', height: 340 },
            colors: statusLabels.map(getStatusColor),
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    columnWidth: '52%',
                    distributed: true,
                    dataLabels: { position: 'top' }
                }
            },
            dataLabels: {
                enabled: true,
                offsetY: -22,
                style: { fontSize: '12px', fontWeight: 700, colors: ['#1e293b'] }
            },
            legend: { show: false },
            xaxis: {
                categories: statusLabels,
                labels: {
                    style: { colors: '#64748b', fontSize: '11px', fontWeight: 500 },
                    rotate: -20
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                min: 0,
                max: statusMax,
                tickAmount: statusMax, // 1 tick per bilangan bulat
                labels: {
                    formatter: (v) => (Number.isInteger(v) ? v : ''),
                    style: { colors: '#94a3b8' }
                }
            },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
            tooltip: { y: { formatter: (v) => v + ' usulan' } }
        });
        chart2.render();
    }

    // ─── Chart 3: RKP per Status (Radial/Donut) ───
    var rkpStatusData = {!! json_encode($rkpPerStatusData ?? []) !!};
    if (rkpStatusData && rkpStatusData.length > 0) {
        var rkpLabels = rkpStatusData.map(d => d.status);
        var chart3 = new ApexCharts(document.querySelector("#rkpPerStatusChart"), {
            series: [{ name: 'Kegiatan', data: rkpStatusData.map(d => parseInt(d.total)) }],
            chart: { ...chartDefaults, type: 'bar', height: 340 },
            colors: rkpLabels.map(getStatusColor),
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    horizontal: true,
                    barHeight: '55%',
                    distributed: true,
                    dataLabels: { position: 'bottom' }
                }
            },
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                offsetX: 8,
                style: { fontSize: '12px', fontWeight: 700, colors: ['#fff'] },
                formatter: (val) => val + ' kegiatan'
            },
            legend: { show: false },
            xaxis: {
                categories: rkpLabels,
                labels: {
                    style: { colors: '#64748b', fontSize: '12px' }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: { colors: '#334155', fontSize: '12px', fontWeight: 600 }
                }
            },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
            tooltip: { y: { formatter: (v) => v + ' kegiatan' } }
        });
        chart3.render();
    }
});
</script>
@endpush
