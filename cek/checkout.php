<?php
require '../connection/koneksi.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../logreg/login.php?pesan=harus_login");
    exit;
}

$id_user = $_SESSION['id_user'];

// Query untuk mendapatkan total belanja
$query = "
    SELECT produk.harga, keranjang.quantity 
    FROM keranjang
    JOIN produk ON keranjang.id_produk = produk.id_produk
    WHERE keranjang.id_user = $id_user";
$result = mysqli_query($conn, $query);

$total_belanja = 0;
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total_belanja += $row['harga'] * $row['quantity'];
    }
}

// Jika keranjang kosong, redirect ke halaman keranjang
if ($total_belanja == 0) {
    header("Location: keranjang.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/checkout.css">
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <form action="proses_checkout.php" method="post">
            <div>
                <label for="alamat_pengiriman" class="form-label">Alamat Pengiriman</label>
                <textarea class="form-control" name="alamat_pengiriman" id="alamat_pengiriman" rows="3" required></textarea>
            </div>
            <div>
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select class="form-select" name="metode_pembayaran" id="metode_pembayaran" required>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="COD">COD</option>
                </select>
            </div>
            <div class="total-belanja">
                Total Belanja: Rp <?= number_format($total_belanja, 2, ',', '.'); ?>
            </div>
            <button type="submit" class="btn">Proses Checkout</button>
        </form>
    </div>
</body>
</html>
