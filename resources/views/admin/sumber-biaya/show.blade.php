@extends('admin.layout')

@section('title', 'Detail Sumber Dana')

@section('content')
@php
    $item = $sumberBiaya ?? $sumber_biaya ?? null;
@endphp
<div class="container-fluid">
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Detail Sumber Dana</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sumber-biaya.index') }}">Sumber Dana</a></li>
                <li class="breadcrumb-item">Detail</li>
            </ul>
        </div>
        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                    <a href="{{ route('sumber-biaya.edit', $item->id_biaya) }}" class="btn btn-md btn-warning">
                        <i class="feather-edit me-2"></i>
                        <span>Edit</span>
                    </a>
                    <a href="{{ route('sumber-biaya.index') }}" class="btn btn-md btn-secondary">
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
                    <h6 class="mb-0">Informasi Sumber Dana</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">Kode</th>
                                <td>{{ $item->kode }}</td>
                            </tr>
                            <tr>
                                <th>Nama Sumber Dana</th>
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
