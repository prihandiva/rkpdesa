@extends('admin.layout')

@section('title', 'Edit RPJM')

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const existingPriorities = @json($existingPriorities);
            const currentBidang = "{{ $rpjm->bidang }}";
            const currentPriority = {{ $rpjm->prioritas ?? 'null' }};
            
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

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Edit Data RPJM</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rpjm.index') }}">RPJM</a></li>
                    <li class="breadcrumb-item">Edit</li>
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
                        <h6 class="mb-0">Form Edit RPJM</h6>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('rpjm.update', $rpjm->id_rpjm) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Bidang <span class="text-danger">*</span></label>
                                    <select class="form-select" name="bidang" required>
                                        <option value="">-- Pilih Bidang --</option>
                                        @foreach($bidangs as $bidang)
                                            <option value="{{ $bidang->id_bidang }}" {{ (old('bidang') ?? $rpjm->bidang) == $bidang->id_bidang ? 'selected' : '' }}>{{ $bidang->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sub Bidang</label>
                                    <input type="text" class="form-control" name="subbidang" value="{{ old('subbidang') ?? $rpjm->subbidang }}" placeholder="Contoh: Pembangunan Jalan">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Kegiatan / Nama Kegiatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jenis_kegiatan" required placeholder="Nama kegiatan..." value="{{ old('jenis_kegiatan') ?? $rpjm->jenis_kegiatan }}">
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" class="form-control" name="lokasi" value="{{ old('lokasi') ?? $rpjm->lokasi }}" placeholder="Lokasi kegiatan...">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Volume</label>
                                    <input type="text" class="form-control" name="volume" value="{{ old('volume') ?? $rpjm->volume }}" placeholder="Contoh: 100 m">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Sasaran / Penerima Manfaat</label>
                                    <input type="text" class="form-control" name="sasaran" value="{{ old('sasaran') ?? $rpjm->sasaran }}" placeholder="Contoh: Warga Dusun 1">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Waktu Pelaksanaan</label>
                                    <input type="text" class="form-control" name="waktu" value="{{ old('waktu') ?? $rpjm->waktu }}" placeholder="Contoh: 3 Bulan">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Perkiraan Biaya (Rp)</label>
                                    <input type="number" class="form-control" name="jumlah" value="{{ old('jumlah') ?? $rpjm->jumlah }}" placeholder="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Sumber Biaya</label>
                                    <select class="form-select" name="sumber_biaya">
                                        <option value="">-- Pilih Sumber --</option>
                                        @foreach($sumber_biayas as $sb)
                                            <option value="{{ $sb->id_biaya }}" {{ (old('sumber_biaya') ?? $rpjm->sumber_biaya) == $sb->id_biaya ? 'selected' : '' }}>{{ $sb->nama }}</option>
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
                                            <option value="{{ $pp->id_pelaksanaan }}" {{ (old('pola_pelaksanaan') ?? $rpjm->pola_pelaksanaan) == $pp->id_pelaksanaan ? 'selected' : '' }}>{{ $pp->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prioritas <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="prioritas" value="{{ old('prioritas', $rpjm->prioritas) }}" min="1" required placeholder="Masukkan angka prioritas (1, 2, 3...)">
                                    <div class="form-text text-muted">Angka prioritas harus unik dalam satu bidang.</div>
                                    <small class="text-danger" id="prioritas-error" style="display:none;"></small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--! [End] Form Card !-->

            </div>
            <!--! [End] Main Form Column !-->

            <!--! [Start] Right Sidebar !-->
            <div class="col-lg-4">
                 <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                         <h6 class="mb-0">Informasi</h6>
                    </div>
                     <div class="card-body">
                         <p class="mb-2"><strong>Status:</strong> <span class="badge bg-secondary">{{ $rpjm->status }}</span></p>
                         <p class="mb-0 text-muted small">Update terakhir: {{ $rpjm->updated_at->diffForHumans() }}</p>
                     </div>
                </div>
            </div>
            <!--! [End] Right Sidebar !-->
        </div>
    </div>
@endsection
