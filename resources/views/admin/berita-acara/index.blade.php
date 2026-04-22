@extends('admin.layout')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10 fw-bold text-dark">Daftar Berita Acara</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#!">Berita Acara</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            {{-- Card Header --}}
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center p-4">
                <h6 class="m-0 fw-bold text-primary">Data Berita Acara</h6>
                <div>
                    @php
                        $role = session('user_role');
                        $isAdmin = $role === 'admin';
                        $canMusdus = $isAdmin || $role === 'operator_dusun';
                        $canMusrenbang = $isAdmin || $role === 'operator_desa';
                        $canBPD = $isAdmin || $role === 'bpd';
                    @endphp

                    @if(request('jenis') == 'Musdus' && $canMusdus)
                        <a href="{{ route('berita-acara.create', ['jenis' => 'Musdus']) }}" class="btn btn-sm btn-primary shadow-sm">
                            <i class="feather-plus me-1"></i> Tambah Musdus
                        </a>
                    @elseif(request('jenis') == 'Musrenbang' && $canMusrenbang)
                        <a href="{{ route('berita-acara.create', ['jenis' => 'Musrenbang']) }}" class="btn btn-sm btn-primary shadow-sm">
                            <i class="feather-plus me-1"></i> Tambah Musrenbang
                        </a>
                    @elseif(request('jenis') == 'BPD' && $canBPD)
                        <a href="{{ route('berita-acara.create', ['jenis' => 'BPD']) }}" class="btn btn-sm btn-primary shadow-sm">
                            <i class="feather-plus me-1"></i> Tambah Musyawarah BPD
                        </a>
                    @elseif(!request('jenis') && ($canMusdus || $canMusrenbang || $canBPD))
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-primary shadow-sm dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="feather-plus me-1"></i> Tambah Baru
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if($canMusdus)
                                    <li><a class="dropdown-item" href="{{ route('berita-acara.create', ['jenis' => 'Musdus']) }}">Musdus</a></li>
                                @endif
                                @if($canMusrenbang)
                                    <li><a class="dropdown-item" href="{{ route('berita-acara.create', ['jenis' => 'Musrenbang']) }}">Musrenbang</a></li>
                                @endif
                                @if($canBPD)
                                    <li><a class="dropdown-item" href="{{ route('berita-acara.create', ['jenis' => 'BPD']) }}">Musyawarah BPD</a></li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-body p-4">
                {{-- Filter Tabs --}}
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link {{ request('jenis') == '' ? 'active' : '' }}" href="{{ route('berita-acara.index') }}">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('jenis') == 'Musdus' ? 'active' : '' }}" href="{{ route('berita-acara.index', ['jenis' => 'Musdus']) }}">Musdus</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('jenis') == 'Musrenbang' ? 'active' : '' }}" href="{{ route('berita-acara.index', ['jenis' => 'Musrenbang']) }}">Musrenbang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('jenis') == 'BPD' ? 'active' : '' }}" href="{{ route('berita-acara.index', ['jenis' => 'BPD']) }}">BPD</a>
                    </li>
                </ul>

                {{-- Alert --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="feather-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="feather-alert-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-dark">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 15%">Jenis</th>
                                <th style="width: 20%">Tanggal & Waktu</th>
                                <th style="width: 25%">Tempat</th>
                                <th style="width: 10%">File BA</th>
                                <th style="width: 25%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($beritaAcaras as $key => $ba)
                                <tr>
                                    <td class="text-muted small">{{ $beritaAcaras->firstItem() + $key }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($ba->jenis) {
                                                'Musdus'     => 'badge-status-proses',
                                                'Musrenbang' => 'badge-status-disetujui',
                                                'BPD'        => 'badge-status-menunggu-bpd',
                                                default      => 'badge bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} rounded-pill px-2 py-1">{{ $ba->jenis }}</span>
                                        @if($ba->dusun)
                                            <br><small class="text-muted">{{ $ba->dusun->nama_dusun }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $ba->hari }}</span><br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($ba->tanggal)->translatedFormat('d F Y') }}</small><br>
                                        <small class="text-muted"><i class="feather-clock me-1" style="font-size:10px;"></i>{{ $ba->jam_mulai }} – {{ $ba->jam_selesai }}</small>
                                    </td>
                                    <td class="text-muted small">{{ Str::limit($ba->tempat, 50) }}</td>
                                    <td class="text-center">
                                        @if($ba->file_pdf)
                                            <span class="badge badge-status-disetujui d-inline-flex align-items-center gap-1 px-2 py-1"><i class="feather-file" style="font-size:11px;"></i>Ada</span>
                                        @else
                                            <span class="badge badge-status-gagal d-inline-flex align-items-center gap-1 px-2 py-1"><i class="feather-x" style="font-size:11px;"></i>Belum</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center flex-wrap">
                                            {{-- Cetak --}}
                                            <a href="{{ route('berita-acara.print', $ba->id_berita) }}" class="btn btn-sm bg-light-primary text-primary border-0 shadow-sm" title="Cetak" target="_blank">
                                                <i class="feather-printer"></i>
                                            </a>

                                            {{-- Unggah PDF --}}
                                            <button type="button" class="btn btn-sm bg-light-info text-info border-0 shadow-sm" title="Unggah PDF" data-bs-toggle="modal" data-bs-target="#uploadPdfModal" onclick="setUploadUrl({{ $ba->id_berita }})">
                                                <i class="feather-upload"></i>
                                            </button>

                                            {{-- Lihat BA --}}
                                            @if($ba->file_pdf)
                                                <a href="{{ asset($ba->file_pdf) }}" class="btn btn-sm bg-light-success text-success border-0 shadow-sm" target="_blank" title="Lihat BA">
                                                    <i class="feather-eye"></i>
                                                </a>
                                            @else
                                                <button type="button" class="btn btn-sm bg-light-secondary text-secondary border-0 shadow-sm" onclick="showAlertNotUploaded()" title="Lihat BA">
                                                    <i class="feather-eye"></i>
                                                </button>
                                            @endif

                                            @php
                                                $canEditRow = false;
                                                if ($ba->jenis == 'Musdus')      $canEditRow = $isAdmin || $role === 'operator_dusun';
                                                elseif ($ba->jenis == 'Musrenbang') $canEditRow = $isAdmin || $role === 'operator_desa';
                                                elseif ($ba->jenis == 'BPD')     $canEditRow = $isAdmin || $role === 'bpd';
                                            @endphp

                                            @if($canEditRow)
                                                {{-- Edit --}}
                                                <a href="{{ route('berita-acara.edit', $ba->id_berita) }}" class="btn btn-sm bg-light-warning text-warning border-0 shadow-sm" title="Edit">
                                                    <i class="feather-edit-2"></i>
                                                </a>
                                                {{-- Hapus --}}
                                                <form action="{{ route('berita-acara.destroy', $ba->id_berita) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm bg-light-danger text-danger border-0 shadow-sm" title="Hapus">
                                                        <i class="feather-trash-2"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="feather-file-text mb-2 d-block" style="font-size: 2rem;"></i>
                                        Belum ada data berita acara.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $beritaAcaras->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Upload PDF Modal --}}
<div class="modal fade" id="uploadPdfModal" tabindex="-1" aria-labelledby="uploadPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="uploadPdfModalLabel">Unggah Berita Acara (PDF)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadPdfForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file_pdf" class="form-label">Pilih File PDF Tanda Tangan Basah</label>
                        <input class="form-control" type="file" id="file_pdf" name="file_pdf" accept="application/pdf" required>
                        <div class="form-text text-muted">Maksimal ukuran file: 5MB. Format: .pdf</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Unggah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById('uploadPdfModal');
        if (modal) {
            document.body.appendChild(modal);
        }
    });

    function showAlertNotUploaded() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: 'File PDF Berita Acara belum diunggah. Silakan unggah terlebih dahulu!'
            });
        } else {
            alert('File PDF Berita Acara belum diunggah. Silakan unggah terlebih dahulu!');
        }
    }

    function setUploadUrl(id) {
        const form = document.getElementById('uploadPdfForm');
        form.action = `/admin/berita-acara/${id}/upload-pdf`;
    }
</script>

@endsection
