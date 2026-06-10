@extends('admin.layout')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="container-fluid">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Manajemen Pengguna</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Pengguna</li>
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
                        <a href="{{ route('user.create') }}" class="btn btn-md btn-primary">
                            <i class="feather-plus me-2"></i>
                            <span>Tambah Pengguna</span>
                        </a>
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

        <!--! [Start] Main Content Card !-->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <!--! [Start] Card Header !-->
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">Daftar Pengguna</h6>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter-btn>
                                <i class="feather-filter me-1"></i>Filter
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-export-btn data-export-name="data_pengguna">
                                <i class="feather-download me-1"></i>Export
                            </button>
                        </div>
                    </div>
                    <!--! [End] Card Header !-->

                    <!--! [Start] Filter Search Row !-->
                    <div class="px-4 py-2 bg-light border-bottom align-items-center gap-2" id="masterFilterRow" style="display:none;">
                        <div class="input-group input-group-sm" style="max-width:400px;">
                            <span class="input-group-text bg-white"><i class="feather-search" style="font-size:13px;"></i></span>
                            <input type="text" class="form-control" id="masterFilterInput" placeholder="Cari nama, username, email, role...">
                            <button class="btn btn-outline-secondary" type="button" id="masterFilterClear" title="Reset">
                                <i class="feather-x" style="font-size:13px;"></i>
                            </button>
                        </div>
                    </div>
                    <!--! [End] Filter Search Row !-->

                    <!--! [Start] Card Body !-->
                    <div class="card-body p-0">
                        <!--! [Start] Table Responsive !-->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="masterTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="masterFilterNoResult" style="display:none;">
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="feather-search me-1"></i>Tidak ada data yang cocok dengan pencarian.
                                        </td>
                                    </tr>
                                    @forelse($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center py-1">
                                                    @if($user->profile_image)
                                                        <div class="rounded-circle me-3 border shadow-sm" style="width: 42px; height: 42px; min-width: 42px; overflow: hidden;">
                                                            <img src="{{ str_starts_with($user->profile_image, 'uploads') ? asset($user->profile_image) : asset('storage/'.$user->profile_image) }}" alt="" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                                        </div>
                                                    @else
                                                        <div class="rounded-circle me-3 bg-light d-flex align-items-center justify-content-center text-primary border" style="width: 42px; height: 42px; min-width: 42px;">
                                                            <i class="feather-user" style="font-size: 16px;"></i>
                                                        </div>
                                                    @endif
                                                    <span class="fw-medium text-dark">{{ $user->nama }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $user->username ?? '-' }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @php
                                                    $roleStyles = [
                                                        'admin' => ['bg' => 'bg-light-danger', 'text' => 'text-danger', 'icon' => 'feather-shield'],
                                                        'operator_dusun' => ['bg' => 'bg-light-primary', 'text' => 'text-primary', 'icon' => 'feather-map-pin'],
                                                        'operator_desa' => ['bg' => 'bg-light-info', 'text' => 'text-info', 'icon' => 'feather-home'],
                                                        'tim_verifikasi' => ['bg' => 'bg-light-warning', 'text' => 'text-warning', 'icon' => 'feather-check-circle'],
                                                        'tim_penyusun' => ['bg' => 'bg-light-secondary', 'text' => 'text-secondary', 'icon' => 'feather-users'],
                                                        'bpd' => ['bg' => 'bg-light-success', 'text' => 'text-success', 'icon' => 'feather-award'],
                                                    ];
                                                    $style = $roleStyles[$user->role] ?? ['bg' => 'bg-light-dark', 'text' => 'text-dark', 'icon' => 'feather-user'];
                                                @endphp
                                                <span class="badge {{ $style['bg'] }} {{ $style['text'] }} rounded-pill px-3 py-2 fw-bold" style="font-size: 11px; letter-spacing: 0.3px; border: 1px solid rgba(0,0,0,0.03);">
                                                    <i class="{{ $style['icon'] }} me-1" style="font-size: 12px;"></i>
                                                    {{ strtoupper(str_replace('_', ' ', $user->role)) }}
                                                </span>
                                            </td>
                                            
                                            <td>
                                                <form action="{{ route('user.toggle_status', $user->id_user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $user->status === 'Aktif' ? 'btn-success' : 'btn-secondary' }} rounded-pill px-3" style="font-size: 11px; font-weight: bold;">
                                                        {{ $user->status === 'Aktif' ? 'Aktif' : 'Nonaktif' }}
                                                    </button>
                                                </form>
                                            </td>

                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('user.show', $user->id_user) }}" 
                                                       class="btn btn-sm btn-outline-info">
                                                        <i class="feather-eye"></i>
                                                    </a>
                                                    <a href="{{ route('user.edit', $user->id_user) }}" 
                                                       class="btn btn-sm btn-outline-warning">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" 
                                                          class="d-inline" data-name="{{ $user->nama }}">
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
                                            <td colspan="6" class="text-center py-5">
                                                <div class="alert alert-light mb-0" role="alert">
                                                    <i class="feather-inbox me-2"></i>Belum ada data pengguna
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

                    <!--! [Start] Card Footer - Pagination !-->
                    <div class="card-footer bg-light border-top">
                        <nav aria-label="Page navigation" class="mb-0">
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="javascript:void(0);">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="javascript:void(0);">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!--! [End] Card Footer - Pagination !-->
                </div>
            </div>
        </div>
        <!--! [End] Main Content Card !-->

        <!--! [Start] Roles Management Card !-->
        <div class="row mt-4 mb-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">Manajemen Role</h6>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                            <i class="feather-plus me-1"></i>Tambah Role
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">ID</th>
                                        <th>Nama Role</th>
                                        <th>Created At</th>
                                        <th style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($roles as $role)
                                        <tr>
                                            <td>{{ $role->id_role }}</td>
                                            <td>
                                                <span class="badge bg-light-secondary text-secondary">
                                                    {{ $role->nama }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d M Y H:i') }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-sm btn-outline-warning"
                                                            onclick="editRole({{ $role->id_role }}, '{{ $role->nama }}')">
                                                        <i class="feather-edit"></i>
                                                    </button>
                                                    <form action="{{ route('user.role.destroy', $role->id_role) }}" method="POST" 
                                                          class="d-inline" data-name="Role: {{ $role->nama }}">
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
                                            <td colspan="4" class="text-center py-4">
                                                Belum ada data role.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--! [End] Roles Management Card !-->
    </div>

    <!-- Create Role Modal -->
    <div class="modal fade" id="createRoleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Role Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('user.role.store') }}" method="POST" class="no-swal">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Role</label>
                            <input type="text" name="nama" class="form-control" required placeholder="Contoh: staff_admin">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div class="modal fade" id="editRoleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editRoleForm" method="POST" class="no-swal">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Role</label>
                            <input type="text" name="nama" id="editRoleNama" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editRole(id, nama) {
            document.getElementById('editRoleNama').value = nama;
            document.getElementById('editRoleForm').action = "{{ url('/admin/user/role') }}/" + id;
            var editModal = new bootstrap.Modal(document.getElementById('editRoleModal'));
            editModal.show();
        }
    </script>

    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
    </style>
@endsection
