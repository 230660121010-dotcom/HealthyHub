<?php 
session_start();
include 'koneksi.php'; 

// 1. LOGIKA PENCARIAN ARTIKEL
$search_keyword = "";
if (isset($_GET['search'])) {
    $search_keyword = $_GET['search'];
    $article_query = "SELECT * FROM articles WHERE title LIKE '%$search_keyword%' ORDER BY id DESC";
} else {
    $article_query = "SELECT * FROM articles ORDER BY id DESC LIMIT 6";
}

// 2. LOGIKA SIMPAN JANJI TEMU (APPOINTMENT)
$alert_script = ""; // Variabel untuk menampung script SweetAlert
if(isset($_POST['submit_appointment'])){
    // Cek apakah user login (Proteksi ganda)
    if(isset($_SESSION['user_status'])){
        $nama = $_POST['nama'];
        $hp = $_POST['hp'];
        $doc_id = $_POST['doctor_id'];
        $date = $_POST['date'];

        $insert = mysqli_query($conn, "INSERT INTO appointments (patient_name, phone, doctor_id, appointment_date) VALUES ('$nama', '$hp', '$doc_id', '$date')");

        if($insert){
            $alert_script = "
            Swal.fire({
                title: 'Berhasil!',
                text: 'Janji temu Anda telah terjadwal. Mohon datang tepat waktu.',
                icon: 'success',
                confirmButtonColor: '#00b4d8'
            });";
        } else {
            $alert_script = "
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan sistem.',
                icon: 'error'
            });";
        }
    } else {
        // Jika mencoba bypass inspect element tanpa login
        header("location:login_pasien.php");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthyHub - Solusi Kesehatan Cerdas</title>

    <link rel="icon" href="icon.png" type="image/png">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary: #00b4d8;
            --secondary: #0077b6;
            --accent: #caf0f8;
            --dark: #1b263b;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f8ff;
            color: #333;
        }

        /* Navbar Transparan ke Solid */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }
        .nav-link { color: var(--dark) !important; font-weight: 500; }
        .nav-link:hover { color: var(--primary) !important; }
        .btn-main { background-color: var(--primary); color: white; border-radius: 50px; padding: 10px 30px; transition: 0.3s; }
        .btn-main:hover { background-color: var(--secondary); transform: scale(1.05); color: white;}

        /* Hero Section dengan Background Image */
        .hero {
            background: linear-gradient(rgba(0, 180, 216, 0.8), rgba(0, 119, 182, 0.9)), url('https://images.unsplash.com/photo-1538108149393-fbbd81895907?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 180px 0 120px 0;
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
        }

        /* Card Styles & Hover Effects */
        .card-custom {
            border: none;
            border-radius: 20px;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            overflow: hidden;
        }
        .card-custom:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,180,216,0.3);
        }
        .card-icon {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 20px;
        }
        
        /* Form Styling */
        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #e0e0e0;
            background-color: #fcfcfc;
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px var(--accent);
            border-color: var(--primary);
        }

        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 60px 0 30px 0;
        }

        /* Card Blog Image Hover */
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 180, 216, 0.2) !important;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-3" href="#"><i class="fas fa-heartbeat me-2"></i>HealthyHub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link mx-2" href="#bmi">Cek Kesehatan</a></li>
                    <li class="nav-item"><a class="nav-link mx-2" href="#articles">Blog</a></li>
                    <li class="nav-item"><a class="nav-link mx-2" href="#appointment">Janji Temu</a></li>
                    
                    <?php if(isset($_SESSION['user_status'])): ?>
                        <li class="nav-item ms-3 dropdown">
                            <a class="nav-link dropdown-toggle fw-bold text-primary" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> Halo, <?= $_SESSION['user_name']; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-danger" href="logout_user.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-3">
                            <a class="btn btn-outline-primary rounded-pill px-4 fw-bold" href="login_pasien.php">Login / Daftar</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>

    <section class="hero text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill shadow-sm">Platform Kesehatan Terpercaya</span>
                    <h1 class="display-3 fw-bold mb-4">Masa Depan Kesehatan Ada di Tangan Anda</h1>
                    <p class="lead mb-5 opacity-75">Konsultasi dengan dokter spesialis, baca artikel medis terpercaya, dan pantau kesehatan tubuh Anda dalam satu aplikasi terintegrasi.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#appointment" class="btn btn-light text-primary fw-bold btn-lg rounded-pill px-5 shadow">Buat Janji</a>
                        <a href="#articles" class="btn btn-outline-light btn-lg rounded-pill px-5">Baca Artikel</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="bmi" class="py-5" style="margin-top: -80px; position: relative; z-index: 10;">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card-custom p-4 h-100 text-center">
                        <i class="fas fa-user-md card-icon"></i>
                        <h4>Dokter Ahli</h4>
                        <p class="text-muted">Akses ke dokter spesialis terbaik dengan pengalaman bertahun-tahun.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-custom p-4 h-100 text-center bg-primary text-white">
                        <i class="fas fa-calculator card-icon text-white"></i>
                        <h4 class="text-white">Kalkulator BMI</h4>
                        <p class="opacity-75">Cek apakah berat badan Anda ideal.</p>
                        
                        <div class="row g-2 mt-3">
                            <div class="col-6">
                                <input type="number" id="weight" class="form-control" placeholder="Berat (kg)">
                            </div>
                            <div class="col-6">
                                <input type="number" id="height" class="form-control" placeholder="Tinggi (cm)">
                            </div>
                            <div class="col-12">
                                <button onclick="calculateBMI()" class="btn btn-light text-primary w-100 fw-bold">Hitung Sekarang</button>
                            </div>
                        </div>
                        <div id="bmiResult" class="mt-3 fw-bold"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-custom p-4 h-100 text-center">
                        <i class="fas fa-ambulance card-icon"></i>
                        <h4>Layanan 24/7</h4>
                        <p class="text-muted">Siap melayani kebutuhan darurat dan konsultasi kapan saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="articles" class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
                <div>
                    <h5 class="text-primary fw-bold text-uppercase ls-2">Healthy Blog</h5>
                    <h2 class="fw-bold">Artikel & Tips Kesehatan</h2>
                </div>
                <form action="#articles" method="GET" class="d-flex shadow-sm rounded-pill overflow-hidden bg-white">
                    <input type="text" name="search" class="form-control border-0 px-4" placeholder="Cari info kesehatan..." value="<?= $search_keyword ?>" style="outline: none; box-shadow: none;">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 m-1"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <div class="row g-4">
                <?php
                $query = mysqli_query($conn, $article_query);
                if(mysqli_num_rows($query) > 0) {
                    while($row = mysqli_fetch_array($query)){
                ?>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm card-hover" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s;">
                        <div class="position-relative">
                            <img src="https://placehold.co/600x400/00b4d8/ffffff?text=Healthy+Topic+<?= $row['id'] ?>" class="card-img-top" alt="Artikel" style="height: 200px; object-fit: cover;">
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-2 text-muted small"><i class="far fa-calendar-alt me-1"></i> <?= date('d M Y', strtotime($row['created_at'])); ?></div>
                            <h5 class="card-title fw-bold mb-3 text-dark"><?= $row['title']; ?></h5>
                            <p class="card-text text-secondary mb-4" style="font-size: 0.95rem;"><?= substr($row['content'], 0, 80); ?>...</p>
                            <a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-outline-primary w-100 rounded-pill fw-bold stretched-link">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <?php 
                    } 
                } else {
                    echo "<div class='col-12 text-center py-5'><div class='alert alert-warning d-inline-block px-5 rounded-pill'>Artikel tidak ditemukan.</div></div>";
                }
                ?>
            </div>
        </div>
    </section>

    <section id="appointment" class="py-5">
        <div class="container">
            <div class="card-custom overflow-hidden shadow-lg">
                <div class="row g-0">
                    <div class="col-lg-5 bg-primary p-5 text-white d-flex flex-column justify-content-center">
                        <h2 class="fw-bold mb-4">Buat Janji Temu</h2>
                        <p class="mb-4 lead">Isi formulir untuk bertemu dokter spesialis kami. Kami menjamin privasi data Anda.</p>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-phone-alt fa-2x me-3 opacity-50"></i>
                            <div><h6 class="mb-0">Hubungi Kami</h6><span>(021) 555-0123</span></div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope fa-2x me-3 opacity-50"></i>
                            <div><h6 class="mb-0">Email</h6><span>support@healthyhub.com</span></div>
                        </div>
                    </div>

                    <div class="col-lg-7 p-5 bg-white position-relative">
                        
                        <?php if(isset($_SESSION['user_status'])): ?>
                            
                            <h3 class="fw-bold mb-4 text-dark">Formulir Pasien</h3>
                            <form action="" method="POST">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control" value="<?= $_SESSION['user_name']; ?>" readonly style="background-color: #e9ecef;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Nomor WhatsApp</label>
                                        <input type="text" name="hp" class="form-control" required placeholder="08xxxxx">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Dokter Tujuan</label>
                                        <select name="doctor_id" class="form-select">
                                            <?php
                                            $doc_query = mysqli_query($conn, "SELECT * FROM doctors");
                                            while($doc = mysqli_fetch_array($doc_query)){
                                                echo "<option value='".$doc['id']."'>".$doc['name']." (".$doc['specialist'].")</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted">Tanggal Janji</label>
                                        <input type="date" name="date" class="form-control" required>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" name="submit_appointment" class="btn btn-main w-100 py-3 fw-bold">Konfirmasi Janji Temu</button>
                                    </div>
                                </div>
                            </form>

                        <?php else: ?>

                            <div class="d-flex flex-column justify-content-center align-items-center h-100 text-center py-5">
                                <div class="mb-3 text-secondary">
                                    <i class="fas fa-lock fa-4x text-warning"></i>
                                </div>
                                <h3 class="fw-bold">Akses Terbatas</h3>
                                <p class="text-muted mb-4">Anda harus login terlebih dahulu untuk membuat janji temu dengan dokter.</p>
                                <div>
                                    <a href="login_pasien.php" class="btn btn-primary rounded-pill px-4 me-2">Login</a>
                                    <a href="register.php" class="btn btn-outline-primary rounded-pill px-4">Daftar Akun</a>
                                </div>
                            </div>

                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 class="fw-bold mb-3"><i class="fas fa-heartbeat"></i> HealthyHub</h4>
                    <p class="text-white-50">Menyediakan layanan kesehatan terintegrasi untuk masa depan yang lebih baik.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Tautan Cepat</h5>
                    <ul class="list-unstyled text-white-50">
                        <li><a href="#" class="text-white-50 text-decoration-none">Beranda</a></li>
                        <li><a href="#articles" class="text-white-50 text-decoration-none">Artikel</a></li>
                        <li><a href="#appointment" class="text-white-50 text-decoration-none">Janji Temu</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Ikuti Kami</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white fs-4"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white fs-4"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white fs-4"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center text-white-50">
                <small>&copy; 2024 HealthyHub Project. All Rights Reserved.</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function calculateBMI() {
            let weight = document.getElementById('weight').value;
            let height = document.getElementById('height').value;
            
            if(weight > 0 && height > 0){
                let bmi = weight / ((height / 100) * (height / 100));
                let status = "";
                let color = "";

                if (bmi < 18.5) { status = "Kurus"; color = "text-warning"; }
                else if (bmi >= 18.5 && bmi < 24.9) { status = "Normal"; color = "text-white"; }
                else if (bmi >= 25 && bmi < 29.9) { status = "Gemuk"; color = "text-warning"; }
                else { status = "Obesitas"; color = "text-danger"; }

                document.getElementById('bmiResult').innerHTML = `
                    <div class="p-2 border border-white rounded mt-2 fade-in">
                        <span class="d-block text-white-50 small">Hasil BMI Anda</span>
                        <span class="fs-3 ${color}">${bmi.toFixed(1)}</span>
                        <br>
                        <span class="badge bg-white text-dark mt-1">${status}</span>
                    </div>
                `;
            } else {
                Swal.fire('Oops...', 'Masukkan berat dan tinggi badan!', 'warning');
            }
        }
    </script>

    <script>
        <?= $alert_script; ?>
    </script>

</body>
</html>