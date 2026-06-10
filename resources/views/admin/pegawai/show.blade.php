@extends('admin.layout')

@section('title', 'Detail Pegawai')

@section('content')
@php
    $item = $pegawai ?? null;
@endphp
<div class="container-fluid">
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Detail Pegawai</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Pegawai</a></li>
                <li class="breadcrumb-item">Detail</li>
            </ul>
        </div>
        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                    <a href="{{ route('pegawai.edit', $item->id_pegawai) }}" class="btn btn-md btn-warning">
                        <i class="feather-edit me-2"></i>
                        <span>Edit</span>
                    </a>
                    <a href="{{ route('pegawai.index') }}" class="btn btn-md btn-secondary">
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Informasi Pegawai</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">NIP</th>
                                <td>{{ $item->NIP ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama Pegawai</th>
                                <td>{{ $item->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Posisi/Jabatan</th>
                                <td>{{ $item->posisi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>{{ $item->telp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $item->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $item->alamat ?? '-' }}</td>
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
                    @if($item->profile_image)
                        <img src="{{ str_starts_with($item->profile_image, 'uploads') ? asset($item->profile_image) : asset('storage/' . $item->profile_image) }}" alt="Profile" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                            <i class="feather-user display-4 text-secondary"></i>
                        </div>
                    @endif
                    <h5 class="mb-1">{{ $item->nama }}</h5>
                    <p class="text-muted mb-0">{{ $item->posisi }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
