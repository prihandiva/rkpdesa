Panduan Setup Lokal (Laragon / Windows)

1. Pastikan prasyarat
- PHP 8.2+ dan Composer terpasang
- Node.js + npm bila ingin build aset frontend

2. Dari folder proyek (D:\laragon\www\RKPDesa)

```powershell
composer install
copy .env.example .env
rem # (sesuaikan .env: DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
composer dump-autoload
php artisan key:generate
php artisan migrate
npm install
npm run dev
```

3. Menjalankan aplikasi
- Gunakan Laragon (start Apache/Nginx + MySQL) dan buka project di browser
- Atau jalankan: `php artisan serve --host=127.0.0.1 --port=8000`

4. Opsi: Authentication starter (Breeze)

```powershell
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run dev
php artisan migrate
```

Catatan: Pada lingkungan ini saya berhasil men-scaffold Laravel 11, tapi proses `composer install` sempat terinterupsi. Silakan jalankan `composer install` penuh di mesin lokal (Laragon) agar dependensi `vendor/` terunduh, lalu jalankan `php artisan key:generate`.

Jika ingin, saya bisa langsung memasang Breeze untuk autentikasi — mau saya pasang sekarang?
