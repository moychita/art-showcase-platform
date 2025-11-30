# 🎨 RupaRupi – Platform Showcase Seni Digital

**RupaRupi** adalah platform showcase karya seni digital yang dirancang untuk komunitas pecinta seni. Platform ini menjadi wadah bagi kreator untuk membangun portofolio, mengikuti kompetisi (Challenge), serta terhubung dengan kurator profesional dan audiens yang lebih luas.

---

## 🌟 Fitur Utama

Aplikasi ini memiliki **4 peran pengguna (Role)** dengan hak akses berbeda:

---

### 1. 🎨 Member (Kreator)
- **Manajemen Karya**: Upload karya (Drag & Drop), edit detail, dan hapus karya.
- **Interaksi**: Like, Favorite, dan Comment.
- **Profil & Portofolio**: Halaman profil publik berisi galeri karya pribadi.
- **Partisipasi Challenge**: Submit karya pada challenge yang sedang aktif.
- **Pelaporan**: Melaporkan karya atau komentar yang melanggar aturan.

---

### 2. 🏆 Curator (Kurator)
- **Manajemen Challenge**: Membuat, mengedit, dan menghapus kompetisi seni.
- **Review Submisi**: Melihat seluruh karya yang didaftarkan peserta.
- **Pemilihan Pemenang**: Menentukan pemenang (otomatis mendapat badge “Juara”).
- **Dashboard Kurator**: Statistik ringkas challenge aktif dan total submisi.

---

### 3. 🛡️ Admin (Administrator)
- **Manajemen Pengguna**: Melihat user, mengubah role, blokir, atau hapus pengguna.
- **Moderasi Konten**: Melihat laporan pelanggaran dan melakukan tindakan (take down atau tolak laporan).
- **Approval Kurator**: Menyetujui registrasi akun kurator.
- **Manajemen Kategori**: Tambah/edit/hapus kategori seni (Fotografi, Ilustrasi, UI/UX, dll).
- **Dashboard Statistik**: Ringkasan data global platform.

---

### 4. 👤 Guest (Pengunjung)
- **Eksplorasi**: Melihat galeri karya dan detail challenge.
- **Search & Filter**: Mencari karya berdasarkan judul atau kategori.

---

## 🛠️ Teknologi yang Digunakan
- **Backend**: Laravel 10/11 (PHP)
- **Frontend**: Blade Templates
- **Styling**: Tailwind CSS
- **Database**: MySQL
- **Scripting**: Vanilla JavaScript (AJAX Like/Favorite & Image Preview)

---

## 🚀 Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal Anda.

---

### 🔧 Prasyarat
- PHP ≥ 8.1  
- Composer  
- Node.js & NPM  
- MySQL  

---

### 📥 1. Clone Repositori
```bash
git clone https://github.com/username/ruparupi.git
cd ruparupi
```

---

### 📦 2. Install Dependencies

**Composer**
```bash
composer install
```

**NPM**
```bash
npm install
```

---

### ⚙️ 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Atur konfigurasi database:
```
DB_DATABASE=nama_database_kamu
DB_USERNAME=root
DB_PASSWORD=
```

---

### 🔑 4. Generate Key & Migrasi Database
```bash
php artisan key:generate
php artisan migrate:fresh
```

Jika menggunakan seeder:
```bash
php artisan db:seed
```

---

### 🖼️ 5. Link Storage (Wajib)
Agar file gambar tampil di web:
```bash
php artisan storage:link
```

---

## ▶️ 6. Jalankan Aplikasi

**Terminal 1 — Laravel Server**
```bash
php artisan serve
```

**Terminal 2 — Vite**
```bash
npm run dev
```

Akses aplikasi melalui:  
👉 http://127.0.0.1:8000

---

## 📝 Catatan Penggunaan (User Roles)

### 🔐 Membuat Admin Secara Manual
Karena tidak ada fitur register admin:

1. Register akun baru (role: Member).  
2. Buka **phpMyAdmin** → tabel `users`.  
3. Ubah kolom `role` menjadi `admin`.  

---

### 🧾 Alur Pendaftaran Kurator
1. User memilih role **Curator** saat registrasi.  
2. Status awal: **pending**.  
3. Admin login → Dashboard Admin → Approve kurator.  
4. Setelah disetujui, akun kurator dapat mengakses dashboard.

---

## 🎨 Credits
Dikembangkan sebagai **Individual Project** untuk mata kuliah *Pemrograman Web*.  
Terinspirasi oleh desain modern Suntrix & Dribbble.
