# EduSecure LMS - Protected Video Player Engine (Laravel + YouTube Masking)

Proyek ini mendemonstrasikan implementasi **Proteksi Video E-Learning** menggunakan teknik **YouTube Unlisted + Custom Plyr.js Masking + Shield Click Interceptor + Dynamic Watermark**.

Contoh:
Video Target: `https://youtube.com/shorts/gN75MH5Ej4c?feature=share` (ID: `gN75MH5Ej4c`).

---

## 📂 Struktur File Proyek Laravel

```text
elearning-laravel-player/
├── app/
│   └── Http/
│       └── Controllers/
│           └── CourseController.php      <-- Parser YouTube URL & pengelola data materi
├── routes/
│   └── web.php                          <-- Routing /course/{slug}/lesson/{id}
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php             <-- Layout utama dengan CDN Plyr & Font
│       └── course/
│           └── watch.blade.php           <-- Halaman nonton video e-learning
├── public/
│   ├── css/
│   │   └── elearning-player.css          <-- Styling Glassmorphism Dark Theme & Shield
│   ├── js/
│   │   └── elearning-player.js           <-- Logika Plyr, Shield Interceptor & Watermark
│   └── index.html                        <-- Demo interaktif langsung siap uji
└── server.js                             <-- Node.js server untuk preview instan
```

---

## 🚀 Cara Menjalankan Live Demo Langsung

Di terminal, masuk ke folder ini dan jalankan:
```bash
node server.js
```
Lalu buka browser di: **`http://localhost:3000`**

---

## 💡 Cara Integrasi ke Proyek Laravel Anda

1. **Copy Controller:**  
   Salin `app/Http/Controllers/CourseController.php` ke folder Laravel Anda.
2. **Copy Route:**  
   Tambahkan isi `routes/web.php` ke file routes Laravel Anda.
3. **Copy Views (Blade):**  
   Salin `resources/views/layouts/app.blade.php` dan `resources/views/course/watch.blade.php`.
4. **Copy Asset CSS & JS:**  
   Salin `public/css/elearning-player.css` dan `public/js/elearning-player.js` ke folder `public/` Laravel Anda.

---

## 🛡️ Lapisan Keamanan yang Diterapkan

1. **Parameter Iframe YouTube**:
   - `controls=0` (Matikan kontrol asli YouTube)
   - `modestbranding=1` (Sembunyikan logo YouTube)
   - `rel=0` (Cegah rekomendasi video channel luar)
   - `iv_load_policy=3` (Matikan anotasi)
   - `disablekb=1` (Cegah keyboard shortcut YouTube)
2. **Transparent Shield Overlay (`.player-shield-overlay`)**:
   - Menghalangi pengguna mengklik judul video atau tombol bagikan YouTube.
   - Klik pada video dialihkan secara internal menjadi Play / Pause pada Plyr player.
3. **Dynamic Floating Watermark**:
   - Menampilkan email dan ID pengguna yang sedang login.
   - Watermark berpindah koordinat setiap 10 detik untuk mempersulit screen recording.
4. **Anti-Inspect & Anti-Right Click**:
   - Klik kanan pada area player dicegah dan menampilkan alert perlindungan hak cipta.
   - Shortcut F12, Ctrl+Shift+I, dan Ctrl+U dinonaktifkan.