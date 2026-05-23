@extends('admin.layout')

@section('title', 'Edit Usulan')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Edit Usulan</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('usulan.index') }}">Usulan</a></li>
                    <li class="breadcrumb-item">Edit</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="{{ route('usulan.index') }}" class="btn btn-md btn-secondary">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ page-header ] end -->

        <div class="row">
            <!--! [Start] Main Form Column !-->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Form Edit Usulan</h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('usulan.update', $usulan->id_usulan) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Hidden: id_dusun & tahun tidak bisa diubah --}}
                            <input type="hidden" name="id_dusun" value="{{ $usulan->id_dusun }}">
                            <input type="hidden" name="tahun" value="{{ $usulan->tahun }}">

                            {{-- Row 1: Dusun (readonly) & Tahun (readonly) --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Dusun</label>
                                    <input type="text" class="form-control bg-light"
                                        value="{{ $usulan->dusun->nama ?? '-' }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tahun Anggaran</label>
                                    <input type="text" class="form-control bg-light"
                                        value="{{ $usulan->tahun }}" readonly>
                                </div>
                            </div>

                            {{-- Row 2: RW & RT (dynamic dropdown) --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">RW <span class="text-danger">*</span></label>
                                    <select class="form-select @error('id_rw') is-invalid @enderror"
                                        name="id_rw" id="rw_id" required>
                                        <option value="">-- Pilih RW --</option>
                                        @foreach($rws as $rw)
                                            <option value="{{ $rw->id_rw }}"
                                                {{ old('id_rw', $usulan->id_rw) == $rw->id_rw ? 'selected' : '' }}>
                                                {{ $rw->nama_rw ?? 'RW ' . $rw->id_rw }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_rw') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">RT <span class="text-danger">*</span></label>
                                    <select class="form-select @error('id_rt') is-invalid @enderror"
                                        name="id_rt" id="rt_id" required>
                                        <option value="">-- Pilih RT --</option>
                                        @foreach($rts as $rt)
                                            <option value="{{ $rt->id_rt }}"
                                                {{ old('id_rt', $usulan->id_rt) == $rt->id_rt ? 'selected' : '' }}>
                                                {{ $rt->nama_rt ?? 'RT ' . $rt->id_rt }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_rt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Row 3: Jenis & Jenis Kegiatan --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis <span class="text-danger">*</span></label>
                                    <select class="form-select @error('jenis') is-invalid @enderror"
                                        name="jenis" id="jenis" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Fisik"
                                            {{ old('jenis', $usulan->jenis) == 'Fisik' ? 'selected' : '' }}>Fisik</option>
                                        <option value="Non Fisik"
                                            {{ old('jenis', $usulan->jenis) == 'Non Fisik' ? 'selected' : '' }}>Non Fisik</option>
                                    </select>
                                    @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kegiatan / Nama Usulan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('jenis_kegiatan') is-invalid @enderror"
                                        name="jenis_kegiatan" id="jenis_kegiatan" required
                                        placeholder="Contoh: Pembangunan Jalan Paving..."
                                        value="{{ old('jenis_kegiatan', $usulan->jenis_kegiatan) }}">
                                    @error('jenis_kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                    name="deskripsi" id="deskripsi" rows="3" required
                                    placeholder="Jelaskan detail usulan...">{{ old('deskripsi', $usulan->deskripsi) }}</textarea>
                                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Prioritas --}}
                            <div class="mb-3">
                                <label class="form-label">Prioritas <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('prioritas') is-invalid @enderror"
                                    name="prioritas" id="prioritas" required min="1"
                                    placeholder="Masukkan angka prioritas (1, 2, 3...)"
                                    value="{{ old('prioritas', $usulan->prioritas) }}">
                                <div class="form-text text-muted">Angka prioritas harus unik dalam satu dusun.</div>
                                @error('prioritas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Berita Acara --}}
                            <div class="mb-4">
                                <label class="form-label">Berita Acara Musdus <span class="text-muted">(Opsional)</span></label>
                                @if($usulan->file_berita_acara)
                                    <div class="mb-2">
                                        <a href="{{ asset($usulan->file_berita_acara) }}" target="_blank"
                                            class="badge bg-primary text-decoration-none">
                                            <i class="feather-file-text me-1"></i>Lihat File Saat Ini
                                        </a>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('file_berita_acara') is-invalid @enderror"
                                    name="file_berita_acara" accept=".pdf,.doc,.docx,.jpg,.png">
                                <div class="form-text">Biarkan kosong jika tidak ingin mengubah file. Format: PDF, DOC, JPG, PNG (maks 5MB).</div>
                                @error('file_berita_acara') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('usulan.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--! [End] Main Form Column !-->

            <!--! [Start] Right Sidebar Info !-->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Info Usulan</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>ID Usulan:</strong> #{{ $usulan->id_usulan }}</p>
                        <p class="mb-2"><strong>Dusun:</strong> {{ $usulan->dusun->nama ?? '-' }}</p>
                        <p class="mb-2"><strong>Tahun:</strong> {{ $usulan->tahun }}</p>
                        <p class="mb-2">
                            <strong>Status:</strong>
                            @php
                                $statusClass = match($usulan->status) {
                                    'Disetujui' => 'bg-success',
                                    'Ditolak'   => 'bg-danger',
                                    'Pending'   => 'bg-warning text-dark',
                                    default     => 'bg-primary',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $usulan->status }}</span>
                        </p>
                        <p class="mb-0"><strong>Dibuat:</strong> {{ $usulan->created_at?->format('d M Y') ?? '-' }}</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Catatan Penting</h6>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0 ps-3 small text-muted">
                            <li>Dusun dan Tahun Anggaran tidak dapat diubah.</li>
                            <li>Pastikan nomor prioritas unik dalam satu dusun.</li>
                            <li>RW dan RT harus dipilih sesuai lokasi kegiatan.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--! [End] Right Sidebar Info !-->
        </div>
    </div>

    {{-- Script Dynamic Dropdown RW/RT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const allRW = @json($rws);
            const allRT = @json($rts);

            const dusunId = {{ $usulan->id_dusun }};

            {{--
                Utamakan nilai old() jika ada (saat validasi gagal & redirect back).
                Fallback ke nilai database ($usulan) jika old() kosong.
            --}}
            const currentRW = {{ old('id_rw') ? old('id_rw') : ($usulan->id_rw ?? 'null') }};
            const currentRT = {{ old('id_rt') ? old('id_rt') : ($usulan->id_rt ?? 'null') }};

            const rwSelect = document.getElementById('rw_id');
            const rtSelect = document.getElementById('rt_id');

            function populateRW(dusunId, selectedRW) {
                rwSelect.innerHTML = '<option value="">-- Pilih RW --</option>';
                rtSelect.innerHTML = '<option value="">-- Pilih RT --</option>';

                const filteredRW = allRW.filter(rw => rw.id_dusun == dusunId);
                filteredRW.forEach(rw => {
                    const option = document.createElement('option');
                    option.value = rw.id_rw;
                    option.textContent = rw.nama_rw ? rw.nama_rw : 'RW ' + rw.id_rw;
                    if (rw.id_rw == selectedRW) option.selected = true;
                    rwSelect.appendChild(option);
                });
            }

            function populateRT(rwId, selectedRT) {
                rtSelect.innerHTML = '<option value="">-- Pilih RT --</option>';

                if (!rwId) return;

                const filteredRT = allRT.filter(rt => rt.id_rw == rwId);
                filteredRT.forEach(rt => {
                    const option = document.createElement('option');
                    option.value = rt.id_rt;
                    option.textContent = rt.nama_rt ? rt.nama_rt : 'RT ' + rt.id_rt;
                    if (rt.id_rt == selectedRT) option.selected = true;
                    rtSelect.appendChild(option);
                });
            }

            // Inisialisasi: populate RW berdasarkan dusun, lalu RT berdasarkan RW terpilih
            populateRW(dusunId, currentRW);
            if (currentRW) {
                populateRT(currentRW, currentRT);
            }

            // Jika RW diganti user, reload RT tanpa pre-select
            rwSelect.addEventListener('change', function () {
                populateRT(this.value, null);
            });
        });
    </script>
@endsection
