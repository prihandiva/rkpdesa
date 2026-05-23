{{--
    Komponen Info Card - Panduan Penggunaan
    Usage: @include('admin.components.info-card', ['steps' => [...], 'title' => '...', 'icon' => '...'])

    Format step:
    [
        'text'  => 'Teks kalimat dengan {BTN:icon:label:color} placeholder',
        'sub'   => [...] // opsional sub-steps
    ]

    Placeholder BTN di dalam text akan dirender sebagai badge button visual:
    {BTN:feather-icon:Label Teks:warna}
    Contoh: {BTN:feather-plus:Tambah RPJM:primary}
--}}

@php
    /**
     * Render placeholder {BTN:feather-icon:Label:color} menjadi button
     * dengan class SAMA PERSIS seperti tombol asli di aplikasi:
     *   btn btn-sm bg-light-{color} text-{color} border-0 shadow-sm
     *
     * Jika label kosong (icon-only), render tanpa margin icon.
     * 
     * Tambahan: Render placeholder {BDG:class_badge:Label} menjadi badge bulat.
     */
    function renderInfoText(string $text): string {
        $escaped = e($text);
        
        // Parse BTN
        $parsed = preg_replace_callback('/\{BTN:([\w-]+):(.*?):([\w-]+)\}/', function($m) {
            $icon    = $m[1];
            $label   = trim($m[2]);
            $color   = $m[3];
            $iconEl  = $label
                ? '<i class="' . $icon . ' me-1" style="font-size:12px;"></i>' . $label
                : '<i class="' . $icon . '" style="font-size:12px;"></i>';
            return '<span class="btn btn-sm bg-light-' . $color . ' text-' . $color . ' border-0 shadow-sm info-inline-btn">'
                 . $iconEl
                 . '</span>';
        }, $escaped);

        // Parse BDG
        $parsed = preg_replace_callback('/\{BDG:([\w-]+):(.*?)\}/', function($m) {
            $class = $m[1];
            $label = trim($m[2]);
            return '<span class="badge ' . $class . ' rounded-pill px-2 py-1">' . $label . '</span>';
        }, $parsed);

        return $parsed;
    }
@endphp

<div class="row mb-3" id="info-card-wrapper">
    <div class="col-12">
        <div class="info-guide-card">
            {{-- Header --}}
            <div class="info-guide-header" id="infoCardToggle" role="button" onclick="toggleInfoCard()" aria-expanded="true">
                <div class="d-flex align-items-center gap-2">
                    <div class="info-guide-icon-wrap">
                        <i class="{{ $icon ?? 'feather-info' }}"></i>
                    </div>
                    <div>
                        <div class="info-guide-title">Panduan Penggunaan</div>
                        <div class="info-guide-subtitle">{{ $title ?? 'Petunjuk alur pengisian data' }}</div>
                    </div>
                </div>
                <div class="info-guide-chevron" id="infoCardChevron">
                    <i class="feather-chevron-up"></i>
                </div>
            </div>

            {{-- Body --}}
            <div class="info-guide-body" id="infoCardBody">
                <ol class="info-guide-steps">
                    @foreach($steps as $step)
                        <li class="info-guide-step">
                            <div class="info-step-text">{!! renderInfoText($step['text']) !!}</div>
                            @if(!empty($step['sub']))
                                <ul class="info-step-sub">
                                    @foreach($step['sub'] as $sub)
                                        <li>{!! renderInfoText($sub) !!}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>

<style>
/* ── Info Guide Card ─────────────────────────────────────── */
.info-guide-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(79, 70, 229, 0.07);
}

.info-guide-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    cursor: pointer;
    user-select: none;
    transition: opacity 0.2s;
}
.info-guide-header:hover { opacity: 0.95; }

.info-guide-icon-wrap {
    width: 38px; height: 38px;
    background: rgba(255,255,255,0.2);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.1rem;
    flex-shrink: 0;
}

.info-guide-title {
    font-weight: 700;
    font-size: 0.95rem;
    color: #fff;
    line-height: 1.2;
}
.info-guide-subtitle {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.75);
    margin-top: 1px;
}

.info-guide-chevron {
    color: rgba(255,255,255,0.85);
    font-size: 1.1rem;
    transition: transform 0.3s ease;
}
.info-guide-chevron.collapsed { transform: rotate(180deg); }

.info-guide-body {
    padding: 18px 24px 16px;
    background: #fafbff;
    border-top: 1px solid #e8eaf6;
    overflow: hidden;
    transition: max-height 0.35s ease, padding 0.3s ease, opacity 0.3s;
    max-height: 1000px;
    opacity: 1;
}
.info-guide-body.collapsed {
    max-height: 0;
    padding-top: 0;
    padding-bottom: 0;
    opacity: 0;
    border-top-color: transparent;
}

/* ── Steps ───────────────────────────────────────────────── */
.info-guide-steps {
    margin: 0; padding: 0;
    list-style: none;
    counter-reset: info-step;
}

.info-guide-step {
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding: 9px 0;
    border-bottom: 1px dashed #e2e8f0;
    counter-increment: info-step;
}
.info-guide-step:last-child { border-bottom: none; padding-bottom: 0; }

.info-step-text {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 5px;
    font-size: 0.875rem;
    color: #374151;
    line-height: 1.6;
}
.info-step-text::before {
    content: counter(info-step);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px; height: 22px;
    min-width: 22px;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: #fff;
    border-radius: 50%;
    font-size: 0.72rem;
    font-weight: 700;
    margin-right: 4px;
    flex-shrink: 0;
}

.info-step-sub {
    list-style: none;
    padding-left: 32px;
    margin: 2px 0 0;
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.info-step-sub li {
    font-size: 0.825rem;
    color: #6b7280;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 4px;
}
.info-step-sub li::before {
    content: '›';
    color: #4f46e5;
    font-weight: bold;
    margin-right: 4px;
}

/* ── Inline Button Badges (memakai class asli aplikasi) ─── */
/* Tambahan kecil agar badge proporsional dalam baris teks   */
.info-inline-btn {
    display: inline-flex !important;
    align-items: center;
    vertical-align: middle;
    white-space: nowrap;
    padding: 2px 8px !important;
    font-size: 0.78rem !important;
    font-weight: 600;
    line-height: 1.5;
    pointer-events: none; /* hanya dekoratif */
    cursor: default;
}
</style>

<script>
function toggleInfoCard() {
    var body    = document.getElementById('infoCardBody');
    var chevron = document.getElementById('infoCardChevron');
    if (!body) return;
    body.classList.toggle('collapsed');
    chevron.classList.toggle('collapsed');
    // Simpan state ke localStorage agar persist across pages
    var isCollapsed = body.classList.contains('collapsed');
    localStorage.setItem('infoCardCollapsed', isCollapsed ? '1' : '0');
}

// Restore state on load
(function() {
    if (localStorage.getItem('infoCardCollapsed') === '1') {
        var body    = document.getElementById('infoCardBody');
        var chevron = document.getElementById('infoCardChevron');
        if (body)    body.classList.add('collapsed');
        if (chevron) chevron.classList.add('collapsed');
    }
})();
</script>
