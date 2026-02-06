{{-- Ini adalah template untuk halaman dengan konten kosong --}}
@extends('admin.layout')

@section('title', $title ?? 'Halaman')

@section('content')
    <div class="container-fluid">
        <!--! [Start] Content Header !-->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="mb-0">{{ $title ?? 'Halaman Kosong' }}</h2>
                    @isset($action_button)
                        {!! $action_button !!}
                    @endisset
                </div>
            </div>
        </div>
        <!--! [End] Content Header !-->

        <!--! [Start] Main Card !-->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <!--! [Start] Card Header !-->
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">{{ $subtitle ?? 'Konten' }}</h6>
                    </div>
                    <!--! [End] Card Header !-->

                    <!--! [Start] Card Body !-->
                    <div class="card-body p-4">
                        {{-- Konten akan dimasukkan di sini --}}
                        @isset($content)
                            {!! $content !!}
                        @else
                            <div class="alert alert-info" role="alert">
                                <i class="feather-info me-2"></i>
                                Konten halaman ini sedang dalam pengembangan.
                            </div>
                        @endisset
                    </div>
                    <!--! [End] Card Body !-->
                </div>
            </div>
        </div>
        <!--! [End] Main Card !-->
    </div>
@endsection
