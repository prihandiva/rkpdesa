@extends('admin.layout')

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const existingPriorities = @json($existingPriorities);
            const currentBidang = "{{ $rkpDesa->bidang }}";
            const currentPriority = {{ $rkpDesa->prioritas ?? 'null' }};
            
            const bidangSelect = document.querySelector('select[name="bidang"]');
            const prioritasInput = document.querySelector('input[name="prioritas"]');

            function checkPriority() {
                const selectedBidang = bidangSelect.value;
                const enteredPriority = parseInt(prioritasInput.value);

                const errorDiv = document.getElementById('prioritas-error');

                // Reset state first
                prioritasInput.classList.remove('is-invalid');
                if(errorDiv) errorDiv.style.display = 'none';

                if (selectedBidang && enteredPriority) {
                    // Check if user is keeping the original combination
                    if (selectedBidang == currentBidang && enteredPriority == currentPriority) {
                        return; // Valid (no change or same value)
                    }

                    const prioritiesInBidang = existingPriorities[selectedBidang] || [];
                    
                    if (prioritiesInBidang.includes(enteredPriority)) {
                        prioritasInput.classList.add('is-invalid');
                        if(errorDiv) {
                            errorDiv.textContent = 'Prioritas ' + enteredPriority + ' sudah digunakan pada bidang ini.';
                            errorDiv.style.display = 'block';
                        }
                        prioritasInput.value = '';
                        // prioritasInput.focus();
                    }
                }
            }

            if (bidangSelect && prioritasInput) {
                prioritasInput.addEventListener('change', checkPriority);
                prioritasInput.addEventListener('blur', checkPriority);
                prioritasInput.addEventListener('input', function() {
                    prioritasInput.classList.remove('is-invalid');
                    const errorDiv = document.getElementById('prioritas-error');
                    if(errorDiv) errorDiv.style.display = 'none';
                });
            }
        });
    </script>
@endpush

