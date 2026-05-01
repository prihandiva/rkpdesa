@extends('admin.layout')

@section('title', 'Pemulihan Data')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10 fw-bold text-dark">Pemulihan Data (Trash)</h5>
            </div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Pemulihan Data</li>
            </ul>
        </div>
    </div>




    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom p-0">
                    <ul class="nav nav-tabs pemulihan-tabs border-bottom-0 mb-0 d-flex flex-nowrap overflow-auto" id="pemulihanTabs" role="tablist" style="padding: 0 1rem;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="rpjm-tab" data-bs-toggle="tab" data-bs-target="#rpjm" type="button" role="tab" aria-controls="rpjm" aria-selected="true">
                                <i class="feather-file-text me-2"></i>RPJM Desa 
                                <span class="badge bg-light-primary text-primary ms-1 rounded-pill">{{ $trashedRpjm->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="usulan-tab" data-bs-toggle="tab" data-bs-target="#usulan" type="button" role="tab" aria-controls="usulan" aria-selected="false">
                                <i class="feather-edit-2 me-2"></i>Usulan
                                <span class="badge bg-light-primary text-primary ms-1 rounded-pill">{{ $trashedUsulan->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="rkpdesa-tab" data-bs-toggle="tab" data-bs-target="#rkpdesa" type="button" role="tab" aria-controls="rkpdesa" aria-selected="false">
                                <i class="feather-file me-2"></i>RKP Desa
                                <span class="badge bg-light-primary text-primary ms-1 rounded-pill">{{ $trashedRkpdesa->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="beritaacara-tab" data-bs-toggle="tab" data-bs-target="#beritaacara" type="button" role="tab" aria-controls="beritaacara" aria-selected="false">
                                <i class="feather-book-open me-2"></i>Berita Acara
                                <span class="badge bg-light-primary text-primary ms-1 rounded-pill">{{ $trashedBeritaAcara->count() }}</span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content" id="pemulihanTabsContent">
                        
                        <!-- TAB RPJM -->
                        <div class="tab-pane fade show active" id="rpjm" role="tabpanel" aria-labelledby="rpjm-tab">
                            @include('admin.pemulihan.partials.table', ['items' => $trashedRpjm, 'modelType' => 'rpjm', 'idField' => 'id_rpjm', 'nameField' => 'jenis_kegiatan'])
                        </div>
                        
                        <!-- TAB Usulan -->
                        <div class="tab-pane fade" id="usulan" role="tabpanel" aria-labelledby="usulan-tab">
                            @include('admin.pemulihan.partials.table', ['items' => $trashedUsulan, 'modelType' => 'usulan', 'idField' => 'id_usulan', 'nameField' => 'jenis_kegiatan'])
                        </div>
                        
                        <!-- TAB RKPDesa -->
                        <div class="tab-pane fade" id="rkpdesa" role="tabpanel" aria-labelledby="rkpdesa-tab">
                            @include('admin.pemulihan.partials.table', ['items' => $trashedRkpdesa, 'modelType' => 'rkpdesa', 'idField' => 'id_kegiatan', 'nameField' => 'jenis_kegiatan'])
                        </div>
                        
                        <!-- TAB Berita Acara -->
                        <div class="tab-pane fade" id="beritaacara" role="tabpanel" aria-labelledby="beritaacara-tab">
                            @include('admin.pemulihan.partials.table', ['items' => $trashedBeritaAcara, 'modelType' => 'beritaacara', 'idField' => 'id_ba', 'nameField' => 'nama_kegiatan'])
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="bulkActionForm" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="_method" id="bulkMethod" value="POST">
    <input type="hidden" name="model" id="bulkModel" value="">
    <div id="bulkIdsContainer"></div>
</form>

@endsection

@push('scripts')
<script>
    function toggleSelectAll(source, model) {
        const checkboxes = document.querySelectorAll('.checkbox-' + model);
        checkboxes.forEach(cb => cb.checked = source.checked);
    }

    function submitBulkAction(action, model) {
        const checkboxes = document.querySelectorAll('.checkbox-' + model + ':checked');
        if (checkboxes.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pilih setidaknya satu data terlebih dahulu.',
                confirmButtonColor: '#4b3bdb'
            });
            return;
        }

        let isRestore = action === 'restore';
        let confirmMsg = isRestore 
            ? 'Apakah Anda yakin ingin memulihkan ' + checkboxes.length + ' data terpilih?' 
            : 'Apakah Anda yakin ingin menghapus PERMANEN ' + checkboxes.length + ' data terpilih? Data tidak dapat dikembalikan.';
        
        Swal.fire({
            title: isRestore ? 'Pulihkan Data?' : 'Hapus Permanen?',
            text: confirmMsg,
            icon: isRestore ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonColor: isRestore ? '#28a745' : '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: isRestore ? 'Ya, Pulihkan!' : 'Ya, Hapus Permanen!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('bulkActionForm');
                const idsContainer = document.getElementById('bulkIdsContainer');
                const methodInput = document.getElementById('bulkMethod');
                
                idsContainer.innerHTML = '';
                document.getElementById('bulkModel').value = model;

                if (action === 'restore') {
                    form.action = "{{ route('pemulihan.restore') }}";
                    methodInput.value = 'POST';
                } else {
                    form.action = "{{ route('pemulihan.force_delete') }}";
                    methodInput.value = 'DELETE';
                }

                checkboxes.forEach(cb => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = cb.value;
                    idsContainer.appendChild(input);
                });

                Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

        form.submit();
            }
        });
    }

    // Individual restore confirmation
    function swalRestore(btn, dataName) {
        let form = btn.closest('form');
        Swal.fire({
            title: 'Pulihkan Data?',
            text: 'Pulihkan "' + dataName + '" ke halaman utama?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Pulihkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Memulihkan...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                form.submit();
            }
        });
    }

    // Individual permanent delete — override global interceptor for no-swal DELETE forms in pemulihan
    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('submit', function(e) {
            let form = e.target;
            if (!form || !form.classList.contains('no-swal')) return;
            if (!form.querySelector('input[name="_method"][value="DELETE"]')) return;

            e.preventDefault();
            let dataName = form.getAttribute('data-name') || 'data ini';

            Swal.fire({
                title: 'Hapus Permanen?',
                html: 'Data <strong>"' + dataName + '"</strong> akan dihapus secara permanen.<br><small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus Permanen!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Menghapus...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                    form.submit();
                }
            });
        }, true); // capture phase so it runs before layout.blade global handler
    });
</script>

<style>
    .pemulihan-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 3px solid transparent;
        border-radius: 0;
        padding: 1rem 1.2rem;
        background: transparent;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }
    .pemulihan-tabs .nav-link:hover {
        color: var(--primary-color);
    }
    .pemulihan-tabs .nav-link.active {
        color: var(--primary-color);
        border-bottom: 3px solid var(--primary-color);
        background: transparent;
    }
</style>
@endpush
