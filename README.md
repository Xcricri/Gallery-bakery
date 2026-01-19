## 🧩 1. Clone Repository

Clone repository dari GitHub:

```bash
git clone https://github.com/Xcricri/Gallery-bakery.git
```

---

## 📂 2. Masuk ke Folder Project

```bash
cd Gallery-bakery
```

---

## 🧱 3. Install Dependensi PHP

Pastikan kamu sudah menginstal **Composer**.  
Kemudian jalankan perintah:

```bash
composer install
```

---

## 💾 4. Duplikasi File Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

---

## 🔑 5. Generate Application Key

```bash
php artisan key:generate
```

---

## 🗄️ 6. Setup Database

1. Buat database baru (misalnya dengan phpMyAdmin, TablePlus, atau command line).
2. Sesuaikan konfigurasi di `.env` seperti contoh di atas.
3. Jalankan migrasi tabel:

    ```bash
    php artisan migrate
    ```

4. Jika project menyediakan data awal (seeder), jalankan:
    ```bash
    php artisan db:seed
    ```

---

## 🖼️ 7. Upload dan Kelola Gambar

Untuk menambahkan foto kegiatan sekolah, biasanya project ini memiliki fitur upload.  
Pastikan folder `storage` dapat diakses publik dengan membuat symbolic link:

```bash
php artisan storage:link
```

---

## ⚙️ 8. Install Dependensi Frontend

```bash
npm install
npm run dev
```

Untuk build produksi:

```bash
npm run build
```

---

## 🚀 9. Jalankan Server Lokal

```bash
php artisan serve
```

Server akan berjalan di:

```
http://127.0.0.1:8000
```

---

## ✅ 10. Selesai!

Sekarang project **Galeri Sekolah Laravel** sudah siap digunakan 🎉

---

# Gallery-bakery
