<?php
require 'connection/koneksi.php';
session_start();

// Ambil id_user dari session
$id_user = $_SESSION['id_user'];

// Query untuk mengambil produk yang ada di keranjang
$query = "
    SELECT p.id_produk, p.nama, p.harga, c.quantity
    FROM keranjang c
    JOIN produk p ON c.id_produk = p.id_produk
    WHERE c.id_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
</head>
<body>
    <h1>Keranjang Belanja</h1>

    <?php if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Quantity</th>
                <th>Total Harga</th>
            </tr>
            <?php 
            $total_belanja = 0;
            while ($row = $result->fetch_assoc()): 
                $total_harga = $row['harga'] * $row['quantity'];
                $total_belanja += $total_harga;
            ?>
            <tr>
                <td><?= $row['nama']; ?></td>
                <td>Rp <?= number_format($row['harga'], 2, ',', '.'); ?></td>
                <td><?= $row['quantity']; ?></td>
                <td>Rp <?= number_format($total_harga, 2, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="3"><strong>Total Belanja</strong></td>
                <td><strong>Rp <?= number_format($total_belanja, 2, ',', '.'); ?></strong></td>
            </tr>
        </table>
    <?php else: ?>
        <p>Keranjang Anda kosong!</p>
    <?php endif; ?>

    <a href="halaman.php">Lanjut Belanja</a>
</body>
</html>
