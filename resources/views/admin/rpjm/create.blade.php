@extends('admin.layout')

@section('title', 'Tambah RPJM')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Input Data RPJM</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rpjm.index') }}">RPJM</a></li>
                    <li class="breadcrumb-item">Input Baru</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="{{ route('rpjm.index') }}" class="btn btn-md btn-secondary">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali ke Daftar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ page-header ] end -->

        <div class="row">
            <!--! [Start] Main Form Column !-->
            <div class="col-lg-8">
                <!--! [Start] Form Card !-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Form Input RPJM</h6>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('rpjm.store') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Bidang <span class="text-danger">*</span></label>
                                    <select class="form-select" name="bidang" required>
                                        <option value="">-- Pilih Bidang --</option>
                                        @foreach($bidangs as $bidang)
                                            <option value="{{ $bidang->id_bidang }}" {{ old('bidang') == $bidang->id_bidang ? 'selected' : '' }}>{{ $bidang->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sub Bidang</label>
                                    <input type="text" class="form-control" name="subbidang" value="{{ old('subbidang') }}" placeholder="Contoh: Pembangunan Jalan">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Kegiatan / Nama Kegiatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jenis_kegiatan" required placeholder="Nama kegiatan..." value="{{ old('jenis_kegiatan') }}">
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" class="form-control" name="lokasi" value="{{ old('lokasi') }}" placeholder="Lokasi kegiatan...">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Volume</label>
                                    <input type="text" class="form-control" name="volume" value="{{ old('volume') }}" placeholder="Contoh: 100 m">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Sasaran / Penerima Manfaat</label>
                                    <input type="text" class="form-control" name="sasaran" value="{{ old('sasaran') }}" placeholder="Contoh: Warga Dusun 1">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Waktu Pelaksanaan</label>
                                    <input type="text" class="form-control" name="waktu" value="{{ old('waktu') }}" placeholder="Contoh: 3 Bulan">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Perkiraan Biaya (Rp)</label>
                                    <input type="number" class="form-control" name="jumlah" value="{{ old('jumlah') }}" placeholder="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Sumber Biaya</label>
                                    <select class="form-select" name="sumber_biaya">
                                        <option value="">-- Pilih Sumber --</option>
                                        @foreach($sumber_biayas as $sb)
                                            <option value="{{ $sb->id_biaya }}" {{ old('sumber_biaya') == $sb->id_biaya ? 'selected' : '' }}>{{ $sb->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pola Pelaksanaan</label>
                                    <select class="form-select" name="pola_pelaksanaan">
                                        <option value="">-- Pilih Pola --</option>
                                        @foreach($pola_pelaksanaans as $pp)
                                            <option value="{{ $pp->id_pelaksanaan }}" {{ old('pola_pelaksanaan') == $pp->id_pelaksanaan ? 'selected' : '' }}>{{ $pp->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prioritas <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="prioritas" required placeholder="Masukkan angka prioritas (1, 2, 3...)" min="1">
                                    <div class="form-text text-muted">Angka prioritas harus unik dalam satu bidang.</div>
                                    <small class="text-danger" id="prioritas-error" style="display:none;"></small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather-plus-circle me-1"></i> Simpan ke Daftar RPJM
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--! [End] Form Card !-->

                <!--! [Start] Draft List Card !-->
                @if(isset($draftRpjms) && count($draftRpjms) > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Daftar RPJM Terinput ({{ count($draftRpjms) }})</h6>
                        <span class="badge bg-primary">Draft / Pending</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kegiatan</th>
                                        <th>Lokasi</th>
                                        <th>Biaya</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($draftRpjms as $draft)
                                    <tr>
                                        <td>{{ Str::limit($draft->jenis_kegiatan, 40) }}</td>
                                        <td>{{ $draft->lokasi ?? '-' }}</td>
                                        <td>{{ $draft->jumlah ? 'Rp '.number_format($draft->jumlah,0,',','.') : '-' }}</td>
                                        <td><span class="badge bg-secondary">{{ $draft->status }}</span></td>
                                        <td>
                                            <form action="{{ route('rpjm.destroy', $draft->id_rpjm) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus item ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-xs btn-outline-danger"><i class="feather-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
                <!--! [End] Draft List Card !-->

            </div>
            <!--! [End] Main Form Column !-->

            <!--! [Start] Right Sidebar !-->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                       <h6 class="mb-0">Alur Data RPJM</h6>
                    </div>
                     <div class="card-body">
                         <div class="timeline-box">
                             <div class="timeline-item active">
                                 <div class="icon-holder bg-primary text-white">1</div>
                                 <div class="content">
                                     <h6 class="mb-0">Input RPJM</h6>
                                     <p class="text-muted small mb-0">Operator Desa menginput data</p>
                                     <span class="badge bg-soft-primary text-primary mt-1">Tahap Ini</span>
                                 </div>
                             </div>
                             <div class="timeline-item">
                                 <div class="icon-holder bg-light text-muted">2</div>
                                 <div class="content">
                                     <h6 class="mb-0 text-muted">Review & Finalisasi</h6>
                                     <p class="text-muted small mb-0">Verifikasi data RPJM</p>
                                 </div>
                             </div>
                             <div class="timeline-item">
                                 <div class="icon-holder bg-light text-muted">3</div>
                                 <div class="content">
                                     <h6 class="mb-0 text-muted">Masuk ke RKP Desa</h6>
                                     <p class="text-muted small mb-0">Kegiatan terpilih masuk RKP Tahunan</p>
                                 </div>
                             </div>
                         </div>
                     </div>
                </div>
            </div>
            <!--! [End] Right Sidebar !-->
        </div>
    </div>

    <style>
        .timeline-box .timeline-item {
            position: relative;
            padding-left: 3rem;
            padding-bottom: 2rem;
            border-left: 2px solid #e9ecef;
        }
        .timeline-box .timeline-item:last-child {
            border-left: 0;
            padding-bottom: 0;
        }
        .timeline-box .timeline-item .icon-holder {
            position: absolute;
            left: -19px;
            top: 0;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            z-index: 1;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const existingPriorities = @json($existingPriorities);
            const bidangSelect = document.querySelector('select[name="bidang"]');
            const prioritasInput = document.querySelector('input[name="prioritas"]');
            const submitButton = document.querySelector('button[type="submit"]');

            function checkPriority() {
                const selectedBidang = bidangSelect.value;
                const enteredPriority = parseInt(prioritasInput.value);
                const errorDiv = document.getElementById('prioritas-error');

                // Reset state first
                prioritasInput.classList.remove('is-invalid');
                if(errorDiv) errorDiv.style.display = 'none';

                if (selectedBidang && enteredPriority) {
                    const prioritiesInBidang = existingPriorities[selectedBidang] || [];
                    
                    if (prioritiesInBidang.includes(enteredPriority)) {
                        prioritasInput.classList.add('is-invalid');
                        if(errorDiv) {
                            errorDiv.textContent = 'Prioritas ' + enteredPriority + ' sudah digunakan pada bidang ini.';
                            errorDiv.style.display = 'block';
                        }
                        prioritasInput.value = ''; // Clear duplicate value
                        // prioritasInput.focus(); // Optional: keep focus
                    }
                }
            }

            if (bidangSelect && prioritasInput) {
                prioritasInput.addEventListener('change', checkPriority);
                prioritasInput.addEventListener('blur', checkPriority); // check on leaving field
                prioritasInput.addEventListener('input', function() {
                    // Start clearing error when user starts typing again
                    prioritasInput.classList.remove('is-invalid');
                    const errorDiv = document.getElementById('prioritas-error');
                    if(errorDiv) errorDiv.style.display = 'none';
                });
                bidangSelect.addEventListener('change', function() {
                    prioritasInput.value = ''; // Reset priority when bidang changes
                    prioritasInput.classList.remove('is-invalid');
                    const errorDiv = document.getElementById('prioritas-error');
                    if(errorDiv) errorDiv.style.display = 'none';
                });
            }
        });
    </script>
@endsection
