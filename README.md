# AGM Admin

Admin panel untuk manajemen konten edukasi Buddhist. Dibangun menggunakan Laravel 12, Vite, Tailwind CSS, dan Alpine.js.

Sistem ini mengelola artikel, e-book, dokumen ajaran (Dhammavachana), doa/puja dengan audio, serta kalender acara keagamaan Buddhist.

---

## Tech Stack

| Kategori | Teknologi                                          |
| -------- | -------------------------------------------------- |
| Backend  | Laravel 12, PHP 8.2+                               |
| Frontend | Blade, Alpine.js 3, Tailwind CSS 3                 |
| Bundler  | Vite 7                                             |
| Database | SQLite (default), PostgreSQL (production)          |
| Auth     | Laravel Breeze, Sanctum (API)                      |
| PDF      | FPDF, FPDI, smalot/pdfparser, Spatie PDF-to-Image  |
| Audio    | getID3 (ekstraksi durasi & metadata)               |
| Editor   | TinyMCE (rich text)                                |

---

## Fitur Utama

### Dashboard

- Statistik konten (jumlah artikel, e-book, dhammavachana, dll.)
- Kalender Buddhist dengan fase bulan dan acara keagamaan

### Artikel

- CRUD artikel dengan rich text editor (TinyMCE)
- Upload gambar thumbnail dan gambar dalam konten
- Tracking pembuat dan pengubah artikel

### Dhammavachana

- Upload dokumen PDF ajaran Buddhist (maks 10MB)
- Auto-generate cover dari halaman pertama PDF (Ghostscript)
- Ekstraksi jumlah halaman otomatis

### E-Book

- Upload file PDF (maks 50MB)
- Parsing metadata PDF (judul, jumlah halaman)
- Generate thumbnail dari halaman pertama

### Pathama Puja

- Kelola bagian-bagian doa Pathama Puja (hingga 17 bagian)
- Upload audio (mp3, wav, ogg - maks 50MB)
- Ekstraksi durasi audio otomatis
- Teks Pali dan terjemahan Bahasa Indonesia
- Status aktif/nonaktif per bagian
- API publik untuk akses dari aplikasi lain

### Puja Pagi

- Kelola doa pagi dengan audio
- Teks Pali dan terjemahan
- Urutan fleksibel

### Kalender Buddhist

- Acara keagamaan: Uposatha, Waisak, Magha Puja, Asalha Puja, Kathina, Vassa, Pavarana, dan custom
- Fase bulan (bulan baru, paruh pertama, purnama, paruh akhir)
- Warna kustom per acara
- Dukungan acara berulang
- Toggle aktif/nonaktif

### Manajemen User

- Registrasi dan login
- Edit profil dan foto profil
- Ganti password

---

## Kebutuhan

- PHP 8.2+
- Composer
- Node.js (LTS)
- NPM
- Ghostscript (untuk generate cover PDF)

---

## Instalasi

### Cara Cepat

```bash
git clone <url-repository>
cd agm-admin
composer setup
```

Script `composer setup` akan menjalankan: install dependency PHP & NPM, salin `.env`, generate key, migrasi database, dan build asset.

### Cara Manual

```bash
git clone <url-repository>
cd agm-admin

composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan migrate

npm run build
```

---

## Menjalankan Project

### Cara Cepat (Concurrent)

```bash
composer dev
```

Menjalankan Laravel server, queue listener, log monitor (Pail), dan Vite dev server secara bersamaan.

### Cara Manual (2 Terminal)

**Terminal 1** - Laravel server:

```bash
php artisan serve
```

**Terminal 2** - Vite dev server:

```bash
npm run dev
```

> **Catatan:** Jika `npm run dev` tidak dijalankan, Tailwind CSS dan styling tidak akan muncul karena project ini menggunakan Vite.

---

## Build Production

```bash
npm run build
```

---

## API Endpoints

Endpoint publik (tanpa autentikasi):

| Method | Endpoint                     | Deskripsi                                    |
| ------ | ---------------------------- | -------------------------------------------- |
| GET    | `/api/pathama-puja`          | Daftar semua Pathama Puja yang aktif         |
| GET    | `/api/pathama-puja/{urutan}` | Detail Pathama Puja berdasarkan nomor urutan |

Endpoint terproteksi (memerlukan Sanctum token):

| Method | Endpoint    | Deskripsi                   |
| ------ | ----------- | --------------------------- |
| GET    | `/api/user` | Data user yang sedang login |

---

## Struktur Project

```text
agm-admin/
├── app/
│   ├── Http/Controllers/     # Controller untuk setiap fitur
│   ├── Models/               # Eloquent model (User, Article, Ebook, dll.)
│   ├── Services/             # Business logic (LayananFaseBulan)
│   └── View/Components/      # Blade component class (AppLayout, GuestLayout)
├── database/
│   └── migrations/           # Skema database (11 migration)
├── resources/
│   ├── css/                  # Tailwind CSS entry point
│   ├── js/                   # Alpine.js & Axios setup
│   └── views/                # Blade template (53 file)
│       ├── articles/         # Halaman artikel
│       ├── auth/             # Login, register
│       ├── components/       # Komponen UI reusable
│       ├── dhammavachana/    # Halaman dhammavachana
│       ├── ebooks/           # Halaman e-book
│       ├── kalender-buddhist/# Halaman kalender
│       ├── layouts/          # Layout utama (app, guest)
│       ├── pathamapuja/      # Halaman pathama puja
│       ├── profile/          # Halaman profil user
│       └── pujapagi/         # Halaman puja pagi
├── routes/
│   ├── web.php               # Route web (auth + CRUD)
│   ├── api.php               # Route API (Pathama Puja)
│   └── auth.php              # Route autentikasi
├── storage/                  # File upload (PDF, audio, gambar)
├── vite.config.js            # Konfigurasi Vite
└── tailwind.config.js        # Konfigurasi Tailwind CSS
```

---

## Penyimpanan File

File yang diupload tersimpan di `storage/app/public/`:

| Direktori              | Isi                              |
| ---------------------- | -------------------------------- |
| `articles/thumbnails/` | Thumbnail artikel                |
| `articles/images/`     | Gambar konten artikel            |
| `dhammavachana/`       | File PDF dhammavachana           |
| `ebooks/`              | File PDF e-book                  |
| `covers/`              | Cover yang digenerate dari PDF   |
| `audio/pathama/`       | Audio Pathama Puja               |
| `audio/puja-pagi/`     | Audio Puja Pagi                  |
| `profile-photos/`      | Foto profil user                 |

---

## Testing

```bash
composer test
```

---

## Lisensi

Project ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
