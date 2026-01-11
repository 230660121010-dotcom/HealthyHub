<?php
include 'koneksi.php';

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Enkripsi password biar aman (Standar Profesional)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Username sudah terpakai!');</script>";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$hashed_password')");
        if($insert){
            echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='login_pasien.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Akun - HealthyHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f8ff; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="card p-4" style="width: 400px;">
        <h3 class="text-center fw-bold text-primary mb-4">Daftar Akun</h3>
        <form action="" method="POST">
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100 rounded-pill">Daftar Sekarang</button>
            <p class="text-center mt-3 small">Sudah punya akun? <a href="login_pasien.php">Login disini</a></p>
        </form>
    </div>
</body>
</html>