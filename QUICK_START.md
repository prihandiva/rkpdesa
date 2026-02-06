# 🚀 QUICK START GUIDE - Template Duralux RKP Desa

## 1️⃣ Setup Awal

### Pastikan Assets Duralux Ada

```bash
# Copy folder Duralux template ke public
public/admin-template/
├── assets/
│   ├── css/
│   │   ├── bootstrap.min.css
│   │   ├── theme.min.css
│   │   └── vendors.min.css
│   ├── js/
│   │   ├── common-init.min.js
│   │   ├── dashboard-init.min.js
│   │   └── theme-customizer-init.min.js
│   ├── vendors/
│   │   ├── css/
│   │   │   ├── vendors.min.css
│   │   │   └── daterangepicker.min.css
│   │   └── js/
│   │       ├── vendors.min.js
│   │       ├── daterangepicker.min.js
│   │       └── apexcharts.min.js
│   └── images/
│       ├── logo-full.png
│       ├── logo-abbr.png
│       └── favicon.ico
```

## 2️⃣ Testing Halaman

### Test di Browser

```bash
# Development server
php artisan serve

# Buka di browser
http://localhost:8000/admin/dashboard
```

## 3️⃣ Membuat Halaman Baru - Template Cepat

### Copy Template Kosong

```blade
@extends('admin.layout')

@section('title', 'Judul Halaman')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0">Judul Halaman</h2>
                <button class="btn btn-primary">
                    <i class="feather-plus me-2"></i>Tambah
                </button>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Subtitle</h6>
                </div>
                <div class="card-body p-4">
                    <!-- Konten -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

## 4️⃣ Struktur Form Cepat

```blade
<!-- Form Card -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h6 class="mb-0">Form Title</h6>
    </div>
    <div class="card-body p-4">
        <form method="POST" action="{{ route('...') }}">
            @csrf

            <!-- Input Group -->
            <div class="mb-3">
                <label class="form-label">Label <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="field" required>
            </div>

            <!-- Select Group -->
            <div class="mb-3">
                <label class="form-label">Select</label>
                <select class="form-select" name="select">
                    <option>-- Pilih --</option>
                </select>
            </div>

            <!-- Textarea -->
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" rows="4"></textarea>
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-2 justify-content-between">
                <a href="#" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
```

## 5️⃣ Struktur Table Cepat

```blade
<!-- Table Card -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h6 class="mb-0">Table Title</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Column 1</th>
                        <th>Column 2</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <i class="feather-inbox me-2"></i>Belum ada data
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
```

## 6️⃣ Icons Populer

```
Dashboard      → feather-airplay
Tambah         → feather-plus
Edit           → feather-edit-2
Delete         → feather-trash-2
View           → feather-eye
Settings       → feather-settings
Users          → feather-users
Calendar       → feather-calendar
File           → feather-file-text
Filter         → feather-filter
Download       → feather-download
Search         → feather-search
Bell           → feather-bell
Logout         → feather-log-out
```

## 7️⃣ Bootstrap Grid Cheat Sheet

```blade
<!-- 2 Column pada Desktop, 1 pada Mobile -->
<div class="row">
    <div class="col-lg-6">...</div>
    <div class="col-lg-6">...</div>
</div>

<!-- 3 Column pada Desktop, 1 pada Mobile -->
<div class="row">
    <div class="col-md-4">...</div>
    <div class="col-md-4">...</div>
    <div class="col-md-4">...</div>
</div>

<!-- 4 Column pada Desktop -->
<div class="row">
    <div class="col-lg-3">...</div>
    <div class="col-lg-3">...</div>
    <div class="col-lg-3">...</div>
    <div class="col-lg-3">...</div>
</div>
```

## 8️⃣ Spacing Utilities

```blade
<!-- Margin Bottom -->
mb-0, mb-1, mb-2, mb-3, mb-4, mb-5

<!-- Margin Top -->
mt-0, mt-1, mt-2, mt-3, mt-4, mt-5

<!-- Padding -->
p-0, p-1, p-2, p-3, p-4, p-5

