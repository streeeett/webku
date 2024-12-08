<?php
require '../connection/koneksi.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php?pesan=harus_login");
    exit;
}

$id_pesanan = intval($_GET['id_pesanan']); // Pastikan id_pesanan berupa angka
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses file bukti transfer
    if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = time() . '_' . $_FILES['bukti_transfer']['name'];
        $file_tmp = $_FILES['bukti_transfer']['tmp_name'];
        $file_path = $upload_dir . $file_name;

        // Pindahkan file ke folder uploads
        if (move_uploaded_file($file_tmp, $file_path)) {
            // Update pesanan dengan bukti transfer
            $query = "UPDATE pesanan SET bukti_transfer = '$file_name', status_pembayaran = 'Menunggu Konfirmasi' WHERE id_pesanan = $id_pesanan";
            if (mysqli_query($conn, $query)) {
                // Redirect dengan pesan sukses
                echo "<script>alert('Bukti transfer berhasil diunggah. Menunggu konfirmasi admin.'); window.location.href = 'pesanan.php';</script>";
                exit;
            } else {
                echo "<script>alert('Gagal memperbarui data pesanan.'); window.location.href = 'pesanan.php';</script>";
            }
        } else {
            echo "<script>alert('Gagal mengunggah file.'); window.location.href = 'pesanan.php';</script>";
        }
    } else {
        echo "<script>alert('Harap unggah file bukti transfer.'); window.location.href = 'pesanan.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti Transfer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1>Upload Bukti Transfer</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="bukti_transfer" class="form-label">Bukti Transfer</label>
                <input type="file" class="form-control" name="bukti_transfer" id="bukti_transfer" required>
            </div>
            <button type="submit" class="btn btn-primary">Unggah</button>
        </form>
        <a href="pesanan.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>
</html>
