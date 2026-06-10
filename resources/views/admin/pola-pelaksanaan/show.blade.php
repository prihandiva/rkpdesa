@extends('admin.layout')

@section('title', 'Detail Pola Pelaksanaan')

@section('content')
@php
    $item = $polaPelaksanaan ?? $pola_pelaksanaan ?? null;
@endphp
<div class="container-fluid">
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Detail Pola Pelaksanaan</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pola-pelaksanaan.index') }}">Pola Pelaksanaan</a></li>
                <li class="breadcrumb-item">Detail</li>
            </ul>
        </div>
        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                    <a href="{{ route('pola-pelaksanaan.edit', $item->id_pelaksanaan) }}" class="btn btn-md btn-warning">
                        <i class="feather-edit me-2"></i>
                        <span>Edit</span>
                    </a>
                    <a href="{{ route('pola-pelaksanaan.index') }}" class="btn btn-md btn-secondary">
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
                    <h6 class="mb-0">Informasi Pola Pelaksanaan</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">Nama Pola</th>
                                <td>{{ $item->nama }}</td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td>{{ $item->created_at ? $item->created_at->format('d F Y H:i') : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