@section('title', 'Edit RKP Desa')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Edit RKP Desa</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rkpdesa.index') }}">RKP Desa</a></li>
                    <li class="breadcrumb-item">Edit</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="{{ route('rkpdesa.show', $rkpDesa->id_kegiatan) }}" class="btn btn-md btn-secondary">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali ke Detail</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ page-header ] end -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Lengkapi Data RKP Desa</h6>
                    </div>
                    <div class="card-body">
                        
                        <!-- Alert for Penyusun -->
                        @if(session('user_role') == 'tim_penyusun')
                            @if($rkpDesa->status != 'Terverifikasi' && $rkpDesa->status != 'Disetujui')
                                <div class="alert alert-warning">
                                    <i class="feather-alert-triangle me-2"></i>
                                    Status kegiatan ini adalah <strong>{{ $rkpDesa->status }}</strong>. Anda mngkin tidak dapat menyimpan perubahan hingga status Terverifikasi.
                                </div>
                            @endif
                        @endif

                        <form action="{{ route('rkpdesa.update', $rkpDesa->id_kegiatan) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Hidden Fields for Fixed/Existing Data -->
                            <input type="hidden" name="status" value="{{ $rkpDesa->status }}">

                            <div class="row">
                                <!-- Dusun (Readonly) -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Dusun</label>
                                    <input type="text" class="form-control bg-light" value="{{ $rkpDesa->usulan->dusun->nama ?? '-' }}" disabled>
                                    <small class="text-muted">Diambil dari data usulan</small>
                                </div>
                                
                                <!-- Tahun (Readonly) -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tahun</label>
                                    <input type="text" name="tahun" class="form-control bg-light" value="{{ $rkpDesa->tahun }}" readonly>
                                </div>

                                <!-- Jenis Kegiatan / Nama (Editable) -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Nama Kegiatan / Jenis Kegiatan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('jenis_kegiatan') is-invalid @enderror" name="jenis_kegiatan" required value="{{ old('jenis_kegiatan', $rkpDesa->jenis_kegiatan) }}">
                                    @error('jenis_kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Jenis (Dropdown) -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis <span class="text-danger">*</span></label>
                                    <select class="form-select" name="jenis" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Fisik" {{ (old('jenis') ?? $rkpDesa->jenis) == 'Fisik' ? 'selected' : '' }}>Fisik</option>
                                        <option value="Non Fisik" {{ (old('jenis') ?? $rkpDesa->jenis) == 'Non Fisik' ? 'selected' : '' }}>Non Fisik</option>
                                    </select>
                                </div>

                                <!-- Bidang (Dropdown) -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Bidang <span class="text-danger">*</span></label>
                                    <select name="bidang" class="form-select @error('bidang') is-invalid @enderror" required>
                                        <option value="">-- Pilih Bidang --</option>
                                        @foreach($bidangs as $bidang)
                                            <option value="{{ $bidang->id_bidang }}" {{ old('bidang', $rkpDesa->bidang) == $bidang->id_bidang ? 'selected' : '' }}>
                                                {{ $bidang->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bidang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!--Sumber Dana (Dropdown) -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sumber Dana <span class="text-danger">*</span></label>
                                    <select name="sumber_biaya" class="form-select @error('sumber_biaya') is-invalid @enderror" required>
                                        <option value="">-- Pilih Sumber Dana --</option>
                                        @foreach($sumber_biayas as $sb)
                                            <option value="{{ $sb->id_biaya }}" {{ old('sumber_biaya', $rkpDesa->sumber_biaya) == $sb->id_biaya ? 'selected' : '' }}>
                                                {{ $sb->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sumber_biaya') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Pola Pelaksanaan (Dropdown) -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pola Pelaksanaan <span class="text-danger">*</span></label>
                                    <select name="pola_pelaksanaan" class="form-select @error('pola_pelaksanaan') is-invalid @enderror" required>
                                        <option value="">-- Pilih Pola --</option>
                                        @foreach($pola_pelaksanaans as $pp)
                                            <option value="{{ $pp->id_pelaksanaan }}" {{ old('pola_pelaksanaan', $rkpDesa->pola_pelaksanaan) == $pp->id_pelaksanaan ? 'selected' : '' }}>
                                                {{ $pp->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pola_pelaksanaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Separator -->
                                <div class="col-12 my-2"><hr></div>

                                <!-- Data Input Fields -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Data Existing</label>
                                    <input type="text" name="data_existing" class="form-control" value="{{ old('data_existing', $rkpDesa->data_existing) }}" placeholder="Isi data existing...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Target Capaian</label>
                                    <input type="text" name="target_capaian" class="form-control" value="{{ old('target_capaian', $rkpDesa->target_capaian) }}" placeholder="Isi target...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $rkpDesa->lokasi) }}" placeholder="Lokasi kegiatan">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Volume</label>
                                    <input type="text" name="volume" class="form-control" value="{{ old('volume', $rkpDesa->volume) }}" placeholder="Contoh: 1 Unit">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Penerima Manfaat</label>
                                    <input type="text" name="penerima" class="form-control" value="{{ old('penerima', $rkpDesa->penerima) }}" placeholder="Jumlah/Kelompok Penerima">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Waktu Pelaksanaan</label>
                                    <input type="text" name="waktu" class="form-control" value="{{ old('waktu', $rkpDesa->waktu) }}" placeholder="Contoh: 3 Bulan">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Anggaran (Rp)</label>
                                    <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $rkpDesa->jumlah) }}" placeholder="0">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prioritas</label>
                                    <input type="number" name="prioritas" class="form-control" value="{{ old('prioritas', $rkpDesa->prioritas) }}" min="1" placeholder="Masukkan Prioritas">
                                    <div class="form-text text-muted">Angka prioritas harus unik dalam satu bidang.</div>
                                    <small class="text-danger" id="prioritas-error" style="display:none;"></small>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">File Berita Acara (Update jika perlu)</label>
                                    <input type="file" class="form-control" name="file_berita_acara_musrenbang">
                                    @if($rkpDesa->file_berita_acara_musrenbang)
                                        <small class="text-muted">File saat ini: <a href="{{ asset($rkpDesa->file_berita_acara_musrenbang) }}" target="_blank">Lihat</a></small>
                                    @endif
                                </div>

                            </div>

                            <div class="d-flex gap-2 justify-content-end mt-4">
                                <a href="{{ route('rkpdesa.show', $rkpDesa->id_kegiatan) }}" class="btn btn-secondary">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather-save me-1"></i>Simpan Perubahan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
