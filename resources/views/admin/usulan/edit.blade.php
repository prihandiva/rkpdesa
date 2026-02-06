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
                    <div class="d-flex d-md-none">
                        <a href="javascript:void(0)" class="page-header-right-close-toggle">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="{{ route('usulan.index') }}" class="btn btn-md btn-secondary">
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
                        <h6 class="mb-0">Form Edit Usulan</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('usulan.update', $usulan->id_usulan) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="jenis_kegiatan" class="form-label">Jenis Kegiatan (Nama Usulan)</label>
                                <input type="text" class="form-control @error('jenis_kegiatan') is-invalid @enderror"
                                    id="jenis_kegiatan" name="jenis_kegiatan" value="{{ old('jenis_kegiatan', $usulan->jenis_kegiatan) }}" required>
                                @error('jenis_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="id_dusun" class="form-label">Dusun</label>
                                <select class="form-select @error('id_dusun') is-invalid @enderror" id="id_dusun" name="id_dusun" required>
                                    <option value="">Pilih Dusun</option>
                                    @foreach(\App\Models\Dusun::all() as $dusun)
                                        <option value="{{ $dusun->id_dusun }}" {{ old('id_dusun', $usulan->id_dusun) == $dusun->id_dusun ? 'selected' : '' }}>
                                            {{ $dusun->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_dusun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="prioritas" class="form-label">Prioritas (1-5)</label>
                                <select class="form-select @error('prioritas') is-invalid @enderror" id="prioritas" name="prioritas" required>
                                    <option value="1" {{ old('prioritas', $usulan->prioritas) == 1 ? 'selected' : '' }}>1 (Sangat Rendah)</option>
                                    <option value="2" {{ old('prioritas', $usulan->prioritas) == 2 ? 'selected' : '' }}>2 (Rendah)</option>
                                    <option value="3" {{ old('prioritas', $usulan->prioritas) == 3 ? 'selected' : '' }}>3 (Sedang)</option>
                                    <option value="4" {{ old('prioritas', $usulan->prioritas) == 4 ? 'selected' : '' }}>4 (Tinggi)</option>
                                    <option value="5" {{ old('prioritas', $usulan->prioritas) == 5 ? 'selected' : '' }}>5 (Sangat Tinggi)</option>
                                </select>
                                @error('prioritas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                             <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="Menunggu" {{ old('status', $usulan->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Setuju" {{ old('status', $usulan->status) == 'Setuju' ? 'selected' : '' }}>Setuju</option>
                                    <option value="Tolak" {{ old('status', $usulan->status) == 'Tolak' ? 'selected' : '' }}>Tolak</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun', $usulan->tahun) }}" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Berita Acara Musdus (PDF/Image) <span class="text-muted">(Opsional)</span></label>
                                @if($usulan->file_berita_acara)
                                    <div class="mb-2">
                                        <a href="{{ asset($usulan->file_berita_acara) }}" target="_blank" class="badge bg-primary text-decoration-none">
                                            <i class="feather-file-text me-1"></i>Lihat File Saat Ini
                                        </a>
                                    </div>
                                @endif
                                <input type="file" class="form-control" name="file_berita_acara" accept=".pdf,.doc,.docx,.jpg,.png">
                                <div class="form-text">Biarkan kosong jika tidak ingin mengubah file.</div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('usulan.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
