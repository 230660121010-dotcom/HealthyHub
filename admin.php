<?php
session_start();
include 'koneksi.php';

// Cek Login
if(!isset($_SESSION['admin_status'])){
    header("location:login.php");
    exit();
}

// --- LOGIKA HAPUS DATA ---
if(isset($_GET['hapus_dokter'])){
    $id = $_GET['hapus_dokter'];
    mysqli_query($conn, "DELETE FROM doctors WHERE id='$id'");
    echo "<script>alert('Data Dokter Dihapus!'); window.location='admin.php?page=doctors';</script>";
}
if(isset($_GET['hapus_artikel'])){
    $id = $_GET['hapus_artikel'];
    mysqli_query($conn, "DELETE FROM articles WHERE id='$id'");
    echo "<script>alert('Artikel Dihapus!'); window.location='admin.php?page=articles';</script>";
}
if(isset($_GET['hapus_janji'])){
    $id = $_GET['hapus_janji'];
    mysqli_query($conn, "DELETE FROM appointments WHERE id='$id'");
    echo "<script>alert('Janji Temu Dihapus!'); window.location='admin.php?page=appointments';</script>";
}

// --- LOGIKA TAMBAH DATA ---
if(isset($_POST['tambah_dokter'])){
    $nama = $_POST['name'];
    $spesialis = $_POST['specialist'];
    mysqli_query($conn, "INSERT INTO doctors (name, specialist) VALUES ('$nama', '$spesialis')");
    echo "<script>window.location='admin.php?page=doctors';</script>";
}
if(isset($_POST['tambah_artikel'])){
    $judul = $_POST['title'];
    $konten = $_POST['content'];
    mysqli_query($conn, "INSERT INTO articles (title, content) VALUES ('$judul', '$konten')");
    echo "<script>window.location='admin.php?page=articles';</script>";
}

// --- HITUNG DATA UNTUK DASHBOARD ---
$total_docs = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM doctors"));
$total_arts = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM articles"));
$total_apps = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointments"));

