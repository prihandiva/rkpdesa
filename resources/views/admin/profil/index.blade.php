@extends('admin.layout')

@section('title', 'Profile')

@push('styles')
<style>
    .profile-image-container {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto 2rem;
        cursor: pointer;
    }
    
    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .profile-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .profile-image-container:hover .profile-image-overlay {
        opacity: 1;
    }

    .profile-image-container:hover .profile-image {
        border-color: var(--primary-color);
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom pt-4 pb-3">
                <h5 class="card-title mb-0">Edit Profile</h5>
            </div>
            <div class="card-body p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Profile Image Section -->
                    <div class="profile-image-container" onclick="document.getElementById('profile_image').click()">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="profile-image" id="profile-image-preview">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=random&size=150" alt="Profile Image" class="profile-image" id="profile-image-preview">
                        @endif
                        
                        <div class="profile-image-overlay">
                            <i class="feather-camera text-white fs-2"></i>
                        </div>
                        <input type="file" name="profile_image" id="profile_image" class="d-none" accept="image/*" onchange="previewImage(this)">
                    </div>

                    <div class="row g-4">
                        <!-- Read-only Fields -->
                        <div class="col-md-6">
                            <label for="nama" class="form-label text-muted">Nama</label>
                            <input type="text" class="form-control bg-light" id="nama" value="{{ $user->nama }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label text-muted">Email</label>
                            <input type="email" class="form-control bg-light" id="email" value="{{ $user->email }}" disabled>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="role" class="form-label text-muted">Role</label>
                            <input type="text" class="form-control bg-light text-capitalize" id="role" value="{{ $user->role }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="telp" class="form-label text-muted">Nomor Telepon</label>
                            <input type="text" class="form-control bg-light" id="telp" value="{{ $user->telp ?? '-' }}" disabled>
                        </div>

                        <!-- Editable Fields -->
                         <div class="col-12">
                            <hr class="my-2 text-muted opactiy-25">
                            <h6 class="mb-3 mt-2 text-primary">Informasi Akun</h6>
                        </div>

                        <div class="col-md-12">
                            <label for="username" class="form-label fw-bold">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}">
                            <div class="form-text">Username ini digunakan untuk login. Pastikan unik dan mudah diingat.</div>
                        </div>

                        <!-- Password Section -->
                         <div class="col-12">
                            <hr class="my-2 text-muted opactiy-25">
                            <h6 class="mb-3 mt-2 text-primary">Keamanan</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label fw-bold">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                            <div class="form-text">Kosongkan jika tidak ingin mengubah password.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-5">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="feather-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('profile-image-preview').src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
