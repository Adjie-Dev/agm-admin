# Tentang Project

Project ini menggunakan **Laravel Blade**, **Vite**, dan **Tailwind CSS**.

Asset frontend (CSS & JS) dikelola oleh **Vite**, sehingga **CSS tidak akan jalan** jika Vite tidak dijalankan atau belum dibuild.

---

## Kebutuhan

Pastikan sudah terinstall:

- PHP 8+
- Composer
- Node.js (disarankan LTS)
- NPM

---

## Instalasi

Clone repository dan install dependency:

```bash
git clone <url-repository>
cd <nama-folder-project>

composer install
npm install
```

Salin file environment dan generate key:

```bash
cp .env.example .env
php artisan key:generate
```

---

## Menjalankan Project (WAJIB ⚠️)

### 1. Jalankan Laravel

```bash
php artisan serve
```

### 2. Jalankan Vite (Tailwind & Asset)

Buka terminal baru lalu jalankan:

```bash
npm run dev
```

⚠️ **Catatan penting:**
Jika `npm run dev` tidak dijalankan, **Tailwind CSS dan styling tidak akan muncul**, karena project ini menggunakan **Vite**.

---

## Build untuk Production

```bash
npm run build
```

---

## Struktur Singkat

- Blade: `resources/views`
- Tailwind CSS: `resources/css`
- Vite config: `vite.config.js`
- Tailwind config: `tailwind.config.js`

---

## Lisensi

Project ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).

---
