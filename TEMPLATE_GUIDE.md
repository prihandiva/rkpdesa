# Panduan Template Admin Duralux - RKP Desa

## 📋 Struktur Template

Template admin telah dipersiapkan dengan menggunakan **Duralux Admin Template** yang responsif dan modern.

### 📁 Struktur File

```
resources/views/admin/
├── layout.blade.php                 # Master layout utama
├── dashboard.blade.php              # Halaman dashboard
├── auth_layout.blade.php            # Layout untuk halaman auth
├── login.blade.php                  # Halaman login
├── partials/
│   ├── header.blade.php             # Komponen header
│   ├── sidebar.blade.php            # Komponen sidebar navigation
│   ├── footer.blade.php             # Komponen footer
│   └── card-empty-template.blade.php # Template card kosong
├── usulan/
│   ├── index.blade.php              # Daftar usulan
│   └── tambah.blade.php             # Form tambah usulan
├── rpjmdesa/
│   ├── index.blade.php              # Daftar RPJM
│   └── tambah.blade.php             # Form tambah RPJM
├── rkpdesa/
│   ├── index.blade.php              # Daftar RKP
│   └── tambah.blade.php             # Form tambah RKP
├── tahun/                           # Folder untuk halaman tahun
├── users/                           # Folder untuk halaman users
└── profil/                          # Folder untuk halaman profil
```

## 🎨 Komponen Utama

### 1. **Header** (`partials/header.blade.php`)

- Mobile hamburger menu
- Sidebar toggle button
- Search bar
- Notification bell
- User profile dropdown

### 2. **Sidebar** (`partials/sidebar.blade.php`)

- Logo brand
- Navigation menu dengan submenu
- Menu items untuk Dashboard, Usulan, RPJM, RKP
- Responsive collapse pada mobile
- Mini sidebar toggle untuk desktop

### 3. **Footer** (`partials/footer.blade.php`)

- Copyright information
- Links atau info tambahan

### 4. **Main Layout** (`layout.blade.php`)

- Struktur full responsive
- Include semua CSS dan JS Duralux
- Breadcrumb navigation
- Content wrapper

## 🚀 Cara Menggunakan

### Membuat Halaman Baru

1. **Extend Layout**

```blade
@extends('admin.layout')

@section('title', 'Nama Halaman')

@section('content')
    <div class="container-fluid">
        <!-- Konten halaman Anda -->
    </div>
@endsection
```

2. **Struktur Halaman List**

```blade
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h6 class="mb-0">Judul Tabel</h6>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Column 1</th>
                        <th>Column 2</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rows -->
                </tbody>
            </table>
        </div>
    </div>
</div>
```

3. **Struktur Form**

```blade
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h6 class="mb-0">Judul Form</h6>
    </div>

    <div class="card-body p-4">
        <form method="POST" action="{{ route('..') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Label <span class="text-danger">*</span></label>
                <input type="text" class="form-control" required>
            </div>

            <div class="d-flex gap-2 justify-content-between">
                <a href="#" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
```

## 📱 Responsive Design

Template ini fully responsive untuk:

- **Desktop**: Sidebar penuh dengan navigation lengkap
- **Tablet**: Sidebar dapat di-collapse dengan toggle button
- **Mobile**: Sidebar menjadi overlay/drawer yang dapat dibuka/tutup

### Breakpoints

- **< 768px**: Extra Small (xs)
- **768px - 991px**: Small (sm) - Tablet
- **992px+**: Large (lg) - Desktop

## 🎨 Styling & CSS

### Warna Utama (CSS Variables)

```css
--primary-color: #4b3bdb;
--secondary-color: #6c757d;
--success-color: #28a745;
--danger-color: #dc3545;
--warning-color: #ffc107;
--info-color: #17a2b8;
```

### Class Utilities

- `card`: Card container utama
- `card-header`: Header card dengan background abu-abu
- `card-body`: Body dengan padding standar
- `table-hover`: Table dengan hover effect
- `btn-primary`, `btn-secondary`, dll: Buttons dengan styling Duralux

## 🔧 Assets Duralux

### CSS Files

```
admin-template/assets/css/
├── bootstrap.min.css          # Bootstrap 5
├── theme.min.css              # Duralux custom theme
└── vendors.min.css            # Vendor CSS (Feather icons, dll)
```

### JS Files

```
admin-template/assets/js/
├── common-init.min.js         # Common initialization
├── dashboard-init.min.js      # Dashboard specific
└── theme-customizer-init.min.js # Theme customizer
```

### Fonts & Icons

- **Font**: Inter, Lato, Rubik, Poppins (pilihan di customizer)
- **Icons**: Feather Icons (semua menggunakan class `feather-*`)

## 📝 Icons yang Sering Digunakan

```blade
<!-- Dashboard -->
<i class="feather-airplay"></i>

<!-- Usulan -->
<i class="feather-edit-2"></i>

<!-- RPJM -->
<i class="feather-file-text"></i>

<!-- RKP -->
<i class="feather-send"></i>

<!-- Tahun/Calendar -->
<i class="feather-calendar"></i>

<!-- Users -->
<i class="feather-users"></i>

<!-- Settings -->
<i class="feather-settings"></i>

<!-- Plus (Tambah) -->
<i class="feather-plus"></i>

<!-- Edit -->
<i class="feather-edit"></i>

<!-- Delete -->
<i class="feather-trash-2"></i>

<!-- View -->
<i class="feather-eye"></i>
```

## 🔐 Authentication

User dropdown di header menampilkan:

- Profile
- Settings
- Sign Out

Logout menggunakan route:

```php
{{ route('logout') }}
```

## 📊 Pagination

Template sudah memiliki struktur pagination Bootstrap 5:

```blade
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
            <a class="page-link" href="#">Previous</a>
        </li>
        <li class="page-item active">
            <a class="page-link" href="#">1</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="#">Next</a>
        </li>
    </ul>
</nav>
```

## 🌙 Customization

Template mendukung multiple skin/theme:

- Light/Dark Mode
- Different color schemes
- Font family options (Lato, Rubik, Inter, Poppins, dll)

Lihat file `partials/customizer.html` di Duralux template untuk opsi lanjutan.

## ✅ Checklist untuk Halaman Baru

- [ ] Extend `admin.layout`
- [ ] Set title dengan `@section('title')`
- [ ] Gunakan `container-fluid` sebagai wrapper utama
- [ ] Buat page header dengan title dan action buttons
- [ ] Wrap content dalam `card` dengan class `border-0 shadow-sm`
- [ ] Gunakan table-responsive untuk tabel
- [ ] Ensure mobile responsiveness dengan Bootstrap grid
- [ ] Use consistent spacing: `mb-3`, `mb-4`, `gap-2`, dll
- [ ] Use Feather icons untuk visual consistency

## 📞 Support

Untuk pertanyaan atau modifikasi lebih lanjut, silakan update file-file tersebut sesuai kebutuhan aplikasi RKP Desa.

---

**Last Updated**: February 2, 2026  
**Template**: Duralux Admin v1.0.0  
**Framework**: Laravel Blade + Bootstrap 5