<!-- Gap (dalam Flexbox) -->
gap-1, gap-2, gap-3, gap-4, gap-5

<!-- Contoh -->
<div class="d-flex gap-2 mb-3">
    <button class="btn btn-primary">Button 1</button>
    <button class="btn btn-secondary">Button 2</button>
</div>
```

## 9️⃣ Responsive Utilities

```blade
<!-- Hide on mobile, show on desktop -->
<div class="d-none d-lg-block">Desktop only</div>

<!-- Show on mobile, hide on desktop -->
<div class="d-block d-lg-none">Mobile only</div>

<!-- Responsive text size -->
<h1 class="fs-1">Extra Large</h1>
<h2 class="fs-2">Very Large</h2>
<h3 class="fs-3">Large</h3>
<p class="fs-12">Small</p>
```

## 🔟 Color Utilities

```blade
<!-- Text Colors -->
<p class="text-primary">Primary</p>
<p class="text-success">Success</p>
<p class="text-danger">Danger</p>
<p class="text-warning">Warning</p>
<p class="text-info">Info</p>
<p class="text-muted">Muted</p>

<!-- Background Colors -->
<div class="bg-primary">Primary Background</div>
<div class="bg-light">Light Background</div>
<div class="bg-dark">Dark Background</div>

<!-- Badge -->
<span class="badge bg-primary">Primary</span>
<span class="badge bg-success">Success</span>
```

## 1️⃣1️⃣ Modal Quick Template

```blade
<!-- Button Trigger -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Open Modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Form content here
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
```

## 1️⃣2️⃣ Alert Quick Template

```blade
<!-- Info Alert -->
<div class="alert alert-info" role="alert">
    <i class="feather-info me-2"></i>
    This is an info alert
</div>

<!-- Success Alert -->
<div class="alert alert-success" role="alert">
    <i class="feather-check-circle me-2"></i>
    Success message
</div>

<!-- Danger Alert -->
<div class="alert alert-danger" role="alert">
    <i class="feather-alert-circle me-2"></i>
    Error message
</div>

<!-- Warning Alert -->
<div class="alert alert-warning" role="alert">
    <i class="feather-alert-triangle me-2"></i>
    Warning message
</div>
```

## 1️⃣3️⃣ Common Mistakes ❌

```blade
❌ SALAH - Tidak wrap dalam container-fluid
<table class="table">...</table>

✅ BENAR - Wrap dengan card
<div class="card">
    <div class="card-body p-0">
        <table class="table">...</table>
    </div>
</div>

❌ SALAH - Tidak responsive
<div class="row">
    <div class="col-4">Wide on all devices</div>
</div>

✅ BENAR - Responsive
<div class="row">
    <div class="col-lg-4 col-12">Auto width on mobile</div>
</div>

❌ SALAH - Button terlalu kecil di mobile
<button class="btn btn-sm">Small</button>

✅ BENAR - Touch-friendly
<button class="btn btn-primary">Normal</button>
```

## 1️⃣4️⃣ Debugging Tips 🔍

```bash
# Check console di browser (F12)
# Pastikan tidak ada error di Console tab

# Check Responsive Design (F12 > Toggle device toolbar)
# Test di mobile, tablet, desktop

# Check CSS loading (F12 > Network tab)
# Pastikan semua CSS & JS loaded successfully

# Check HTML structure (F12 > Inspector)
# Pastikan classes benar (container-fluid, card, row, col-*)
```

## 1️⃣5️⃣ Next Steps

1. ✅ Create routes di `routes/web.php`
2. ✅ Create controllers di `app/Http/Controllers/Admin/`
3. ✅ Add database migrations
4. ✅ Implement CRUD operations
5. ✅ Add form validation
6. ✅ Add error handling
7. ✅ Test responsive design
8. ✅ Deploy ke production

---

**Happy Coding! 🚀**

Untuk bantuan lebih lanjut, lihat:

- 📖 TEMPLATE_GUIDE.md
- 📝 IMPLEMENTATION_SUMMARY.md
- 🎨 resources/css/responsive-template.css
