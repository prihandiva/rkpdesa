@extends('admin.layout')

@push('styles')
<style>
    /* Override global table-responsive overflow for BA form tables */
    .ba-form-table-wrapper {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
    }
    .ba-form-table {
        width: 100%;
        min-width: 600px; /* Prevents crushing on small screens */
        border-collapse: collapse;
        table-layout: fixed;
    }
    .ba-form-table thead tr {
        background-color: #f8f9fa;
    }
    .ba-form-table thead th {
        padding: 10px 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #6c757d;
        border-bottom: 1px solid #dee2e6;
        white-space: nowrap;
    }
    .ba-form-table tbody tr {
        border-bottom: 1px solid #f1f3f5;
        vertical-align: middle;
    }
    .ba-form-table tbody tr:last-child {
        border-bottom: none;
    }
    .ba-form-table td {
        padding: 8px 10px;
    }
    .ba-form-table .col-nama  { width: 32%; }
    .ba-form-table .col-alamat { width: 33%; }
    .ba-form-table .col-jabatan { width: 27%; }
    .ba-form-table .col-aksi  { width: 8%; text-align: center; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10 fw-bold text-dark">Tambah Berita Acara {{ $jenis ?? '' }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('berita-acara.index', ['jenis' => $jenis]) }}">Daftar Berita Acara</a></li>
                    <li class="breadcrumb-item"><a href="#!">Tambah</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <form action="{{ route('berita-acara.store') }}" method="POST">
    @csrf
    <input type="hidden" name="jenis" value="{{ $jenis ?? 'Musdus' }}">

    <div class="row">
        <!-- Kolom Kiri -->
        <div class="col-lg-8">
            <!-- Informasi Dasar -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h6 class="m-0 fw-bold text-primary">Informasi Dasar</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="id_tahun" class="form-label">Tahun Anggaran</label>
                                <input type="text" class="form-control bg-light text-muted" value="{{ isset($activeTahun) ? $activeTahun->tahun : 'Belum Ada Tahun Aktif' }}" disabled>
                                <input type="hidden" name="id_tahun" value="{{ isset($activeTahun) ? $activeTahun->id_tahun : '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            @php
                                $isOpDusun = session('user_role') == 'operator_dusun';
                            @endphp
                            <div class="form-group mb-3">
                                <label for="id_dusun" class="form-label">Dusun</label>
                                <select name="id_dusun" id="id_dusun" class="form-select" {{ $isOpDusun ? 'disabled' : '' }} {{ ($jenis == 'Musrenbang' || $jenis == 'BPD') ? '' : 'required' }}>
                                    <option value="">-- Pilih Dusun --</option>
                                    @foreach($dusun as $d)
                                        <option value="{{ $d->id_dusun }}" {{ (old('id_dusun') == $d->id_dusun || (isset($userDusunId) && $userDusunId == $d->id_dusun)) ? 'selected' : '' }}>{{ $d->nama }}</option>
                                    @endforeach
                                </select>
                                @if($isOpDusun)
                                    <input type="hidden" name="id_dusun" value="{{ $userDusunId }}">
                                @endif
                                @if($jenis == 'Musrenbang' || $jenis == 'BPD')
                                    <small class="text-muted">Biarkan kosong jika tingkat Desa</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="hari" class="form-label">Hari</label>
                                <input type="text" name="hari" id="hari" class="form-control" placeholder="Contoh: Senin" value="{{ old('hari') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                            </div>
                        </div>
                         <div class="col-md-2">
                            <div class="form-group mb-3">
                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-3">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label for="tempat" class="form-label">Tempat</label>
                        <textarea name="tempat" id="tempat" class="form-control" rows="2" required>{{ old('tempat') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Isi Berita Acara -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h6 class="m-0 fw-bold text-primary">Isi Berita Acara</h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label for="materi" class="form-label">Materi / Topik Pembahasan</label>
                        <small class="text-danger d-block mb-2">* Gunakan format list angka (1. ..., 2. ...) agar rapi saat dicetak.</small>
                        <textarea name="materi" id="materi" class="form-control tinymce-editor" placeholder="1. Pembahasan RKP Desa...&#10;2. Pembentukan Tim...">{{ old('materi') }}</textarea>
                    </div>

                    <div class="form-group mb-0">
                        <label for="putusan" class="form-label">Putusan / Kesepakatan</label>
                        <small class="text-danger d-block mb-2">* Gunakan format list angka (1. ..., 2. ...) agar rapi saat dicetak.</small>
                        <textarea name="putusan" id="putusan" class="form-control tinymce-editor" placeholder="1. Menyepakati...&#10;2. Menetapkan...">{{ old('putusan') }}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- Wakil Peserta (Table) -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h6 class="m-0 fw-bold text-primary">Wakil Peserta Musyawarah (Yang Bertanda Tangan)</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Masukkan nama perwakilan peserta yang akan menandatangani Berita Acara (Maksimal 10 orang).</p>
                    <div class="ba-form-table-wrapper">
                        <table class="ba-form-table" id="pesertaTable">
                            <thead>
                                <tr>
                                    <th class="col-nama">Nama</th>
                                    <th class="col-alamat">Alamat</th>
                                    <th class="col-jabatan">Jabatan (Unsur)</th>
                                    <th class="col-aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-nama"><input type="text" name="peserta_nama[]" class="form-control form-control-sm" placeholder="Nama Peserta" required></td>
                                    <td class="col-alamat"><input type="text" name="peserta_alamat[]" class="form-control form-control-sm" placeholder="Alamat"></td>
                                    <td class="col-jabatan"><input type="text" name="peserta_jabatan[]" class="form-control form-control-sm" placeholder="Tokoh Masyarakat" value="Peserta"></td>
                                    <td class="col-aksi">
                                        <button type="button" class="btn btn-sm bg-light-danger text-danger border-0 removePeserta" title="Hapus">
                                            <i class="feather-trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-sm bg-light-primary text-primary border-0 shadow-sm" id="addPeserta">
                            <i class="feather-plus me-1"></i> Tambah Wakil TTD
                        </button>
                    </div>
                </div>
            </div>

            <!-- Daftar Hadir (Table) -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h6 class="m-0 fw-bold text-primary">Daftar Hadir (Absensi)</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Masukkan nama seluruh peserta musyawarah yang hadir sebagai lampiran daftar hadir.</p>
                    <div class="ba-form-table-wrapper">
                        <table class="ba-form-table" id="absensiTable">
                            <thead>
                                <tr>
                                    <th class="col-nama">Nama</th>
                                    <th class="col-alamat">Alamat</th>
                                    <th class="col-jabatan">Unsur / Jabatan</th>
                                    <th class="col-aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-nama"><input type="text" name="absensi_nama[]" class="form-control form-control-sm" placeholder="Nama Hadirin"></td>
                                    <td class="col-alamat"><input type="text" name="absensi_alamat[]" class="form-control form-control-sm" placeholder="Alamat"></td>
                                    <td class="col-jabatan"><input type="text" name="absensi_unsur[]" class="form-control form-control-sm" placeholder="Tokoh Masyarakat" value="Peserta"></td>
                                    <td class="col-aksi">
                                        <button type="button" class="btn btn-sm bg-light-danger text-danger border-0 removeAbsensi" title="Hapus">
                                            <i class="feather-trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-sm bg-light-primary text-primary border-0 shadow-sm" id="addAbsensi">
                            <i class="feather-plus me-1"></i> Tambah Daftar Hadir
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4 mb-5 gap-2">
                <a href="{{ route('berita-acara.index', ['jenis' => $jenis ?? 'Musdus']) }}" class="btn btn-sm btn-light-secondary shadow-sm">Batal</a>
                <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                    <i class="feather-save me-2"></i> Simpan Berita Acara
                </button>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h6 class="m-0 fw-bold text-primary">Pimpinan & Notulis</h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="pemimpin" class="form-label">Pimpinan Rapat</label>
                        <input type="text" list="pegawai_list" name="pemimpin" id="pemimpin" class="form-control" 
                            placeholder="Nama Pimpinan" value="{{ old('pemimpin') }}" autocomplete="off" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="asal_pemimpin" class="form-label">Asal Pimpinan (Jabatan/Instansi)</label>
                        <input type="text" name="asal_pemimpin" id="asal_pemimpin" class="form-control" 
                            placeholder="Contoh: Ketua BPD" value="{{ old('asal_pemimpin') }}" required>
                    </div>

                    @if(($jenis ?? '') == 'BPD')
                    <hr class="mb-4">
                    <div class="form-group mb-4">
                        <label for="nama_bpd" class="form-label">Ketua BPD</label>
                        <input type="text" name="nama_bpd" id="nama_bpd" class="form-control" 
                            placeholder="Nama Ketua BPD" value="{{ old('nama_bpd') }}" required>
                    </div>
                    @endif

                    <hr class="mb-4">
                    
                    <div class="form-group mb-3">
                        <label for="notulis1" class="form-label">Notulis 1</label>
                        <input type="text" list="pegawai_list" name="notulis1" id="notulis1" class="form-control" 
                            placeholder="Nama Notulis 1" value="{{ old('notulis1') }}" autocomplete="off">
                    </div>
                    <div class="form-group mb-4">
                        <label for="asal_notulis1" class="form-label">Asal Notulis 1</label>
                        <input type="text" name="asal_notulis1" id="asal_notulis1" class="form-control" 
                            placeholder="Contoh: Sekretaris Desa" value="{{ old('asal_notulis1') }}">
                    </div>

                    <hr class="mb-4">

                    <div class="form-group mb-3">
                        <label for="notulis2" class="form-label">Notulis 2 (Opsional)</label>
                        <input type="text" list="pegawai_list" name="notulis2" id="notulis2" class="form-control" 
                            placeholder="Nama Notulis 2" value="{{ old('notulis2') }}" autocomplete="off">
                    </div>
                    <div class="form-group mb-0">
                        <label for="asal_notulis2" class="form-label">Asal Notulis 2</label>
                        <input type="text" name="asal_notulis2" id="asal_notulis2" class="form-control" 
                            placeholder="Contoh: Kaur Perencanaan" value="{{ old('asal_notulis2') }}">
                    </div>

                    <!-- Datalist for usage in inputs -->
                    <datalist id="pegawai_list">
                        @foreach($pegawai as $p)
                            <option value="{{ $p->nama }}">{{ $p->posisi }}</option>
                        @endforeach
                    </datalist>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '.tinymce-editor',
        height: 300,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 'anchor',
            'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        promotion: false
    });

    document.getElementById('addPeserta').addEventListener('click', function() {
        var table = document.getElementById('pesertaTable').getElementsByTagName('tbody')[0];
        var row = table.insertRow(table.rows.length);
        row.className = "";
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);

        cell1.className = "col-nama";
        cell2.className = "col-alamat";
        cell3.className = "col-jabatan";
        cell4.className = "col-aksi";

        cell1.innerHTML = '<input type="text" name="peserta_nama[]" class="form-control form-control-sm" placeholder="Nama Peserta" required>';
        cell2.innerHTML = '<input type="text" name="peserta_alamat[]" class="form-control form-control-sm" placeholder="Alamat">';
        cell3.innerHTML = '<input type="text" name="peserta_jabatan[]" class="form-control form-control-sm" placeholder="Tokoh Masyarakat" value="Peserta">';
        cell4.innerHTML = '<button type="button" class="btn btn-sm bg-light-danger text-danger border-0 removePeserta" title="Hapus"><i class="feather-trash-2"></i></button>';
    });

    document.querySelector('#pesertaTable').addEventListener('click', function(e) {
        var target = e.target;
        var btn = target.closest('.removePeserta');
        
        if (btn) {
            var row = btn.closest('tr');
            if(document.getElementById('pesertaTable').getElementsByTagName('tbody')[0].rows.length > 1) {
                row.remove();
            } else {
                alert("Minimal satu peserta (Wakil TTD) harus ada.");
            }
        }
    });

    document.getElementById('addAbsensi').addEventListener('click', function() {
        var table = document.getElementById('absensiTable').getElementsByTagName('tbody')[0];
        var row = table.insertRow(table.rows.length);
        row.className = "";
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);

        cell1.className = "col-nama";
        cell2.className = "col-alamat";
        cell3.className = "col-jabatan";
        cell4.className = "col-aksi";

        cell1.innerHTML = '<input type="text" name="absensi_nama[]" class="form-control form-control-sm" placeholder="Nama Hadirin">';
        cell2.innerHTML = '<input type="text" name="absensi_alamat[]" class="form-control form-control-sm" placeholder="Alamat">';
        cell3.innerHTML = '<input type="text" name="absensi_unsur[]" class="form-control form-control-sm" placeholder="Tokoh Masyarakat" value="Peserta">';
        cell4.innerHTML = '<button type="button" class="btn btn-sm bg-light-danger text-danger border-0 removeAbsensi" title="Hapus"><i class="feather-trash-2"></i></button>';
    });

    document.querySelector('#absensiTable').addEventListener('click', function(e) {
        var target = e.target;
        var btn = target.closest('.removeAbsensi');
        
        if (btn) {
            var row = btn.closest('tr');
            if(document.getElementById('absensiTable').getElementsByTagName('tbody')[0].rows.length > 1) {
                row.remove();
            } else {
                var inputs = row.querySelectorAll('input');
                inputs.forEach(input => input.value = '');
            }
        }
    });
</script>
@endpush