// --- NAVIGASI HALAMAN ---
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - HealthyHub</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f3f4f6; overflow-x: hidden; }
        
        /* Sidebar Styling */
        .sidebar {
            min-height: 100vh;
            width: 260px;
            background: #1e293b; /* Dark Blue Slate */
            color: #fff;
            position: fixed;
            top: 0; left: 0;
            transition: all 0.3s;
            z-index: 1000;
        }
        .sidebar-brand {
            padding: 20px;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            color: #38bdf8;
        }
        .sidebar-menu { padding: 20px 0; }
        .sidebar-menu a {
            display: block;
            padding: 15px 25px;
            color: #cbd5e1;
            text-decoration: none;
            transition: 0.3s;
            border-left: 4px solid transparent;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: #334155;
            color: #fff;
            border-left-color: #38bdf8;
        }
        .sidebar-menu i { margin-right: 10px; width: 20px; text-align: center; }

        /* Main Content Styling */
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }
        
        /* Stats Card */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.3s;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-icon {
            width: 60px; height: 60px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
        }
        .bg-blue-light { background: #e0f2fe; color: #0284c7; }
        .bg-green-light { background: #dcfce7; color: #16a34a; }
        .bg-purple-light { background: #f3e8ff; color: #9333ea; }

        /* Table Styling */
        .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .table-container {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .btn-action { margin-right: 5px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-heartbeat"></i> HealthyHub
        </div>
        <div class="sidebar-menu">
            <a href="admin.php?page=dashboard" class="<?= $page=='dashboard'?'active':'' ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="admin.php?page=doctors" class="<?= $page=='doctors'?'active':'' ?>">
                <i class="fas fa-user-md"></i> Data Dokter
            </a>
            <a href="admin.php?page=articles" class="<?= $page=='articles'?'active':'' ?>">
                <i class="fas fa-newspaper"></i> Data Artikel
            </a>
            <a href="admin.php?page=appointments" class="<?= $page=='appointments'?'active':'' ?>">
                <i class="fas fa-calendar-check"></i> Janji Temu
            </a>
            <a href="logout.php" class="text-danger mt-5">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <div class="main-content">
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h3 class="fw-bold mb-0">Admin Panel</h3>
                <p class="text-muted small">Kelola website Anda dengan mudah.</p>
            </div>
            <div class="d-flex align-items-center">
                <div class="me-3 text-end">
                    <span class="d-block fw-bold"><?= $_SESSION['admin_name']; ?></span>
                    <span class="text-muted small">Administrator</span>
                </div>
                <img src="https://ui-avatars.com/api/?name=<?= $_SESSION['admin_name']; ?>&background=0D8ABC&color=fff" class="rounded-circle" width="45">
            </div>
        </div>

        <?php if($page == 'dashboard'): ?>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div>
                        <h6 class="text-muted mb-1">Total Pasien</h6>
                        <h2 class="fw-bold mb-0"><?= $total_apps; ?></h2>
                    </div>
                    <div class="stat-icon bg-blue-light"><i class="fas fa-users"></i></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div>
                        <h6 class="text-muted mb-1">Total Dokter</h6>
                        <h2 class="fw-bold mb-0"><?= $total_docs; ?></h2>
                    </div>
                    <div class="stat-icon bg-green-light"><i class="fas fa-user-md"></i></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div>
                        <h6 class="text-muted mb-1">Artikel Terbit</h6>
                        <h2 class="fw-bold mb-0"><?= $total_arts; ?></h2>
                    </div>
                    <div class="stat-icon bg-purple-light"><i class="fas fa-newspaper"></i></div>
                </div>
            </div>
        </div>
        
        <div class="mt-5">
            <div class="alert alert-info border-0 shadow-sm">
                <i class="fas fa-info-circle me-2"></i> Selamat datang kembali! Silakan pilih menu di sebelah kiri untuk mengelola data.
            </div>
        </div>
        <?php endif; ?>


        <?php if($page == 'doctors'): ?>
        <div class="content-header">
            <h4>Manajemen Dokter</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahDokter">
                <i class="fas fa-plus me-2"></i>Tambah Dokter
            </button>
        </div>
        <div class="table-container">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Dokter</th>
                        <th>Spesialis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($conn, "SELECT * FROM doctors");
                    $no = 1;
                    while($row = mysqli_fetch_array($q)){ ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="fw-bold"><?= $row['name']; ?></td>
                        <td><span class="badge bg-info text-dark"><?= $row['specialist']; ?></span></td>
                        <td>
                            <a href="edit.php?type=dokter&id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                            <a href="admin.php?hapus_dokter=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>


        <?php if($page == 'articles'): ?>
        <div class="content-header">
            <h4>Manajemen Artikel</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahArtikel">
                <i class="fas fa-plus me-2"></i>Tulis Artikel
            </button>
        </div>
        <div class="table-container">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($conn, "SELECT * FROM articles ORDER BY id DESC");
                    while($row = mysqli_fetch_array($q)){ ?>
                    <tr>
                        <td class="fw-bold"><?= $row['title']; ?></td>
                        <td class="text-muted small"><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                        <td>
                            <a href="edit.php?type=artikel&id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                            <a href="admin.php?hapus_artikel=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>


        <?php if($page == 'appointments'): ?>
        <div class="content-header">
            <h4>Data Janji Temu</h4>
        </div>
        <div class="table-container">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Pasien</th>
                        <th>Kontak</th>
                        <th>Dokter</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($conn, "SELECT appointments.*, doctors.name as doc_name 
                                              FROM appointments 
                                              JOIN doctors ON appointments.doctor_id = doctors.id 
                                              ORDER BY id DESC");
                    while($row = mysqli_fetch_array($q)){ ?>
                    <tr>
                        <td class="fw-bold"><?= $row['patient_name']; ?></td>
                        <td><?= $row['phone']; ?></td>
                        <td><?= $row['doc_name']; ?></td>
                        <td><span class="badge bg-primary"><?= $row['appointment_date']; ?></span></td>
                        <td>
                            <a href="admin.php?hapus_janji=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

    </div>

    <div class="modal fade" id="modalTambahDokter" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Dokter</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Spesialis</label>
                            <input type="text" name="specialist" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="tambah_dokter" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambahArtikel" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tulis Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Judul</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Isi Konten</label>
                            <textarea name="content" class="form-control" rows="6" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="tambah_artikel" class="btn btn-primary">Terbitkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>