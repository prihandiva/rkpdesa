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
                                <label for="jenis" class="form-label">Jenis</label>
                                <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="Fisik" {{ old('jenis', $usulan->jenis) == 'Fisik' ? 'selected' : '' }}>Fisik</option>
                                    <option value="Non Fisik" {{ old('jenis', $usulan->jenis) == 'Non Fisik' ? 'selected' : '' }}>Non Fisik</option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jenis_kegiatan" class="form-label">Jenis Kegiatan (Nama Usulan)</label>
                                <input type="text" class="form-control @error('jenis_kegiatan') is-invalid @enderror"
                                    id="jenis_kegiatan" name="jenis_kegiatan" value="{{ old('jenis_kegiatan', $usulan->jenis_kegiatan) }}" required>
                                @error('jenis_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Lengkap</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                    id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $usulan->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Dusun</label>
                                <!-- Display disabled select/input for visual -->
                                <select class="form-select bg-light" disabled>
                                    @foreach(\App\Models\Dusun::all() as $dusun)
                                        <option value="{{ $dusun->id_dusun }}" {{ $usulan->id_dusun == $dusun->id_dusun ? 'selected' : '' }}>
                                            {{ $dusun->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <!-- Send actual value via hidden input -->
                                <input type="hidden" name="id_dusun" value="{{ $usulan->id_dusun }}">
                            </div>

                            <div class="mb-3">
                                <label for="prioritas" class="form-label">Prioritas</label>
                                <input type="number" class="form-control @error('prioritas') is-invalid @enderror" 
                                    id="prioritas" name="prioritas" value="{{ old('prioritas', $usulan->prioritas) }}" required min="1">
                                <div class="form-text text-muted">Angka prioritas harus unik dalam satu dusun.</div>
                                @error('prioritas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status field removed as per request (Cannot change status in edit) --}}
                            {{-- <input type="hidden" name="status" value="{{ $usulan->status }}"> --}}

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
