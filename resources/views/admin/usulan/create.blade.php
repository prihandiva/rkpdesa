@extends('admin.layout')

@section('title', 'Tambah Usulan')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Musyawarah Dusun</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('usulan.index') }}">Usulan</a></li>
                    <li class="breadcrumb-item">Musdus Session</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <a href="{{ route('usulan.index') }}" class="btn btn-md btn-secondary">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Kembali ke Daftar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ page-header ] end -->

        <div class="row">
            <!--! [Start] Main Form Column !-->
            <div class="col-lg-8">
                <!--! [Start] Form Card !-->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Input Usulan Baru</h6>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('usulan.store') }}">
                            @csrf

                            {{-- Hidden Status Default --}}
                            <input type="hidden" name="status" value="Proses">
                            {{-- Tahun is Disabled, send as hidden --}}
                            <input type="hidden" name="tahun" value="{{ $tahun_aktif }}">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Dusun</label>
                                    @if(isset($currentUser) && $currentUser->role == 'operator_dusun')
                                        {{-- Disabled for Operator Dusun --}}
                                        <input type="text" class="form-control bg-light" value="{{ $currentUser->dusun->nama ?? '-' }}" readonly>
                                        <input type="hidden" name="id_dusun" value="{{ $currentUser->id_dusun }}" id="dusun_id">
                                    @else
                                        {{-- Enable for admin --}}
                                        <select class="form-select" name="id_dusun" id="dusun_id" required>
                                            <option value="">-- Pilih Dusun --</option>
                                            @foreach($dusuns as $dusun)
                                                <option value="{{ $dusun->id_dusun }}" {{ old('id_dusun') == $dusun->id_dusun ? 'selected' : '' }}>{{ $dusun->nama }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tahun Anggaran</label>
                                    <input type="text" class="form-control bg-light" value="{{ $tahun_aktif }}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">RW <span class="text-danger">*</span></label>
                                    <select class="form-select" name="id_rw" id="rw_id" required>
                                        <option value="">-- Pilih RW --</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">RT <span class="text-danger">*</span></label>
                                    <select class="form-select" name="id_rt" id="rt_id" required>
                                        <option value="">-- Pilih RT --</option>
                                    </select>
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
                                    <label class="form-label">Jenis Kegiatan / Nama Usulan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="jenis_kegiatan" required placeholder="Contoh: Pembangunan Jalan Paving..." value="{{ old('jenis_kegiatan') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Lengkap</label>
                                <textarea class="form-control" name="deskripsi" placeholder="Jelaskan detail usulan..." rows="3">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Prioritas <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="prioritas" required placeholder="Masukkan angka prioritas (1, 2, 3...)" min="1" value="{{ old('prioritas') }}">
                                <div class="form-text text-muted">Angka prioritas harus unik dalam satu dusun.</div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather-plus-circle me-1"></i> Tambahkan ke Daftar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--! [End] Form Card !-->

                <!--! [Start] Draft List Card !-->
                @if(isset($draftUsulans) && count($draftUsulans) > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Daftar Usulan Terinput ({{ count($draftUsulans) }})</h6>
                        <span class="badge bg-primary">Sesi Ini</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Prio</th>
                                        <th>Kegiatan</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($draftUsulans as $draft)
                                    <tr>
                                        <td class="text-center fw-bold">{{ $draft->prioritas }}</td>
                                        <td>{{ Str::limit($draft->jenis_kegiatan, 40) }}</td>
                                        <td>RW {{ $draft->id_rw }} / RT {{ $draft->id_rt }}</td>
                                        <td><span class="badge bg-primary">Proses</span></td>
                                        {{-- <td><button class="btn btn-xs btn-outline-danger"><i class="feather-trash"></i></button></td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
                <!--! [End] Draft List Card !-->

                <!--! [Start] Finalize Section !-->
                <div class="card border-0 shadow-sm mb-4 bg-light">
                    <div class="card-header border-bottom">
                        <h6 class="mb-0 text-dark"><i class="feather-file-text me-2"></i>Finalisasi & Berita Acara</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">
                            Setelah semua usulan dimasukkan:
                            1. Cetak Berita Acara (Download PDF/Doc).
                            2. Lakukan TTD Basah pada dokumen.
                            3. Foto/Scan dokumen yang sudah ditandatangani.
                            4. Unggah kembali file tersebut di bawah ini untuk menyelesaikan Musdus.
                        </p>
                        
                        <div class="row align-items-end">
                            <div class="col-md-5 mb-3">
                                <label class="form-label btn btn-outline-primary w-100 p-3" style="border-style: dashed;">
                                    <i class="feather-printer fs-1"></i><br>
                                    Cetak Berita Acara
                                    <span class="d-block small text-muted mt-1">(Download Template)</span>
                                    <a href="#" class="stretched-link"></a>
                                </label>
                            </div>
                            <div class="col-md-7 mb-3">
                                <form action="{{ route('usulan.upload_ba') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id_dusun" value="{{ $currentUser->id_dusun }}">
                                    <input type="hidden" name="tahun" value="{{ $tahun_aktif }}">
                                    
                                    <label class="form-label">Unggah Berita Acara (Signed) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="file_berita_acara" required accept=".pdf,.jpg,.png">
                                        <button class="btn btn-success" type="submit">
                                            <i class="feather-upload-cloud me-1"></i> Unggah
                                        </button>
                                    </div>
                                    <div class="form-text text-muted">File ini akan diterapkan ke semua usulan di atas.</div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--! [End] Finalize Section !-->

            </div>
            <!--! [End] Main Form Column !-->

            <!--! [Start] Right Sidebar !-->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                       <h6 class="mb-0">Timeline Alur Data</h6>
                    </div>
                     <div class="card-body">
                         <div class="timeline-box">
                             <div class="timeline-item active">
                                 <div class="icon-holder bg-primary text-white">1</div>
                                 <div class="content">
                                     <h6 class="mb-0">Musyawarah Dusun</h6>
                                     <p class="text-muted small mb-0">Input Usulan & Upload Berita Acara</p>
                                     <span class="badge bg-soft-primary text-primary mt-1">Saat Ini</span>
                                 </div>
                             </div>
                             <div class="timeline-item">
                                 <div class="icon-holder bg-light text-muted">2</div>
                                 <div class="content">
                                     <h6 class="mb-0 text-muted">Pending Verifikasi</h6>
                                     <p class="text-muted small mb-0">Menunggu Review Operator Desa</p>
                                 </div>
                             </div>
                             <div class="timeline-item">
                                 <div class="icon-holder bg-light text-muted">3</div>
                                 <div class="content">
                                     <h6 class="mb-0 text-muted">Masuk RKP Desa</h6>
                                     <p class="text-muted small mb-0">Usulan terpilih masuk draft RKP</p>
                                 </div>
                             </div>
                             <div class="timeline-item">
                                 <div class="icon-holder bg-light text-muted">4</div>
                                 <div class="content">
                                     <h6 class="mb-0 text-muted">Approval</h6>
                                     <p class="text-muted small mb-0">Disetujui Kepala Desa & BPD</p>
                                 </div>
                             </div>
                         </div>
                     </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                         <h6 class="mb-0">Info Dusun</h6>
                    </div>
                     <div class="card-body">
                         @if(isset($currentUser) && $currentUser->dusun)
                             <p class="mb-2"><strong>Dusun:</strong> {{ $currentUser->dusun->nama }}</p>
                             <p class="mb-2"><strong>Kepala Dusun:</strong> {{ $currentUser->nama }}</p>
                         @endif
                         <p class="mb-0"><strong>Tahun Anggaran:</strong> {{ $tahun_aktif }}</p>
                     </div>
                </div>
            </div>
            <!--! [End] Right Sidebar !-->
        </div>
    </div>

    {{-- Script untuk Dynamic Dropdown --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allRW = @json($rws); 
            const allRT = @json($rts); 
            
            const dusunSelect = document.getElementById('dusun_id');
            const rwSelect = document.getElementById('rw_id');
            const rtSelect = document.getElementById('rt_id');

            function filterRW(dusunId) {
                rwSelect.innerHTML = '<option value="">-- Pilih RW --</option>';
                rtSelect.innerHTML = '<option value="">-- Pilih RT --</option>'; 
                
                if(!dusunId) return;

                const filteredRW = allRW.filter(rw => rw.id_dusun == dusunId);
                filteredRW.forEach(rw => {
                    const option = document.createElement('option');
                    option.value = rw.id_rw;
                    option.textContent = rw.nama_rw ? rw.nama_rw : 'RW ' + rw.id_rw;
                    rwSelect.appendChild(option);
                });
            }

            function filterRT(rwId) {
                rtSelect.innerHTML = '<option value="">-- Pilih RT --</option>';
                
                if(!rwId) return;

                const filteredRT = allRT.filter(rt => rt.id_rw == rwId);
                filteredRT.forEach(rt => {
                    const option = document.createElement('option');
                    option.value = rt.id_rt;
                    option.textContent = rt.nama_rt ? rt.nama_rt : 'RT ' + rt.id_rt;
                    rtSelect.appendChild(option);
                });
            }

            if(dusunSelect.tagName === 'INPUT') {
                filterRW(dusunSelect.value);
            } else {
                dusunSelect.addEventListener('change', function() {
                    filterRW(this.value);
                });
            }

            rwSelect.addEventListener('change', function() {
                 filterRT(this.value);
            });
        });
    </script>
    
    <style>
        .timeline-box .timeline-item {
            position: relative;
            padding-left: 3rem;
            padding-bottom: 2rem;
            border-left: 2px solid #e9ecef;
        }
        .timeline-box .timeline-item:last-child {
            border-left: 0;
            padding-bottom: 0;
        }
        .timeline-box .timeline-item .icon-holder {
            position: absolute;
            left: -19px;
            top: 0;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            z-index: 1;
        }
    </style>
@endsection

