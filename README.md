# Project Cegah Banjir

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

---

## 📌 Tentang Proyek

**Cegah Banjir** adalah sistem informasi berbasis web yang dibangun menggunakan **Laravel 12**. Tujuannya adalah untuk memberikan informasi dan visualisasi data terkait:

- Cuaca harian  
- Curah hujan terkini  
- Peta risiko dan prediksi banjir  
- Informasi bencana lokal berbasis lokasi pengguna  

---

## 🚀 Fitur Utama

- ✅ Login dan Registrasi pengguna  
- ✅ Manajemen data cuaca dan hujan  
- ✅ Dashboard admin dan user  
- ✅ Tampilan responsif dan modern  
- ✅ Notifikasi kondisi ekstrem  
- ✅ API internal untuk data cuaca  

---

## ⚙️ Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek secara lokal:

```bash
# 1. Clone project
git clone https://github.com/namakamu/cegah-banjir.git
cd cegah-banjir

# 2. Install backend dependencies
composer install

# 3. Salin file .env dan generate key
cp .env.example .env
php artisan key:generate

# 4. Edit konfigurasi database di file .env sesuai dengan pengaturan lokal Anda

# 5. Jalankan migrasi
php artisan migrate

# 6. Install frontend dependencies dan jalankan Vite
npm install
npm run dev

# 7. Jalankan server lokal
php artisan serve
