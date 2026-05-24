@extends('admin.layout')

@section('title', 'Tambah RKP Desa')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Tambah RKP Desa</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rkpdesa.index') }}">RKP Desa</a></li>
                    <li class="breadcrumb-item">Tambah</li>
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
                        <a href="{{ route('rkpdesa.index') }}" class="btn btn-md btn-secondary">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali</span>
                        </a>
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
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-primary border-0 shadow-sm d-flex gap-3 align-items-center mb-0" role="alert">
                    <div class="bg-white text-primary p-2 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                        <i class="feather-info fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Panduan Pengisian RKP Desa</h6>
                        <div class="d-flex flex-wrap gap-4 small text-dark">
                            <span><strong>Tahun:</strong> Pilih tahun untuk RKP.</span>
                            <span><strong>Judul RKP:</strong> Isi dengan judul kegiatan.</span>
                            <span><strong>RPJM:</strong> Pilih RPJM acuan (opsional).</span>
                            <span><strong>Deskripsi:</strong> Jelaskan secara ringkas.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <!--! [Start] Card Header !-->
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Formulir RKP Desa</h6>
                    </div>
                    <!--! [End] Card Header !-->

                    <!--! [Start] Card Body !-->
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('rkpdesa.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tahun <span class="text-danger">*</span></label>
                                    <select class="form-select" name="tahun" required>
                                        <option value="">-- Pilih Tahun --</option>
                                        @foreach($tahuns as $t)
                                            <option value="{{ $t->tahun }}">{{ $t->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Kegiatan / Jenis Kegiatan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="jenis_kegiatan" required placeholder="Contoh: Pembangunan Posyandu" value="{{ old('jenis_kegiatan') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis <span class="text-danger">*</span></label>
                                    <select class="form-select" name="jenis" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Fisik" {{ old('jenis') == 'Fisik' ? 'selected' : '' }}>Fisik</option>
                                        <option value="Non Fisik" {{ old('jenis') == 'Non Fisik' ? 'selected' : '' }}>Non Fisik</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Bidang <span class="text-danger">*</span></label>
                                    <select class="form-select" name="bidang" required>
                                        <option value="">-- Pilih Bidang --</option>
                                        @foreach($bidangs as $b)
                                            <option value="{{ $b->id_bidang }}">{{ $b->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Usulan Terkait (Musdus) <span class="text-muted">(Opsional)</span></label>
                                <select class="form-select" name="id_usulan">
                                    <option value="">-- Pilih Usulan --</option>
                                    @foreach($usulans as $u)
                                        <option value="{{ $u->id_usulan }}">{{ $u->jenis_kegiatan }} ({{ $u->dusun->nama ?? 'Dusun ?' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">RPJM Terkait <span class="text-muted">(Opsional)</span></label>
                                <select class="form-select" name="id_rpjm">
                                    <option value="">-- Pilih RPJM --</option>
                                    @foreach($rpjms as $r)
                                        <option value="{{ $r->id_rpjm }}">{{ $r->jenis_kegiatan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" class="form-control" name="lokasi" placeholder="Lokasi kegiatan">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Volume</label>
                                    <input type="text" class="form-control" name="volume" placeholder="Contoh: 1 Unit">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Waktu</label>
                                    <input type="text" class="form-control" name="waktu" placeholder="Contoh: 3 Bulan">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Sasaran/Penerima</label>
                                    <input type="text" class="form-control" name="penerima" placeholder="Contoh: Warga Dusun 1">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Data Existing (Kondisi Saat Ini)</label>
                                    <textarea class="form-control" name="data_existing" rows="3" placeholder="Deskripsikan kondisi saat ini..."></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Target Capaian</label>
                                    <textarea class="form-control" name="target_capaian" rows="3" placeholder="Deskripsikan target yang ingin dicapai..."></textarea>
                                </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jumlah Anggaran (Rp)</label>
                                    <input type="number" class="form-control" name="jumlah">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sumber Dana <span class="text-danger">*</span></label>
                                    <div class="dropdown">
                                        <button class="btn btn-light border dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center bg-white" type="button" id="dropdownSumberDana" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" style="padding: 0.5rem 0.75rem;">
                                            <span class="text-muted" id="dropdownSumberDanaText" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">-- Pilih Sumber Dana --</span>
                                        </button>
                                        <ul class="dropdown-menu w-100 px-3 py-2 shadow-sm" aria-labelledby="dropdownSumberDana" style="max-height: 250px; overflow-y: auto;">
                                            @foreach($sumber_biayas as $sb)
                                            <li class="mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="sumber_biaya[]" value="{{ $sb->id_biaya }}" id="sb_create_{{ $sb->id_biaya }}" {{ (is_array(old('sumber_biaya')) && in_array($sb->id_biaya, old('sumber_biaya'))) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="sb_create_{{ $sb->id_biaya }}">
                                                        {{ $sb->nama }}
                                                    </label>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @error('sumber_biaya') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Pola Pelaksanaan <span class="text-danger">*</span></label>
                                    <select class="form-select" name="pola_pelaksanaan" required>
                                        <option value="">-- Pilih Pola --</option>
                                        @foreach($pola_pelaksanaans as $pp)
                                            <option value="{{ $pp->id_pelaksanaan }}">{{ $pp->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status" required>
                                        <option value="Proses">Proses</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Terverifikasi">Terverifikasi</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Prioritas</label>
                                    <input type="number" class="form-control" name="prioritas" min="1" placeholder="Masukkan Prioritas">
                                    <div class="form-text text-muted">Angka prioritas harus unik dalam satu bidang.</div>
                                    <small class="text-danger" id="prioritas-error" style="display:none;"></small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan Verifikasi <span class="text-muted">(Opsional)</span></label>
                                <textarea class="form-control" name="catatan_verifikasi" rows="3" placeholder="Tambahkan catatan verifikasi jika ada..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Berita Acara Musrenbang (PDF) <span class="text-muted">(Opsional)</span></label>
                                <input type="file" class="form-control" name="file_berita_acara_musrenbang" accept=".pdf,.doc,.docx">
                            </div>

                            <!--! [Start] Form Actions !-->
                            <div class="d-flex gap-2 justify-content-between mt-4">
                                <a href="{{ route('rkpdesa.index') }}" class="btn btn-secondary">
                                    <i class="feather-x me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather-save me-1"></i>Simpan
                                </button>
                            </div>
                            <!--! [End] Form Actions !-->
                        </form>
                    </div>
                    <!--! [End] Card Body !-->
                </div>
            </div>
        </div>
        <!--! [End] Main Content !-->
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const existingPriorities = @json($existingPriorities);
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
                prioritasInput.addEventListener('blur', checkPriority); // check on leaving field
                prioritasInput.addEventListener('input', function() {
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

            // Checkbox Dropdown Text Update
            const sumberDanaCheckboxes = document.querySelectorAll('input[name="sumber_biaya[]"]');
            const dropdownText = document.getElementById('dropdownSumberDanaText');
            
            function updateDropdownText() {
                if(!dropdownText) return;
                const selected = Array.from(sumberDanaCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.nextElementSibling.textContent.trim());
                
                if (selected.length > 0) {
                    dropdownText.textContent = selected.join(', ');
                    dropdownText.classList.remove('text-muted');
                } else {
                    dropdownText.textContent = '-- Pilih Sumber Dana --';
                    dropdownText.classList.add('text-muted');
                }
            }

            sumberDanaCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateDropdownText);
            });
            
            // Initialize on load
            if(sumberDanaCheckboxes.length > 0) {
                updateDropdownText();
            }
        });
    </script>
@endsection
