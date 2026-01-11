# 🏥 HealthyHub - Platform Kesehatan Terintegrasi

![PHP](https://img.shields.io/badge/PHP-Native-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![Status](https://img.shields.io/badge/Status-Completed-success?style=for-the-badge)

> **Final Project / Tugas Besar - Pemrograman Web** > Program Studi Informatika - Universitas Sebelas April

HealthyHub adalah sistem informasi kesehatan berbasis web yang menghubungkan pasien dengan dokter. Aplikasi ini dibangun menggunakan **PHP Native** untuk memahami konsep dasar alur data dan logika backend sebelum beralih ke framework.

---

## 📸 Tampilan Aplikasi (Screenshots)

| Halaman Utama | Dashboard Admin |
|:---:|:---:|
| ![Home](https://placehold.co/600x400/00b4d8/ffffff?text=Screenshot+Home) | ![Admin](https://placehold.co/600x400/1e293b/ffffff?text=Screenshot+Admin) |

---

## ✨ Fitur Unggulan

### 👤 Sisi Pengguna (User/Pasien)
- **Universal Login:** Satu pintu masuk untuk Admin dan Pasien.
- **Appointment System:** Membuat janji temu dokter (hanya untuk user terdaftar).
- **Health Articles:** Membaca artikel kesehatan dengan fitur **Pencarian (Search)**.
- **BMI Calculator:** Menghitung Indeks Massa Tubuh secara interaktif (JavaScript).
- **Responsive UI:** Tampilan modern dengan gaya *Glassmorphism* menggunakan Bootstrap 5.

### 🛡️ Sisi Admin (Administrator)
- **Dashboard Overview:** Statistik real-time jumlah pasien, dokter, dan artikel.
- **CRUD Dokter:** Menambah, mengedit, dan menghapus data dokter spesialis.
- **CRUD Artikel:** Menulis dan mengelola konten blog kesehatan.
- **Manajemen Janji Temu:** Melihat dan menghapus data janji temu pasien.

---

## 🛠️ Teknologi yang Digunakan

- **Backend:** PHP 8.x (Native / Procedural)
- **Database:** MySQL (Relational DB)
- **Frontend:** HTML5, CSS3, Bootstrap 5.3
- **Icons:** FontAwesome 6 & Icons8
- **Alerts:** SweetAlert2 (Popup Notifikasi Modern)
- **Server:** Apache (via XAMPP)

---

## ⚙️ Cara Instalasi (Localhost)

Ikuti langkah ini untuk menjalankan proyek di komputer Anda:

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/username-anda/healthyhub.git](https://github.com/username-anda/healthyhub.git)
    ```
2.  **Pindahkan Folder**
    Salin folder `healthyhub` ke dalam direktori `htdocs` (biasanya di `C:/xampp/htdocs/`).

3.  **Impor Database**
    - Buka `localhost/phpmyadmin`
    - Buat database baru dengan nama: `healthyhub`
    - Import file `healthyhub.sql` yang ada di dalam folder proyek.

4.  **Konfigurasi Koneksi**
    Pastikan file `koneksi.php` sesuai dengan settingan XAMPP Anda:
    ```php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "healthyhub";
    ```

5.  **Jalankan Project**
    Buka browser dan akses:
    `http://localhost/healthyhub`

---

## 🔑 Akun Demo

Gunakan akun berikut untuk pengujian sistem:

| Role | Username | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin` | `admin123` |
| **Pasien (User)** | `andi` | `12345` (atau daftar baru) |

---

## 📂 Struktur Database

- **`admins`**: Menyimpan data login administrator.
- **`users`**: Menyimpan data akun pasien (Password di-hash).
- **`doctors`**: Menyimpan daftar dokter dan spesialisasi.
- **`articles`**: Menyimpan konten blog kesehatan.
- **`appointments`**: Menyimpan data janji temu (berelasi dengan tabel `doctors`).

---

## 👨‍💻 Author

Dibuat dengan ❤️ oleh:
- **Nama:** [Nama Kamu]
- **NIM:** [NIM Kamu]
- **Kampus:** Universitas Sebelas April
- **Jurusan:** Informatika

---

*Project ini dibuat untuk tujuan edukasi dan pemenuhan tugas kuliah.*
