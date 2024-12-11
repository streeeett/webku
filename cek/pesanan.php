<?php
require '../connection/koneksi.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php?pesan=harus_login");
    exit;
}

// Ambil id_user dari session
$id_user = intval($_SESSION['id_user']);

// Query untuk mengambil data pesanan pengguna
$query = "
    SELECT 
        id_pesanan,
        tanggal_pesanan,
        total_harga,
        alamat_pengiriman,
        metode_pembayaran,
        status_pembayaran,
        status_pesanan
    FROM pesanan
    WHERE id_user = $id_user
    ORDER BY tanggal_pesanan DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(#edbfac, #dbd8bb);">
    <div class="container my-5">
        <h1 class="text-left mb-4">Pesanan Saya</h1>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="accordion" id="accordionPesanan">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php 
                    $id_pesanan = intval($row['id_pesanan']);

                    // Query untuk mengambil detail pesanan
                    $query_detail = "
                        SELECT 
                            produk.nama AS nama_produk,
                            detail_pesanan.quantity,
                            detail_pesanan.harga_satuan
                        FROM detail_pesanan
                        JOIN produk ON detail_pesanan.id_produk = produk.id_produk
                        WHERE detail_pesanan.id_pesanan = $id_pesanan";
                    $detail_result = mysqli_query($conn, $query_detail);
                    ?>
                    <div class="accordion-item bg-warning-subtle">
                        <h2 class="accordion-header" id="heading<?= $id_pesanan; ?>">
                            <button class="accordion-button collapsed bg-success-subtle" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $id_pesanan; ?>" aria-expanded="false" aria-controls="collapse<?= $id_pesanan; ?>">
                                Pesanan Tanggal <?= date('d-m-Y H:i', strtotime($row['tanggal_pesanan'])); ?>
                            </button>
                        </h2>
                        <div id="collapse<?= $id_pesanan; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $id_pesanan; ?>" data-bs-parent="#accordionPesanan">
                            <div class="accordion-body">
                                <p><strong>Alamat Pengiriman:</strong> <?= htmlspecialchars($row['alamat_pengiriman']); ?></p>
                                <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($row['metode_pembayaran']); ?></p>
                                <p><strong>Total Harga:</strong> Rp <?= number_format($row['total_harga'], 2, ',', '.'); ?></p>
                                <p><strong>Status Pembayaran:</strong> <?= $row['status_pembayaran']; ?></p>
                                <?php if ($row['status_pembayaran'] === 'Belum Dibayar'): ?>
                                    <a href="bayar.php?id_pesanan=<?= $row['id_pesanan']; ?>" class="btn btn-success">Unggah Bukti Transfer</a>
                                <?php elseif ($row['status_pembayaran'] === 'Menunggu Konfirmasi'): ?>
                                    <button class="btn btn-secondary" disabled>Menunggu Konfirmasi Admin</button>
                                <?php else: ?>
                                    <button class="btn btn-secondary" disabled>Sudah Dibayar</button>
                                <?php endif; ?>

                                <hr>
                                <h5>Detail Pesanan:</h5>
                                <table class="table table-bordered table-secondary">
                                    <thead>
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th>Quantity</th>
                                            <th>Harga Satuan</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($detail = mysqli_fetch_assoc($detail_result)): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($detail['nama_produk']); ?></td>
                                                <td><?= $detail['quantity']; ?></td>
                                                <td>Rp <?= number_format($detail['harga_satuan'], 2, ',', '.'); ?></td>
                                                <td>Rp <?= number_format($detail['quantity'] * $detail['harga_satuan'], 2, ',', '.'); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                                <p class="card-text">Status Pesanan: <strong><?= htmlspecialchars($row['status_pesanan']); ?></strong></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center">Anda belum memiliki pesanan.</p>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="../halaman.php" class="btn btn-secondary">Lanjut Belanja</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
