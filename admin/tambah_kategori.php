<?php
require '../connection/koneksi.php';
session_start();

// Periksa apakah pengguna adalah admin
if ($_SESSION['role'] != "admin") {
    header("location:../halaman.php");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kategori = trim($_POST['kategori']);
    $icon = trim($_POST['icon']);
    
    if (!empty($kategori) && !empty($icon)) {
        $query = "INSERT INTO kategori (nama_kategori, icon) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $kategori, $icon);
        if ($stmt->execute()) {
            $success = "Kategori berhasil ditambahkan.";
        } else {
            $error = "Gagal menambahkan kategori.";
        }
    } else {
        $error = "Nama kategori dan ikon tidak boleh kosong.";
    }
}

// Ambil semua kategori
$query = "SELECT * FROM kategori";
$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Tambah Kategori</h1>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="kategori" class="form-label">Nama Kategori</label>
                <input type="text" name="kategori" id="kategori" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="icon" class="form-label">Ikon (Font Awesome Class)</label>
                <input type="text" name="icon" id="icon" class="form-control" placeholder="Contoh: fas fa-laptop" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
        <hr>
        <h2>Daftar Kategori</h2>
        <ul class="list-group">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <li class="list-group-item">
                    <i class="<?= htmlspecialchars($row['icon']); ?>"></i> <?= htmlspecialchars($row['nama_kategori']); ?>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></Script>
</body>
</html>
