@extends('admin.layout')

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
                            <input type="hidden" name="nama" value="{{ $rkpDesa->nama }}">
                            <input type="hidden" name="jenis_kegiatan" value="{{ $rkpDesa->jenis_kegiatan }}">

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

                                <!-- Sumber Biaya (Dropdown) -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sumber Biaya <span class="text-danger">*</span></label>
                                    <select name="sumber_biaya" class="form-select @error('sumber_biaya') is-invalid @enderror" required>
                                        <option value="">-- Pilih Sumber Biaya --</option>
                                        @foreach($sumber_biayas as $sb)
                                            <option value="{{ $sb->id_sumber_biaya }}" {{ old('sumber_biaya', $rkpDesa->sumber_biaya) == $sb->id_sumber_biaya ? 'selected' : '' }}>
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
                                            <option value="{{ $pp->id_pola }}" {{ old('pola_pelaksanaan', $rkpDesa->pola_pelaksanaan) == $pp->id_pola ? 'selected' : '' }}>
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
                                    <label class="form-label">Prioritas (1-5)</label>
                                    <input type="number" name="prioritas" class="form-control" value="{{ old('prioritas', $rkpDesa->prioritas) }}" min="1" max="5" placeholder="1-5">
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
