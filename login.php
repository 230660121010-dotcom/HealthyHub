<?php
session_start();
include 'koneksi.php';

if(isset($_SESSION['admin_status'])){
    header("location:admin.php");
    exit();
}

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM admins WHERE username = '$username'");
    
    // Cek username
    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        // Cek password (gunakan password_verify jika hash, atau == jika plain text)
        // Disini kita pakai password biasa 'admin123' biar gampang untuk belajar
        if($password == "admin123"){ 
            // Set Session
            $_SESSION['admin_status'] = true;
            $_SESSION['admin_name'] = $row['username'];
            header("location:admin.php");
            exit();
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - HealthyHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #00b4d8, #0077b6); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
    </style>
</head>
<body>
    <div class="card p-4" style="width: 400px;">
        <h3 class="text-center text-primary mb-4 fw-bold">Admin Login</h3>
        <?php if(isset($error)) : ?>
            <div class="alert alert-danger text-center">Username / Password salah!</div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100 py-2">Masuk Dashboard</button>
            <div class="text-center mt-3">
                <a href="index.php" class="text-decoration-none small">Kembali ke Website</a>
            </div>
        </form>
    </div>
</body>
</html>