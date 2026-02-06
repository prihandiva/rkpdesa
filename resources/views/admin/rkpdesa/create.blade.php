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

        <!--! [Start] Main Form Card !-->
        <div class="row">
            <div class="col-lg-8">
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
                                            <option value="{{ $t->id_tahun }}">{{ $t->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Kegiatan / Judul RKP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama" required placeholder="Contoh: Pembangunan Posyandu">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kegiatan <span class="text-danger">*</span></label>
                                    <select class="form-select" name="jenis_kegiatan" required>
                                        <option value="Pembangunan">Pembangunan</option>
                                        <option value="Pemberdayaan">Pemberdayaan</option>
                                        <option value="Pembinaan">Pembinaan</option>
                                        <option value="Penyelenggaraan">Penyelenggaraan</option>
                                        <option value="Penanggulangan">Penanggulangan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Bidang <span class="text-danger">*</span></label>
                                    <select class="form-select" name="bidang" required>
                                        <option value="">-- Pilih Bidang --</option>
                                        @foreach($bidangs as $b)
                                            <option value="{{ $b->id_bidang }}">{{ $b->nama_bidang }}</option>
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
                                        <option value="{{ $r->id_rpjm }}">{{ $r->visi ?? 'RPJM' }} ({{ $r->tahun_mulai }}-{{ $r->tahun_selesai }})</option>
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
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jumlah Anggaran (Rp)</label>
                                    <input type="number" class="form-control" name="jumlah">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sumber Biaya <span class="text-danger">*</span></label>
                                    <select class="form-select" name="sumber_biaya" required>
                                        <option value="">-- Pilih Sumber Biaya --</option>
                                        @foreach($sumber_biayas as $sb)
                                            <option value="{{ $sb->id_sumber_biaya }}">{{ $sb->nama_sumber_biaya }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pola Pelaksanaan <span class="text-danger">*</span></label>
                                    <select class="form-select" name="pola_pelaksanaan" required>
                                        <option value="">-- Pilih Pola --</option>
                                        @foreach($pola_pelaksanaans as $pp)
                                            <option value="{{ $pp->id_pola }}">{{ $pp->nama_pola }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status" required>
                                        <option value="draft">Draft</option>
                                        <option value="diajukan">Diajukan</option>
                                        <option value="disetujui">Disetujui</option>
                                    </select>
                                </div>
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

            <div class="col-lg-4">
                <!--! [Start] Info Card !-->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-light border-bottom">
                        <h6 class="mb-0">Panduan Pengisian</h6>
                    </div>
                    <div class="card-body p-3">
                        <p class="text-muted small mb-2">
                            <strong>Tahun:</strong> Pilih tahun untuk RKP yang akan dibuat.
                        </p>
                        <p class="text-muted small mb-2">
                            <strong>Judul RKP:</strong> Isi dengan judul rencana kerja pembangunan desa.
                        </p>
                        <p class="text-muted small mb-2">
                            <strong>RPJM Terkait:</strong> Pilih RPJM yang menjadi acuan untuk RKP ini (opsional).
                        </p>
                        <p class="text-muted small mb-0">
                            <strong>Deskripsi:</strong> Jelaskan secara ringkas tentang RKP yang direncanakan.
                        </p>
                    </div>
                </div>
                <!--! [End] Info Card !-->
            </div>
        </div>
        <!--! [End] Main Form Card !-->
    </div>
@endsection
