RupaRupi - Platform Showcase Seni Digital

RupaRupi adalah platform showcase karya seni digital yang dirancang khusus untuk komunitas pecinta seni. Platform ini menjadi wadah bagi kreator untuk membangun portofolio, mengikuti kompetisi (Challenge), dan terhubung dengan kurator profesional serta audiens yang lebih luas.

🌟 Fitur Utama

Aplikasi ini memiliki 4 peran pengguna (Role) dengan hak akses yang berbeda:

1. 🎨 Member (Kreator)

Manajemen Karya: Upload karya seni dengan fitur Drag & Drop, edit detail, dan hapus karya.

Interaksi: Memberikan Like, menyimpan ke Favorites, dan berkomentar pada karya orang lain (menggunakan AJAX tanpa reload).

Profil & Portofolio: Halaman profil publik yang menampilkan galeri karya pribadi.

Partisipasi Challenge: Mengikuti kompetisi yang sedang aktif dengan mensubmit karya secara langsung.

Pengaturan Akun: Mengubah profil biodata, avatar, tautan media sosial, serta keamanan akun (email/password).

Pelaporan: Melaporkan konten (karya/komentar) yang melanggar aturan.

2. 🏆 Curator (Kurator)

Manajemen Challenge: Membuat, mengedit, dan menghapus kompetisi seni.

Review Submisi: Melihat galeri karya yang didaftarkan peserta pada sebuah challenge.

Pemilihan Pemenang: Memilih pemenang dari challenge yang dibuat. Pemenang akan mendapatkan badge "Juara" otomatis.

Dashboard Kurator: Statistik ringkas mengenai challenge aktif dan total submisi.

3. 🛡️ Admin (Administrator)

Manajemen Pengguna: Melihat daftar user, mengubah role, dan memblokir/menghapus pengguna.

Moderasi Konten: Menerima laporan pelanggaran dan mengambil tindakan (Take Down karya/komentar atau tolak laporan).

Approval Kurator: Menyetujui pendaftaran akun Curator baru.

Manajemen Kategori: Menambah, mengedit, dan menghapus kategori seni (misal: Fotografi, UI/UX, Ilustrasi).

Dashboard Statistik: Melihat ringkasan data keseluruhan platform.

4. 👤 Guest (Pengunjung)

Eksplorasi: Melihat galeri karya dan detail challenge.

Search & Filter: Mencari karya berdasarkan judul atau kategori.

🛠️ Teknologi yang Digunakan

Backend: Laravel 10/11 (PHP)

Frontend: Blade Templates

Styling: Tailwind CSS (Modern UI/UX)

Database: MySQL

Scripting: Vanilla JavaScript (untuk AJAX Like/Favorite & Image Preview)

🚀 Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

Prasyarat

PHP >= 8.1

Composer

Node.js & NPM

MySQL

Langkah-langkah

Clone Repositori

git clone [https://github.com/username/ruparupi.git](https://github.com/username/ruparupi.git)
cd ruparupi


Install Dependencies
Install paket PHP dan JavaScript yang dibutuhkan.

composer install
npm install


Konfigurasi Environment
Salin file .env.example menjadi .env dan atur konfigurasi database.

cp .env.example .env


Buka file .env dan sesuaikan:

DB_DATABASE=nama_database_kamu
DB_USERNAME=root
DB_PASSWORD=


Generate Key & Migrasi Database

php artisan key:generate
php artisan migrate:fresh


(Opsional: Jika Anda memiliki seeder, jalankan php artisan db:seed)

Link Storage (PENTING)
Agar gambar yang diupload bisa muncul, jalankan perintah ini:

php artisan storage:link


Jalankan Aplikasi
Buka dua terminal terpisah untuk menjalankan server Laravel dan Vite (untuk aset).

Terminal 1:

php artisan serve


Terminal 2:

npm run dev


Akses Website
Buka browser dan kunjungi: http://127.0.0.1:8000

📝 Catatan Penggunaan (User Roles)

Karena fitur register Admin ditiadakan demi keamanan, Anda perlu membuat akun Admin secara manual melalui database atau Seeder.

Cara Membuat Admin Manual:

Register akun baru via halaman /register (pilih role Member).

Buka database (phpMyAdmin), cari tabel users.

Ubah kolom role user tersebut menjadi admin.

Alur Pendaftaran Kurator:

User mendaftar dengan memilih role "Curator".

Status akun akan menjadi pending (tidak bisa akses dashboard).

Admin harus login, masuk ke Dashboard Admin, dan menyetujui (Approve) akun tersebut.

🎨 Credits

Dikembangkan sebagai Individual Project untuk mata kuliah Pemrograman Web.
Terinspirasi oleh desain modern Suntrix & Dribbble.
