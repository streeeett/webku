<?php
require '../connection/koneksi.php';
session_start();

// Pastikan pengguna sudah login sebagai admin
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?pesan=akses_ditolak");
    exit;
}

// Proses form saat admin menambahkan kode promo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_promo = $_POST['kode_promo'];
    $potongan_persen = $_POST['potongan_persen'];
    $berlaku_mulai = $_POST['berlaku_mulai'];
    $berlaku_sampai = $_POST['berlaku_sampai'];

    // Validasi input
    if (empty($kode_promo) || empty($potongan_persen) || empty($berlaku_mulai) || empty($berlaku_sampai)) {
        $error_message = "Semua bidang harus diisi.";
    } elseif ($potongan_persen <= 0 || $potongan_persen > 100) {
        $error_message = "Potongan harus antara 1% hingga 100%.";
    } else {
        // Simpan ke database
        $query = "INSERT INTO promo (kode_promo, potongan_persen, berlaku_mulai, berlaku_sampai) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('siss', $kode_promo, $potongan_persen, $berlaku_mulai, $berlaku_sampai);

        if ($stmt->execute()) {
            $success_message = "Kode promo berhasil ditambahkan!";
        } else {
            $error_message = "Terjadi kesalahan saat menambahkan kode promo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kode Promo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">Tambah Kode Promo</h1>

        <!-- Pesan sukses atau error -->
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success_message); ?></div>
        <?php elseif (!empty($error_message)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <!-- Form tambah kode promo -->
        <form method="POST">
            <div class="mb-3">
                <label for="kode_promo" class="form-label">Kode Promo</label>
                <input type="text" id="kode_promo" name="kode_promo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="potongan_persen" class="form-label">Potongan (%)</label>
                <input type="number" id="potongan_persen" name="potongan_persen" class="form-control" min="1" max="100" required>
            </div>
            <div class="mb-3">
                <label for="berlaku_mulai" class="form-label">Berlaku Mulai</label>
                <input type="date" id="berlaku_mulai" name="berlaku_mulai" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="berlaku_sampai" class="form-label">Berlaku Sampai</label>
                <input type="date" id="berlaku_sampai" name="berlaku_sampai" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Promo</button>
            <a href="dashboard_admin.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
