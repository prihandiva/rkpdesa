@extends('admin.layout')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Tambah Berita Acara {{ $jenis ?? '' }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('berita-acara.index', ['jenis' => $jenis]) }}">Daftar Berita Acara</a></li>
                    <li class="breadcrumb-item"><a href="#!">Tambah</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Form Tambah Berita Acara</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('berita-acara.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="jenis" value="{{ $jenis ?? 'Musdus' }}">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_tahun">Tahun Anggaran</label>
                                <select name="id_tahun" id="id_tahun" class="form-control" required>
                                    @foreach($tahun as $t)
                                        <option value="{{ $t->id_tahun }}">{{ $t->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_dusun">Dusun</label>
                                <select name="id_dusun" id="id_dusun" class="form-control" {{ ($jenis == 'Musrenbang' || $jenis == 'BPD') ? '' : 'required' }}>
                                    <option value="">-- Pilih Dusun --</option>
                                    @foreach($dusun as $d)
                                        <option value="{{ $d->id_dusun }}" {{ (old('id_dusun') == $d->id_dusun || (isset($userDusunId) && $userDusunId == $d->id_dusun)) ? 'selected' : '' }}>{{ $d->nama_dusun }}</option>
                                    @endforeach
                                </select>
                                @if($jenis == 'Musrenbang' || $jenis == 'BPD')
                                    <small class="text-muted">Biarkan kosong jika tingkat Desa</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hari">Hari</label>
                                <input type="text" name="hari" id="hari" class="form-control" placeholder="Contoh: Senin" value="{{ old('hari') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                            </div>
                        </div>
                         <div class="col-md-2">
                            <div class="form-group">
                                <label for="jam_mulai">Jam Mulai</label>
                                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="jam_selesai">Jam Selesai</label>
                                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tempat">Tempat</label>
                        <textarea name="tempat" id="tempat" class="form-control" rows="2" required>{{ old('tempat') }}</textarea>
                    </div>

                    <hr>
                    <h5>Isi Berita Acara</h5>

                    <div class="form-group">
                        <label for="materi">Materi / Topik Pembahasan</label>
                        <small class="text-danger d-block mb-1">* Gunakan format list angka (1. ..., 2. ...) agar rapi saat dicetak.</small>
                        <textarea name="materi" id="materi" class="form-control tinymce-editor" placeholder="1. Pembahasan RKP Desa...&#10;2. Pembentukan Tim...">{{ old('materi') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="putusan">Putusan / Kesepakatan</label>
                        <small class="text-danger d-block mb-1">* Gunakan format list angka (1. ..., 2. ...) agar rapi saat dicetak.</small>
                        <textarea name="putusan" id="putusan" class="form-control tinymce-editor" placeholder="1. Menyepakati...&#10;2. Menetapkan...">{{ old('putusan') }}</textarea>
                    </div>

                    <hr>
                    <h5>Pimpinan & Notulis</h5>
                    <hr>
                    <h5>Pimpinan & Notulis</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pemimpin">Pimpinan Rapat</label>
                                <input type="text" list="pegawai_list" name="pemimpin" id="pemimpin" class="form-control" 
                                    placeholder="Nama Pimpinan" value="{{ old('pemimpin') }}" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="asal_pemimpin">Asal Pimpinan (Jabatan/Instansi)</label>
                                <input type="text" name="asal_pemimpin" id="asal_pemimpin" class="form-control" 
                                    placeholder="Contoh: Ketua BPD" value="{{ old('asal_pemimpin') }}" required>
                            </div>
                        </div>
                    </div>

                    @if(($jenis ?? '') == 'BPD')
                    <div class="row">
                         <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama_bpd">Ketua BPD</label>
                                <input type="text" name="nama_bpd" id="nama_bpd" class="form-control" 
                                    placeholder="Nama Ketua BPD" value="{{ old('nama_bpd') }}" required>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="notulis1">Notulis 1</label>
                                <input type="text" list="pegawai_list" name="notulis1" id="notulis1" class="form-control" 
                                    placeholder="Nama Notulis 1" value="{{ old('notulis1') }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="asal_notulis1">Asal Notulis 1</label>
                                <input type="text" name="asal_notulis1" id="asal_notulis1" class="form-control" 
                                    placeholder="Contoh: Sekretaris Desa" value="{{ old('asal_notulis1') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="notulis2">Notulis 2 (Opsional)</label>
                                <input type="text" list="pegawai_list" name="notulis2" id="notulis2" class="form-control" 
                                    placeholder="Nama Notulis 2" value="{{ old('notulis2') }}" autocomplete="off">
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="asal_notulis2">Asal Notulis 2</label>
                                <input type="text" name="asal_notulis2" id="asal_notulis2" class="form-control" 
                                    placeholder="Contoh: Kaur Perencanaan" value="{{ old('asal_notulis2') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Datalist for usage in inputs -->
                    <datalist id="pegawai_list">
                        @foreach($pegawai as $p)
                            <option value="{{ $p->nama }}">{{ $p->posisi }}</option>
                        @endforeach
                    </datalist>

                    <hr class="my-4">
                    <h5 class="mb-3">Daftar Peserta Hadir (Yang Menandatangani)</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" id="pesertaTable">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 30%">Nama</th>
                                    <th style="width: 35%">Alamat</th>
                                    <th style="width: 25%">Jabatan (Unsur)</th>
                                    <th style="width: 10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="peserta_nama[]" class="form-control" placeholder="Nama Peserta" required></td>
                                    <td><input type="text" name="peserta_alamat[]" class="form-control" placeholder="Alamat"></td>
                                    <td><input type="text" name="peserta_jabatan[]" class="form-control" placeholder="Contoh: Tokoh Masyarakat" value="Peserta"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger removePeserta" title="Hapus">
                                            <i class="feather icon-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-sm btn-info" id="addPeserta">
                            <i class="feather icon-plus me-1"></i> Tambah Peserta
                        </button>
                    </div>

                    <div class="mt-5 text-end border-top pt-3">
                        <a href="{{ route('berita-acara.index') }}" class="btn btn-light-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Berita Acara</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script for existing scripts section --}}
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
        // Free CDN sometimes needs this to avoid cloud api key warnings if using their specific builds, 
        // but cdnjs should be clean. 
        promotion: false
    });


    document.getElementById('addPeserta').addEventListener('click', function() {
        var table = document.getElementById('pesertaTable').getElementsByTagName('tbody')[0];
        var row = table.insertRow(table.rows.length);
        
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);

        cell4.className = "text-center";

        cell1.innerHTML = '<input type="text" name="peserta_nama[]" class="form-control" placeholder="Nama Peserta" required>';
        cell2.innerHTML = '<input type="text" name="peserta_alamat[]" class="form-control" placeholder="Alamat">';
        cell3.innerHTML = '<input type="text" name="peserta_jabatan[]" class="form-control" placeholder="Contoh: Tokoh Masyarakat" value="Peserta">';
        cell4.innerHTML = '<button type="button" class="btn btn-sm btn-danger removePeserta" title="Hapus"><i class="feather icon-trash"></i></button>';
    });

    document.querySelector('#pesertaTable').addEventListener('click', function(e) {
        // Handle click on button or icon inside button
        var target = e.target;
        var btn = target.closest('.removePeserta');
        
        if (btn) {
            var row = btn.closest('tr');
            if(document.getElementById('pesertaTable').getElementsByTagName('tbody')[0].rows.length > 1) {
                row.remove();
            } else {
                alert("Minimal satu peserta harus ada.");
            }
        }
    });
</script>
@endpush
