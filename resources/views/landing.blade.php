<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RKPDesa - Sistem Informasi Manajemen Desa</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #4b3bdb;
            --primary-light: #6a5ce5;
            --primary-dark: #3728a3;
            --bg-color: #f8f9fc;
            --text-dark: #1e293b;
            --text-light: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Navbar */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            padding: 15px 0;
            transition: all 0.3s ease;
        }
        
        .navbar-brand img {
            height: 45px;
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover img {
            transform: scale(1.05);
        }
        
        .btn-login {
            background-color: var(--primary);
            color: white;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            border: 2px solid var(--primary);
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background-color: transparent;
            color: var(--primary);
        }

        /* Hero Section */
        .hero-section {
            padding: 140px 0 80px;
            position: relative;
            background: linear-gradient(135deg, #f8f9fc 0%, #eef1f8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            color: var(--text-dark);
        }
        
        .hero-title span {
            color: var(--primary);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .hero-image {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(75, 59, 219, 0.15);
            animation: float 6s ease-in-out infinite;
            position: relative;
            z-index: 2;
        }

        /* Decorative blobs */
        .blob-1 {
            position: absolute;
            top: 5%;
            right: 5%;
            width: 300px;
            height: 300px;
            background: rgba(75, 59, 219, 0.1);
            border-radius: 50%;
            filter: blur(40px);
            z-index: 1;
        }

        .blob-2 {
            position: absolute;
            bottom: 10%;
            left: 5%;
            width: 250px;
            height: 250px;
            background: rgba(40, 167, 69, 0.1);
            border-radius: 50%;
            filter: blur(40px);
            z-index: 1;
        }

        /* Floating Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* Feature Cards */
        .features-section {
            padding: 100px 0;
            background-color: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 15px;
        }

        .section-subtitle {
            text-align: center;
            color: var(--text-light);
            margin-bottom: 60px;
            font-size: 1.1rem;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 40px rgba(75, 59, 219, 0.1);
            border-color: rgba(75, 59, 219, 0.2);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: rgba(75, 59, 219, 0.1);
            color: var(--primary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 25px;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            background: var(--primary);
            color: white;
            transform: rotate(10deg);
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .feature-desc {
            color: var(--text-light);
            line-height: 1.6;
        }

        /* About Section */
        .about-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #4b3bdb 0%, #3728a3 100%);
            color: white;
        }

        .about-content {
            font-size: 1.15rem;
            line-height: 1.8;
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            background: #1e293b;
            color: white;
            padding: 40px 0 20px;
            text-align: center;
        }
        
        .footer p {
            margin: 0;
            color: #94a3b8;
            font-size: 0.9rem;
        }

        /* Custom Buttons */
        .btn-custom {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(75, 59, 219, 0.2);
        }
        
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(75, 59, 219, 0.3);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-section {
                padding: 120px 0 60px;
                text-align: center;
            }
            .hero-image-wrapper {
                margin-top: 40px;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('admin-template/assets/images/Logo Sipdes 2 Persegi.png') }}" alt="RKPDesa Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link fw-semibold" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item me-4">
                        <a class="nav-link fw-semibold" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/login" class="btn btn-login text-decoration-none">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Login Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="blob-1"></div>
        <div class="blob-2"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill fw-semibold border border-primary border-opacity-25">
                        <i class="bi bi-stars me-1"></i> Sistem Terpadu
                    </span>
                    <h1 class="hero-title">
                        Digitalisasi <br>
                        <span>Rencana Kerja</span><br>
                        Pemerintah Desa
                    </h1>
                    <p class="hero-subtitle">
                        Platform inovatif untuk menyusun, mengelola, dan memantau usulan serta perencanaan pembangunan desa secara transparan, efektif, dan partisipatif.
                    </p>
                    <div class="d-flex gap-3 justify-content-lg-start justify-content-center">
                        <a href="/admin/login" class="btn btn-primary btn-custom">
                            Mulai Sekarang <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#tentang" class="btn btn-light btn-custom text-primary border" style="box-shadow: none;">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center hero-image-wrapper">
                    <!-- Ilustrasi Generated -->
                    <img src="{{ asset('images/hero_illustration.png') }}" alt="Ilustrasi RKPDesa" class="hero-image img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Section -->
    <section id="fitur" class="features-section">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <p class="section-subtitle">Mengapa menggunakan Sistem Informasi RKPDesa?</p>
            
            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-folder-check"></i>
                        </div>
                        <h3 class="feature-title">Manajemen Data Terpusat</h3>
                        <p class="feature-desc">Seluruh data usulan Musdus dan Musrenbang tersimpan rapi dalam satu database yang aman dan mudah diakses kapan saja.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-diagram-3"></i>
                        </div>
                        <h3 class="feature-title">Sinergi Antar Dusun</h3>
                        <p class="feature-desc">Memudahkan koordinasi dan validasi usulan antara dusun, desa, hingga persetujuan BPD secara sistematis.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </div>
                        <h3 class="feature-title">Cetak Dokumen Otomatis</h3>
                        <p class="feature-desc">Sistem dapat langsung mencetak Berita Acara (PDF) lengkap dengan daftar hadir dan tanda tangan pihak terkait.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="about-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="mb-4 fw-bold">Tentang RKPDesa</h2>
                    <p class="about-content">
                        <strong>Rencana Kerja Pemerintah Desa (RKPDesa)</strong> adalah dokumen perencanaan tahunan yang memuat penjabaran dari Rencana Pembangunan Jangka Menengah Desa (RPJMDesa). 
                        Melalui platform digital ini, kami berkomitmen untuk meningkatkan kualitas tata kelola pemerintahan desa yang partisipatif, transparan, dan akuntabel. Aplikasi ini memfasilitasi seluruh alur dari Musyawarah Dusun (Musdus), Musyawarah Perencanaan Pembangunan (Musrenbang), hingga penetapan bersama Badan Permusyawaratan Desa (BPD).
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <img src="{{ asset('admin-template/assets/images/Logo Sipdes 2 Persegi.png') }}" alt="Logo" height="40" class="mb-3 opacity-75">
            <p>&copy; {{ date('Y') }} Sistem Informasi Manajemen RKPDesa. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Navbar Scroll Effect Script -->
    <script>
        window.addEventListener('scroll', function() {
            var navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 5px 20px rgba(0,0,0,0.1)';
                navbar.style.padding = '10px 0';
            } else {
                navbar.style.boxShadow = '0 2px 15px rgba(0,0,0,0.05)';
                navbar.style.padding = '15px 0';
            }
        });
    </script>
</body>
</html>
