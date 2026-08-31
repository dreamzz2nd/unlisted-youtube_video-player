# 🛡️ EduSecure LMS - YouTube Masked Video Player (Prototype)

Prototype pemutar video e-learning interaktif dengan sistem proteksi link YouTube, pencegahan klik langsung ke channel/share YouTube (*Shield Click Interceptor*), dynamic moving watermark, dan kustom kontrol modern menggunakan **Plyr.js**.

---

## ⚡ Ringkasan: Apa yang Perlu Didownload?

> **TIDAK PERLU INSTALL DEPENDENCY APAPUN (`npm install` dll. = TIDAK PERLU)**  
> Semua library (Plyr.js, FontAwesome, Google Fonts) dimuat secara instan lewat **CDN**.

| Kebutuhan | Status | Keterangan |
|---|---|---|
| **Web Browser** | **Wajib** | Google Chrome, Microsoft Edge, Firefox, Brave, Safari, dll. |
| **Koneksi Internet** | **Wajib** | Diperlukan untuk memuat library CDN dan streaming video YouTube. |

---

## 🚀 Cara Menjalankan secara Lokal

### Opsi 1: Buka Langsung di Browser (Paling Mudah)
1. Buka folder proyek.
2. Klik 2x pada file **`index.html`** untuk membukanya di browser (atau klik kanan > **Open with Live Server** di VS Code).

### Opsi 2: Menggunakan Simple Server
Jika Anda ingin menjalankan via HTTP server lokal:
* **Menggunakan Node.js (npx)**:
  ```bash
  npx http-server .
  ```
* **Menggunakan Python**:
  ```bash
  python -m http.server 8080
  ```
Buka browser di alamat: `http://localhost:8080` (atau port yang tertera).

---

## 📂 Struktur File Project

```text
elearning-player/
├── index.html                        <-- Halaman utama (siap jalan di browser / hosting)
├── css/
│   └── elearning-player.css          <-- Styling Glassmorphism Dark Theme & Shield Overlay
└── js/
    └── elearning-player.js           <-- Logika Plyr, Shield Click Interceptor, & Dynamic Watermark
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