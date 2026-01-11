<?php
include 'koneksi.php';

// Cek apakah ada ID di URL
if(!isset($_GET['id'])){
    header("location:index.php");
    exit();
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM articles WHERE id = '$id'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title']; ?> - HealthyHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f8ff; font-family: 'Poppins', sans-serif; }
        .article-img { width: 100%; height: 400px; object-fit: cover; border-radius: 15px; margin-bottom: 30px; }
        .content { font-size: 1.1rem; line-height: 1.8; color: #333; }
        .back-btn { text-decoration: none; color: #0077b6; font-weight: bold; }
        .back-btn:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container py-5">
    <a href="index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
    
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8 bg-white p-5 rounded shadow">
            <img src="https://placehold.co/800x400/00b4d8/ffffff?text=Healthy+Topic" class="article-img" alt="Gambar Artikel">
            
            <h1 class="fw-bold mb-3"><?= $data['title']; ?></h1>
            <p class="text-muted"><i class="far fa-clock"></i> Diposting pada: <?= date('d M Y', strtotime($data['created_at'])); ?></p>
            <hr>
            
            <div class="content mt-4">
                <?= nl2br($data['content']); ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>