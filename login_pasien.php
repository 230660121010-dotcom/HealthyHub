<?php
session_start();
include 'koneksi.php';

// Jika sudah ada session user, langsung ke index
if(isset($_SESSION['user_status'])){
    header("location:index.php");
    exit();
}
// Jika sudah ada session admin, langsung ke admin panel
if(isset($_SESSION['admin_status'])){
    header("location:admin.php");
    exit();
}

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // --- TAHAP 1: CEK TABEL ADMIN DULU ---
    $query_admin = mysqli_query($conn, "SELECT * FROM admins WHERE username = '$username'");
    
    if(mysqli_num_rows($query_admin) === 1){
        $data_admin = mysqli_fetch_assoc($query_admin);
        
        // Cek Password Admin (Sesuai setup sebelumnya: 'admin123')
        if($password == "admin123"){ 
            // Set Session Admin
            $_SESSION['admin_status'] = true;
            $_SESSION['admin_name'] = $data_admin['username'];
            
            // Redirect ke Dashboard Admin
            header("location:admin.php");
            exit();
        }
    }

    // --- TAHAP 2: JIKA BUKAN ADMIN, CEK TABEL USERS (PASIEN) ---
    $query_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if(mysqli_num_rows($query_user) === 1){
        $row = mysqli_fetch_assoc($query_user);
        
        // Cek Password User (Pakai Hash)
        if(password_verify($password, $row['password'])){
            // Set Session User
            $_SESSION['user_status'] = true;
            $_SESSION['user_name'] = $row['name'];
            
            // Redirect ke Halaman Utama
            header("location:index.php");
            exit();
        }
    }

    // --- TAHAP 3: JIKA TIDAK KETEMU DI KEDUANYA ---
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - HealthyHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #e0f7fa 0%, #80deea 100%); display: flex; align-items: center; justify-content: center; height: 100vh; font-family: 'Poppins', sans-serif; }
        .card { border: none; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); overflow: hidden; }
        .btn-login { background-color: #00b4d8; border: none; }
        .btn-login:hover { background-color: #0096c7; }
    </style>
</head>
<body>
    <div class="card p-5" style="width: 400px; background: white;">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-info">Selamat Datang</h3>
            <p class="text-muted small">Silakan masuk untuk melanjutkan</p>
        </div>

        <?php if(isset($error)) : ?>
            <div class="alert alert-danger text-center py-2 mb-3 small rounded-pill">Username atau Password Salah!</div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label text-muted small fw-bold">USERNAME</label>
                <input type="text" name="username" class="form-control bg-light border-0 py-2" placeholder="Masukkan username" required>
            </div>
            <div class="mb-4">
                <label class="form-label text-muted small fw-bold">PASSWORD</label>
                <input type="password" name="password" class="form-control bg-light border-0 py-2" placeholder="Masukkan password" required>
            </div>
            <button type="submit" name="login" class="btn btn-login text-white w-100 rounded-pill py-2 fw-bold shadow-sm">MASUK</button>
            
            <div class="text-center mt-4 border-top pt-3">
                <p class="small text-muted mb-1">Belum punya akun?</p>
                <a href="register.php" class="text-decoration-none fw-bold text-info">Daftar Pasien Baru</a>
            </div>
            
            <div class="text-center mt-3">
                <a href="index.php" class="text-muted small text-decoration-none"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
            </div>
        </form>
    </div>
</body>
</html>