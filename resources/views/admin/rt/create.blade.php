@extends('admin.layout')

@section('title', 'Tambah RT')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10 fw-bold text-dark">Tambah RT</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rt.index') }}">RT</a></li>
                    <li class="breadcrumb-item">Tambah</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold text-primary"><i class="feather-map-pin me-2"></i>Form Tambah RT</h6>
                <a href="{{ route('rt.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="feather-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('rt.store') }}" method="POST">
                    @csrf

                    {{-- Dusun --}}
                    <div class="mb-4">
                        <label for="id_dusun" class="form-label fw-semibold">
                            Dusun <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('id_dusun') is-invalid @enderror"
                                id="id_dusun" name="id_dusun" required>
                            <option value="">-- Pilih Dusun --</option>
                            @foreach($dusun as $d)
                                <option value="{{ $d->id_dusun }}" {{ old('id_dusun') == $d->id_dusun ? 'selected' : '' }}>
                                    {{ $d->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_dusun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih dusun terlebih dahulu untuk menyaring daftar RW.</div>
                    </div>

                    {{-- RW (filter by dusun) --}}
                    <div class="mb-4">
                        <label for="id_rw" class="form-label fw-semibold">
                            RW <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('id_rw') is-invalid @enderror"
                                id="id_rw" name="id_rw" required>
                            <option value="">-- Pilih RW --</option>
                            @foreach($rws as $rw)
                                <option value="{{ $rw->id_rw }}"
                                        data-dusun="{{ $rw->id_dusun }}"
                                        {{ old('id_rw') == $rw->id_rw ? 'selected' : '' }}>
                                    {{ $rw->nama_rw }}
                                    @if($rw->dusun) ({{ $rw->dusun->nama }}) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('id_rw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted" id="rwHelp">Pilih RW yang menaungi RT ini.</div>
                    </div>

                    {{-- Nama RT --}}
                    <div class="mb-4">
                        <label for="nama_rt" class="form-label fw-semibold">
                            Nama / Nomor RT <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('nama_rt') is-invalid @enderror"
                               id="nama_rt" name="nama_rt"
                               value="{{ old('nama_rt') }}"
                               placeholder="Contoh: RT 01 atau RT Melati"
                               required>
                        @error('nama_rt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="feather-save me-1"></i>Simpan
                        </button>
                        <a href="{{ route('rt.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Side info --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-light-primary">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="feather-info me-2 text-primary"></i>Panduan Pengisian</h6>
                <ul class="mb-0 small text-muted ps-3">
                    <li class="mb-2">Pilih <strong>Dusun</strong> terlebih dahulu agar daftar RW tersaring otomatis.</li>
                    <li class="mb-2">Pilih <strong>RW</strong> yang menjadi induk dari RT ini.</li>
                    <li>Isi <strong>Nama/Nomor RT</strong>, misalnya <em>RT 01</em> atau <em>RT Cempaka</em>.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    // Filter RW berdasarkan Dusun yang dipilih
    const dusunSelect = document.getElementById('id_dusun');
    const rwSelect    = document.getElementById('id_rw');
    const allRwOptions = Array.from(rwSelect.querySelectorAll('option'));

    function filterRW() {
        const selectedDusun = dusunSelect.value;
        const currentRw = rwSelect.value;

        // Hapus semua option kecuali placeholder
        while (rwSelect.options.length > 1) {
            rwSelect.remove(1);
        }

        allRwOptions.forEach(opt => {
            if (!opt.value) return; // skip placeholder
            if (!selectedDusun || opt.dataset.dusun === selectedDusun) {
                rwSelect.add(opt.cloneNode(true));
            }
        });

        // Restore nilai lama jika masih ada
        if (currentRw) rwSelect.value = currentRw;
    }

    dusunSelect.addEventListener('change', filterRW);

    // Jalankan saat load (untuk old() value)
    filterRW();
</script>
@endsection
