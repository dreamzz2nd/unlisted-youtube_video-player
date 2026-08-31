# 🛡️ EduSecure LMS - YouTube Masked Video Player (Prototype)

Prototype pemutar video e-learning interaktif dengan sistem proteksi link YouTube, pencegahan klik langsung ke channel/share YouTube (*Shield Click Interceptor*), dynamic moving watermark, dan kustom kontrol modern menggunakan **Plyr.js**.

---

## ⚡ Ringkasan: Apa yang Perlu Didownload?

> **TIDAK PERLU INSTALL DEPENDENCY APAPUN (`npm install` / `composer install` = TIDAK PERLU)**  
> Semua library (Plyr.js, FontAwesome, Google Fonts) dimuat secara instan lewat **CDN**.

| Kebutuhan | Status | Keterangan |
|---|---|---|
| **Web Browser** | **Wajib** | Google Chrome, Microsoft Edge, Firefox, Brave, Safari, dll. |
| **Koneksi Internet** | **Wajib** | Diperlukan untuk memuat library CDN dan streaming video YouTube. |
| **Node.js** | *Opsional* | Hanya jika ingin menjalankan server lokal lewat terminal `node server.js`. |
| **PHP / Composer** | *Tidak Perlu* | Hanya jika nanti ingin mengintegrasikan file template ke Laravel asli. |

---

## 🚀 Cara Menjalankan Prototype (Pilih Salah Satu)

### Opsi 1: Buka Langsung di Browser (Paling Mudah, Tanpa Install Apapun)
1. **Clone repository:**
   ```bash
   git clone https://github.com/USERNAME/REPOSITORY-NAME.git
   ```
2. Buka folder `public/`.
3. Klik 2x pada file **`index.html`** untuk membukanya di browser (atau klik kanan > **Open with Live Server** di VS Code).

---

### Opsi 2: Menggunakan Node.js Server
1. **Clone repository:**
   ```bash
   git clone https://github.com/USERNAME/REPOSITORY-NAME.git
   cd REPOSITORY-NAME
   ```
2. Jalankan perintah:
   ```bash
   node server.js
   ```
3. Buka browser di alamat:
   👉 **`http://localhost:3000`**

---

## 📂 Struktur File Project

```text
elearning-laravel-player/
├── public/                               <-- FOLDER UTAMA PROTOTYPE
│   ├── index.html                        <-- Halaman demo interaktif (siap jalan di browser)
│   ├── css/
│   │   └── elearning-player.css          <-- Styling Glassmorphism Dark Theme & Shield Overlay
│   └── js/
│       └── elearning-player.js           <-- Logika Plyr, Shield Click Interceptor, & Dynamic Watermark
│
├── server.js                             <-- Local HTTP server ringan (bawaan Node.js tanpa npm)
│
├── app/                                  <-- TEMPLATE SIAP PAKAI UNTUK LARAVEL (OPSIONAL)
│   └── Http/Controllers/
│       └── CourseController.php          <-- Parser YouTube URL & controller simulasi
├── routes/
│   └── web.php                          <-- Routing endpoint /course/{slug}/lesson/{id}
└── resources/
    └── views/
        ├── layouts/app.blade.php         <-- Blade layout template
        └── course/watch.blade.php        <-- Blade view player
```

---

## 🛡️ Fitur Proteksi Video yang Diterapkan

1. **YouTube Iframe Masking**:
   - Kontrol asli YouTube dimatikan (`controls=0`).
   - Logo YouTube disembunyikan (`modestbranding=1`).
   - Rekomendasi video channel luar dinonaktifkan (`rel=0`).
2. **Transparent Shield Interceptor (`.player-shield-overlay`)**:
   - Mencegah pengguna mengeklik judul video atau tombol bagikan (*Share/Watch on YouTube*).
   - Menangkap klik mouse dan mengalihkannya menjadi aksi *Play / Pause* pada player kustom.
3. **Dynamic Floating Watermark**:
   - Menampilkan identitas pengguna (Email & ID Siswa).
   - Posisi watermark berpindah secara acak setiap 10 detik untuk mencegah/mempersulit *screen recording*.
4. **Anti-Inspect & Anti-Right Click**:
   - Mencegah klik kanan di seluruh area video player.
   - Menghambat shortcut inspect element (`F12`, `Ctrl+Shift+I`, `Ctrl+U`).

---

## 🧩 Ingin Memindahkan ke Proyek Laravel Asli?

Jika Anda ingin mengimplementasikan fitur ini ke dalam proyek Laravel:
1. Salin [`app/Http/Controllers/CourseController.php`](app/Http/Controllers/CourseController.php) ke folder Laravel Anda.
2. Salin routing di [`routes/web.php`](routes/web.php) ke file `routes/web.php` Laravel Anda.
3. Salin folder [`resources/views/course/`](resources/views/course/watch.blade.php) & [`resources/views/layouts/`](resources/views/layouts/app.blade.php).
4. Salin file CSS & JS di folder [`public/`](public/) ke folder `public/` Laravel Anda.
5. Jalankan `php artisan serve`.