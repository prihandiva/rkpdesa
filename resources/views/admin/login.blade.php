<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - RKP Desa</title>
    
    <!--! Favicon !-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin-template/assets/images/Logo Sipdes 2 Persegi.png') }}" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!--! Bootstrap CSS !-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-template/assets/css/bootstrap.min.css') }}" />

    <!--! SweetAlert2 !-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!--! Feather Icons !-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-template/assets/vendors/css/vendors.min.css') }}" />

    <style>
        :root {
            --primary-color: #4b3bdb;
            --primary-dark: #3728a3;
            --bg-color: #f8f9fc;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
        }

        .split-layout {
            height: 100vh;
        }

        /* Left Side (Visual Branding) */
        .brand-panel {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem;
        }

        /* Decorative background elements */
        .brand-panel::before {
            content: '';
            position: absolute;
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            filter: blur(50px);
        }

        .brand-panel::after {
            content: '';
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            filter: blur(40px);
        }

        .floating-img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            animation: float 6s ease-in-out infinite;
            z-index: 2;
            margin-top: 2rem;
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.2));
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .brand-title {
            font-size: 2.8rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
            z-index: 2;
        }

        .brand-subtitle {
            font-size: 1.1rem;
            opacity: 0.85;
            z-index: 2;
        }

        /* Right Side (Form) */
        .form-panel {
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        /* Form Controls styling */
        .form-floating > .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            height: calc(3.8rem);
            padding-left: 1.25rem;
            padding-right: 1.25rem;
            font-size: 1.05rem;
            color: #334155;
            transition: all 0.3s ease;
            box-shadow: none !important;
        }

        .form-floating > label {
            padding-left: 1.25rem;
            padding-right: 1.25rem;
            color: #94a3b8;
            font-weight: 500;
        }

        .form-floating > .form-control:focus {
            border-color: var(--primary-color);
            background-color: #f8faff;
        }

        .form-floating > .form-control:not(:placeholder-shown) ~ label,
        .form-floating > .form-control:focus ~ label {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Toggle Password Button */
        .toggle-password-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            z-index: 5;
            padding: 10px;
            transition: color 0.3s;
        }

        .toggle-password-btn:hover {
            color: var(--primary-color);
        }

        .btn-login {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 14px 20px;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(75, 59, 219, 0.2);
        }

        .btn-login:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(75, 59, 219, 0.3);
            color: white;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .link-primary {
            color: var(--primary-color) !important;
            font-weight: 600;
            transition: opacity 0.3s;
        }

        .link-primary:hover {
            opacity: 0.8;
            text-decoration: underline !important;
        }
        
        .alert-custom {
            border-radius: 12px;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid h-100 p-0">
        <div class="row g-0 split-layout">
            
            <!-- Left Side Branding (Hidden on mobile) -->
            <div class="col-lg-6 d-none d-lg-flex brand-panel text-center">
                <h1 class="brand-title">Sistem Informasi<br>Pembangunan Desa</h1>
                <p class="brand-subtitle">Kelola Usulan dan Rencana Kerja Desa Lebih Mudah, Cepat, dan Transparan.</p>
                <img src="{{ asset('images/login_illustration.png') }}" alt="Ilustrasi Data Desa" class="img-fluid floating-img" style="max-width: 80%;">
            </div>

            <!-- Right Side Form -->
            <div class="col-12 col-lg-6 form-panel">
                <div class="login-wrapper">
                    
                    <div class="text-center mb-5">
                        <a href="/">
                            <img src="{{ asset('admin-template/assets/images/Logo Sipdes 3.png') }}" alt="SIPDES Logo" class="mb-4" style="height: 65px;">
                        </a>
                        <h3 class="fw-bold text-dark">Selamat Datang Kembali</h3>
                        <p class="text-muted">Silakan masukkan kredensial Anda untuk melanjutkan</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="feather-alert-circle me-2 fs-5"></i>
                                <div>
                                    @foreach ($errors->all() as $error)
                                        <div class="fw-medium">{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="feather-check-circle me-2 fs-5"></i>
                                <div class="fw-medium">{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.login.submit') }}" method="POST">
                        @csrf
                        
                        <!-- Floating Input: Email/Username -->
                        <div class="form-floating mb-4 position-relative">
                            <input type="text" class="form-control" id="login" name="login" value="{{ old('login') }}" placeholder="Masukkan email atau username" required autofocus>
                            <label for="login">Email atau Username</label>
                        </div>

                        <!-- Floating Input: Password -->
                        <div class="form-floating mb-4 position-relative">
                            <input type="password" class="form-control pe-5" id="password" name="password" placeholder="Masukkan password" required>
                            <label for="password">Password</label>
                            <!-- Password Toggle Icon -->
                            <button class="toggle-password-btn" type="button" id="togglePassword" aria-label="Toggle password visibility">
                                <i class="feather-eye fs-5"></i>
                            </button>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-5 px-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label text-muted" for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                            <a href="{{ route('admin.forgot-password') }}" class="link-primary text-decoration-none">Lupa Password?</a>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-login w-100 text-uppercase">
                                LOGIN
                            </button>
                        </div>
                        
                        <div class="text-center">
                            <a href="/" class="text-muted text-decoration-none hover-primary">
                                <i class="feather-arrow-left me-1"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </form>
                    
                    <div class="text-center mt-5 text-muted" style="font-size: 0.85rem;">
                        &copy; {{ date('Y') }} RKP Desa. All rights reserved.
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!--! Script: Vendors !-->
    <script src="{{ asset('admin-template/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password Visibility Toggle
            const togglePasswordBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const toggleIcon = togglePasswordBtn.querySelector('i');
            
            togglePasswordBtn.addEventListener('click', function (e) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('feather-eye');
                    toggleIcon.classList.add('feather-eye-off');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('feather-eye-off');
                    toggleIcon.classList.add('feather-eye');
                }
            });

            // Session Expired Alert
            @if(session('session_expired'))
            Swal.fire({
                icon: 'warning',
                title: 'Session Habis',
                text: 'Session Anda telah habis, silahkan login kembali.',
                confirmButtonColor: '#4b3bdb',
                confirmButtonText: 'OK'
            });
            @endif

            // Logout Success Alert
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Logout',
                text: '{{ session("success") }}',
                timer: 2500,
                showConfirmButton: false
            });
            @endif
        });
    </script>
</body>

</html>
