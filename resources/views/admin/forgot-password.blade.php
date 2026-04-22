<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lupa Password - RKP Desa</title>
    
    <!--! Favicon !-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin-template/assets/images/Logo Sipdes 2 Persegi.png') }}" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!--! Bootstrap CSS !-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-template/assets/css/bootstrap.min.css') }}" />

    <!--! Feather Icons !-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-template/assets/vendors/css/vendors.min.css') }}" />

    <style>
        :root {
            --primary-color: #4b3bdb;
            --primary-dark: #3728a3;
            --bg-color: #f8f9fc;
            --wa-color: #25D366;
            --wa-dark: #128C7E;
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

        /* Help Center Styling */
        .help-icon-wrapper {
            width: 80px;
            height: 80px;
            background-color: rgba(75, 59, 219, 0.1);
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .help-icon-wrapper i {
            font-size: 2.5rem;
        }

        .help-text {
            color: #64748b;
            line-height: 1.7;
            font-size: 1.05rem;
        }

        .btn-wa {
            background-color: var(--wa-color);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 14px 20px;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(37, 211, 102, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-wa:hover {
            background-color: var(--wa-dark);
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(37, 211, 102, 0.3);
            color: white;
        }

        .btn-wa i {
            margin-right: 8px;
            font-size: 1.3rem;
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
                <div class="login-wrapper text-center">
                    
                    <a href="/">
                        <img src="{{ asset('admin-template/assets/images/Logo Sipdes 3.png') }}" alt="SIPDES Logo" class="mb-4" style="height: 50px;">
                    </a>

                    <div class="help-icon-wrapper">
                        <i class="feather-shield"></i>
                    </div>

                    <h3 class="fw-bold text-dark mb-3">Lupa Password?</h3>
                    <p class="help-text mb-4">
                        Demi menjaga keamanan data sistem desa, pemulihan akun dan reset password hanya dapat dilakukan melalui konfirmasi langsung kepada <strong>Admin Website</strong>.
                    </p>
                    
                    <p class="text-muted mb-4 fs-6">
                        Silakan hubungi admin melalui WhatsApp untuk mendapatkan bantuan akses kembali ke akun Anda.
                    </p>

                    <div class="d-grid mb-5">
                        <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="btn btn-wa w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle me-2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            Hubungi Admin via WA
                        </a>
                    </div>
                    
                    <div>
                        <a href="{{ route('admin.login') }}" class="text-muted text-decoration-none hover-primary fw-medium">
                            <i class="feather-arrow-left me-1"></i> Kembali ke Halaman Login
                        </a>
                    </div>
                    
                    <div class="text-center mt-5 text-muted" style="font-size: 0.85rem;">
                        &copy; {{ date('Y') }} RKP Desa. All rights reserved.
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!--! Script: Vendors !-->
    <script src="{{ asset('admin-template/assets/vendors/js/vendors.min.js') }}"></script>
    
</body>

</html>
