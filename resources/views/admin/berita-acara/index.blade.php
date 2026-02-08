@extends('admin.layout')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Daftar Berita Acara {{ $jenis ?? 'Semua' }}</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#!">Berita Acara</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Data Berita Acara</h5>
                <div>
                <div>
                     @if(request('jenis') == 'Musdus')
                        @if(in_array(session('user_role'), ['operator_dusun', 'admin']))
                        <a href="{{ route('berita-acara.create', ['jenis' => 'Musdus']) }}" class="btn btn-primary btn-sm rounded"><i class="feather icon-plus"></i> Tambah Musdus</a>
                        @endif
                     @elseif(request('jenis') == 'Musrenbang')
                        @if(in_array(session('user_role'), ['operator_desa', 'admin']))
                        <a href="{{ route('berita-acara.create', ['jenis' => 'Musrenbang']) }}" class="btn btn-primary btn-sm rounded"><i class="feather icon-plus"></i> Tambah Musrenbang</a>
                        @endif
                     @elseif(request('jenis') == 'BPD')
                        @if(in_array(session('user_role'), ['bpd', 'admin']))
                        <a href="{{ route('berita-acara.create', ['jenis' => 'BPD']) }}" class="btn btn-primary btn-sm rounded"><i class="feather icon-plus"></i> Tambah Musyawarah BPD</a>
                        @endif
                     @else
                        <!-- General Add Button - Show only allowed options -->
                        @php
                            $role = session('user_role');
                            $isAdmin = $role === 'admin';
                            $canMusdus = $isAdmin || $role === 'operator_dusun';
                            $canMusrenbang = $isAdmin || $role === 'operator_desa';
                            $canBPD = $isAdmin || $role === 'bpd';
                        @endphp

                        @if($canMusdus || $canMusrenbang || $canBPD)
                         <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="feather icon-plus"></i> Tambah Baru
                            </button>
                            <div class="dropdown-menu">
                                @if($canMusdus)
                                <a class="dropdown-item" href="{{ route('berita-acara.create', ['jenis' => 'Musdus']) }}">Musdus</a>
                                @endif
                                @if($canMusrenbang)
                                <a class="dropdown-item" href="{{ route('berita-acara.create', ['jenis' => 'Musrenbang']) }}">Musrenbang</a>
                                @endif
                                @if($canBPD)
                                <a class="dropdown-item" href="{{ route('berita-acara.create', ['jenis' => 'BPD']) }}">Musyawarah BPD</a>
                                @endif
                            </div>
                        </div>
                        @endif
                     @endif
                </div>
                </div>
            </div>
            <div class="card-body">
                {{-- Filter Tabs --}}
                <ul class="nav nav-tabs mb-3">
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

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Tempat</th>
                                <th>Pimpinan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($beritaAcaras as $key => $ba)
                                <tr>
                                    <td>{{ $beritaAcaras->firstItem() + $key }}</td>
                                    <td>
                                        <span class="badge badge-{{ $ba->jenis == 'Musdus' ? 'info' : ($ba->jenis == 'Musrenbang' ? 'success' : 'warning') }}">
                                            {{ $ba->jenis }}
                                        </span>
                                        @if($ba->dusun)
                                            <br><small class="text-muted">{{ $ba->dusun->nama_dusun }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $ba->hari }}, {{ \Carbon\Carbon::parse($ba->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td>{{ Str::limit($ba->tempat, 30) }}</td>
                                    <td>{{ $ba->pemimpinPegawai->nama ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('berita-acara.show', $ba->id_berita) }}" class="btn btn-sm btn-info" title="Lihat"><i class="feather icon-eye"></i></a>
                                            
                                            @php
                                                $role = session('user_role');
                                                $isAdmin = $role === 'admin';
                                                $canEdit = false;

                                                if ($ba->jenis == 'Musdus') {
                                                    $canEdit = $isAdmin || $role === 'operator_dusun';
                                                } elseif ($ba->jenis == 'Musrenbang') {
                                                    $canEdit = $isAdmin || $role === 'operator_desa';
                                                } elseif ($ba->jenis == 'BPD') {
                                                    $canEdit = $isAdmin || $role === 'bpd';
                                                }
                                            @endphp

                                            @if($canEdit)
                                            <a href="{{ route('berita-acara.edit', $ba->id_berita) }}" class="btn btn-sm btn-warning" title="Edit"><i class="feather icon-edit"></i></a>
                                            <form action="{{ route('berita-acara.destroy', $ba->id_berita) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="feather icon-trash"></i></button>
                                            </form>
                                            @endif
                                            
                                            <a href="{{ route('berita-acara.print', $ba->id_berita) }}" class="btn btn-sm btn-dark" title="Cetak PDF" target="_blank"><i class="feather icon-printer"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data berita acara.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $beritaAcaras->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
