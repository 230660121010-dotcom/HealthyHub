<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['admin_status'])){ header("location:login.php"); exit(); }

// Ambil ID dan Tipe dari URL
$id = $_GET['id'];
$type = $_GET['type'];

// LOGIKA UPDATE
if(isset($_POST['update'])){
    if($type == 'dokter'){
        $name = $_POST['name'];
        $spec = $_POST['specialist'];
        mysqli_query($conn, "UPDATE doctors SET name='$name', specialist='$spec' WHERE id='$id'");
    } elseif ($type == 'artikel'){
        $title = $_POST['title'];
        $content = $_POST['content'];
        mysqli_query($conn, "UPDATE articles SET title='$title', content='$content' WHERE id='$id'");
    }
    header("location:admin.php");
}

// AMBIL DATA LAMA
if($type == 'dokter'){
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM doctors WHERE id='$id'"));
} elseif ($type == 'artikel'){
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM articles WHERE id='$id'"));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 mx-auto" style="max-width: 600px;">
            <h3>Edit <?= ucfirst($type); ?></h3>
            <form action="" method="POST">
                
                <?php if($type == 'dokter'): ?>
                    <div class="mb-3">
                        <label>Nama Dokter</label>
                        <input type="text" name="name" class="form-control" value="<?= $data['name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label>Spesialis</label>
                        <input type="text" name="specialist" class="form-control" value="<?= $data['specialist'] ?>">
                    </div>

                <?php elseif($type == 'artikel'): ?>
                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control" value="<?= $data['title'] ?>">
                    </div>
                    <div class="mb-3">
                        <label>Konten</label>
                        <textarea name="content" class="form-control" rows="6"><?= $data['content'] ?></textarea>
                    </div>
                <?php endif; ?>

                <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
                <a href="admin.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>