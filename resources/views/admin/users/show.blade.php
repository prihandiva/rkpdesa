@extends('admin.layout')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="mb-0">Detail Pengguna</h2>
                    <div>
                        <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-warning me-2">
                            <i class="feather-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Informasi Pengguna</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style="width: 200px;">Nama Lengkap</th>
                                    <td>{{ $user->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>
                                        <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 
                                            ($user->role == 'pegawai' ? 'bg-primary' : 'bg-success') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><span class="badge bg-success">Aktif</span></td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td>{{ $user->telp ?? '-' }}</td>
                                </tr>
                                @if($user->id_dusun)
                                <tr>
                                    <th>Dusun</th>
                                    <td>{{ $user->dusun->nama ?? '-' }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Terdaftar Pada</th>
                                    <td>{{ $user->created_at->format('d F Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Foto Profil</h6>
                    </div>
                    <div class="card-body text-center">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                                <i class="feather-user display-4 text-secondary"></i>
                            </div>
                        @endif
                        <h5 class="mb-1">{{ $user->nama }}</h5>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
