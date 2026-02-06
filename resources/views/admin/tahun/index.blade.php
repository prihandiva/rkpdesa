@extends('admin.layout')

@section('title', 'Manajemen Tahun')

@section('content')
    <div class="container-fluid">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Manajemen Tahun</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Tahun</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            <button type="button" class="btn btn-md btn-primary" data-bs-toggle="modal" data-bs-target="#tahunModal">
                                <i class="feather-plus me-2"></i>
                                <span>Tambah Tahun</span>
                            </button>
                        </div>
                    </div>
                    <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="feather-align-right fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Daftar Tahun</h6>
                    </div>
                    <div class="card-body p-0">
                        <!--! [Start] Table Responsive !-->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Tahun</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tahuns as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->tahun }}</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status-toggle" type="checkbox" role="switch" 
                                                        id="statusSwitch{{ $item->id_tahun }}" 
                                                        data-id="{{ $item->id_tahun }}"
                                                        {{ strtolower($item->status) == 'aktif' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="statusSwitch{{ $item->id_tahun }}">
                                                        {{ ucfirst($item->status) }}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>{{ $item->keterangan ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('tahun.show', $item->id_tahun) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="feather-eye"></i>
                                                    </a>
                                                    <a href="{{ route('tahun.edit', $item->id_tahun) }}"
                                                        class="btn btn-sm btn-outline-warning">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <form action="{{ route('tahun.destroy', $item->id_tahun) }}" method="POST"
                                                        class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="feather-trash-2"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="alert alert-light mb-0" role="alert">
                                                    <i class="feather-inbox me-2"></i>Belum ada data tahun
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!--! [End] Table Responsive !-->
                    </div>
                    <!--! [End] Card Body !-->
                </div>
            </div>
        </div>
        <!--! [End] Main Content Card !-->
    </div>

    <!--! [Start] Modal Tambah/Edit Tahun !-->
    <div class="modal fade" id="tahunModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tahun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="tahun" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" rows="3" name="keterangan"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--! [End] Modal Tambah/Edit Tahun !-->

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('.status-toggle');
            
            toggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const id = this.getAttribute('data-id');
                    const isChecked = this.checked;
                    const statusLabel = this.nextElementSibling;
                    const newStatus = isChecked ? 'aktif' : 'nonaktif';
                    
                    // Optimistic update
                    statusLabel.textContent = isChecked ? 'Aktif' : 'Nonaktif';

                    fetch(`/admin/tahun/${id}/status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ status: newStatus })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success toast (optional)
                            console.log(data.message);
                        } else {
                            // Revert on failure
                            this.checked = !isChecked;
                            statusLabel.textContent = !isChecked ? 'Aktif' : 'Nonaktif';
                            alert('Gagal memperbarui status');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Revert on error
                        this.checked = !isChecked;
                        statusLabel.textContent = !isChecked ? 'Aktif' : 'Nonaktif';
                        alert('Terjadi kesalahan jaringan');
                    });
                });
            });
        });
    </script>
    @endpush
@endsection
