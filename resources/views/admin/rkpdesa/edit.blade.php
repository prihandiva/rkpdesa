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

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Form Edit RKP Desa</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rkpdesa.update', $rkpDesa->id_kegiatan) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tahun <span class="text-danger">*</span></label>
                                    <select class="form-select @error('tahun') is-invalid @enderror" name="tahun" required>
                                        <option value="">-- Pilih Tahun --</option>
                                        @foreach($tahuns as $t)
                                            <option value="{{ $t->id_tahun }}" {{ old('tahun', $rkpDesa->tahun) == $t->id_tahun ? 'selected' : '' }}>
                                                {{ $t->tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tahun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Kegiatan (Judul RKP) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $rkpDesa->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kegiatan <span class="text-danger">*</span></label>
                                    <select class="form-select @error('jenis_kegiatan') is-invalid @enderror" name="jenis_kegiatan" required>
                                        <option value="Pembangunan" {{ old('jenis_kegiatan', $rkpDesa->jenis_kegiatan) == 'Pembangunan' ? 'selected' : '' }}>Pembangunan</option>
                                        <option value="Pemberdayaan" {{ old('jenis_kegiatan', $rkpDesa->jenis_kegiatan) == 'Pemberdayaan' ? 'selected' : '' }}>Pemberdayaan</option>
                                        <option value="Pembinaan" {{ old('jenis_kegiatan', $rkpDesa->jenis_kegiatan) == 'Pembinaan' ? 'selected' : '' }}>Pembinaan</option>
                                        <option value="Penyelenggaraan" {{ old('jenis_kegiatan', $rkpDesa->jenis_kegiatan) == 'Penyelenggaraan' ? 'selected' : '' }}>Penyelenggaraan</option>
                                        <option value="Penanggulangan" {{ old('jenis_kegiatan', $rkpDesa->jenis_kegiatan) == 'Penanggulangan' ? 'selected' : '' }}>Penanggulangan</option>
                                    </select>
                                    @error('jenis_kegiatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Bidang <span class="text-danger">*</span></label>
                                    <select class="form-select @error('bidang') is-invalid @enderror" name="bidang" required>
                                        <option value="">-- Pilih Bidang --</option>
                                        @foreach($bidangs as $b)
                                            <option value="{{ $b->id_bidang }}" {{ old('bidang', $rkpDesa->bidang) == $b->id_bidang ? 'selected' : '' }}>{{ $b->nama_bidang }}</option>
                                        @endforeach
                                    </select>
                                    @error('bidang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Usulan Terkait (Musdus) <span class="text-muted">(Opsional)</span></label>
                                <select class="form-select" name="id_usulan">
                                    <option value="">-- Pilih Usulan --</option>
                                    @foreach($usulans as $u)
                                        <option value="{{ $u->id_usulan }}" {{ old('id_usulan', $rkpDesa->id_usulan) == $u->id_usulan ? 'selected' : '' }}>{{ $u->jenis_kegiatan }} ({{ $u->dusun->nama ?? 'Dusun ?' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">RPJM Terkait <span class="text-muted">(Opsional)</span></label>
                                <select class="form-select" name="id_rpjm">
                                    <option value="">-- Pilih RPJM --</option>
                                    @foreach($rpjms as $r)
                                        <option value="{{ $r->id_rpjm }}" {{ old('id_rpjm', $rkpDesa->id_rpjm) == $r->id_rpjm ? 'selected' : '' }}>{{ $r->visi ?? 'RPJM' }} ({{ $r->tahun_mulai }}-{{ $r->tahun_selesai }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" class="form-control" name="lokasi" placeholder="Lokasi kegiatan" value="{{ old('lokasi', $rkpDesa->lokasi) }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Volume</label>
                                    <input type="text" class="form-control" name="volume" placeholder="Contoh: 1 Unit" value="{{ old('volume', $rkpDesa->volume) }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Waktu</label>
                                    <input type="text" class="form-control" name="waktu" placeholder="Contoh: 3 Bulan" value="{{ old('waktu', $rkpDesa->waktu) }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jumlah Anggaran (Rp)</label>
                                    <input type="number" class="form-control" name="jumlah" value="{{ old('jumlah', $rkpDesa->jumlah) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sumber Biaya <span class="text-danger">*</span></label>
                                    <select class="form-select @error('sumber_biaya') is-invalid @enderror" name="sumber_biaya" required>
                                        <option value="">-- Pilih Sumber Biaya --</option>
                                        @foreach($sumber_biayas as $sb)
                                            <option value="{{ $sb->id_sumber_biaya }}" {{ old('sumber_biaya', $rkpDesa->sumber_biaya) == $sb->id_sumber_biaya ? 'selected' : '' }}>{{ $sb->nama_sumber_biaya }}</option>
                                        @endforeach
                                    </select>
                                    @error('sumber_biaya')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pola Pelaksanaan <span class="text-danger">*</span></label>
                                    <select class="form-select @error('pola_pelaksanaan') is-invalid @enderror" name="pola_pelaksanaan" required>
                                        <option value="">-- Pilih Pola --</option>
                                        @foreach($pola_pelaksanaans as $pp)
                                            <option value="{{ $pp->id_pola }}" {{ old('pola_pelaksanaan', $rkpDesa->pola_pelaksanaan) == $pp->id_pola ? 'selected' : '' }}>{{ $pp->nama_pola }}</option>
                                        @endforeach
                                    </select>
                                    @error('pola_pelaksanaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status" required>
                                        <option value="draft" {{ old('status', $rkpDesa->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="diajukan" {{ old('status', $rkpDesa->status) == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                        <option value="disetujui" {{ old('status', $rkpDesa->status) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="ditolak" {{ old('status', $rkpDesa->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Berita Acara Musrenbang (PDF) <span class="text-muted">(Opsional)</span></label>
                                @if($rkpDesa->file_berita_acara_musrenbang)
                                    <div class="mb-2">
                                        <a href="{{ asset($rkpDesa->file_berita_acara_musrenbang) }}" target="_blank" class="badge bg-primary text-decoration-none">
                                            <i class="feather-file-text me-1"></i>Lihat File Saat Ini
                                        </a>
                                    </div>
                                @endif
                                <input type="file" class="form-control" name="file_berita_acara_musrenbang" accept=".pdf,.doc,.docx">
                                <div class="form-text">Biarkan kosong jika tidak ingin mengubah file.</div>
                            </div>

                            <div class="d-flex gap-2 justify-content-between mt-4">
                                <a href="{{ route('rkpdesa.index') }}" class="btn btn-secondary">
                                    <i class="feather-x me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather-save me-1"></i>Simpan Perubahan
                                </button>
                            </div>

                            <!--! [Start] Verification Section !-->
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm bg-light">
                                        <div class="card-header bg-warning text-dark border-bottom">
                                            <h6 class="mb-0"><i class="feather-check-square me-2"></i>Verifikasi (Tim Verifikasi)</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Status Verifikasi</label>
                                                    <select class="form-select @error('status_verifikasi') is-invalid @enderror" name="status_verifikasi">
                                                        <option value="Menunggu" {{ old('status_verifikasi', $rkpDesa->status_verifikasi) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                        <option value="Diterima" {{ old('status_verifikasi', $rkpDesa->status_verifikasi) == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                                        <option value="Ditolak" {{ old('status_verifikasi', $rkpDesa->status_verifikasi) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                        <option value="Revisi" {{ old('status_verifikasi', $rkpDesa->status_verifikasi) == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                                                    </select>
                                                    @error('status_verifikasi')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Catatan Verifikasi</label>
                                                    <textarea class="form-control" name="catatan_verifikasi" rows="3" placeholder="Catatan untuk operator desa...">{{ old('catatan_verifikasi', $rkpDesa->catatan_verifikasi) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--! [End] Verification Section !-->

                            <!--! [Start] Finalization Section !-->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm bg-light">
                                        <div class="card-header bg-success text-white border-bottom">
                                            <h6 class="mb-0"><i class="feather-check-circle me-2"></i>Finalisasi / Persetujuan (BPD & Kepala Desa)</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Status Persetujuan</label>
                                                <select class="form-select @error('status_approval') is-invalid @enderror" name="status_approval">
                                                    <option value="" {{ old('status_approval', $rkpDesa->status_approval) == '' ? 'selected' : '' }}>-- Pilih Status Approval --</option>
                                                    <option value="Menunggu" {{ old('status_approval', $rkpDesa->status_approval) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                    <option value="Disetujui BPD" {{ old('status_approval', $rkpDesa->status_approval) == 'Disetujui BPD' ? 'selected' : '' }}>Disetujui BPD</option>
                                                    <option value="Disetujui Kepala Desa" {{ old('status_approval', $rkpDesa->status_approval) == 'Disetujui Kepala Desa' ? 'selected' : '' }}>Disetujui Kepala Desa (Final)</option>
                                                    <option value="Ditolak" {{ old('status_approval', $rkpDesa->status_approval) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                                @error('status_approval')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--! [End] Finalization Section !-->

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
