<?php
session_start();
require '../connection/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

// Ambil ID user dari sesi
$id_user = $_SESSION['id_user'];

// Cek apakah produk dan kuantitas sudah diterima
if (isset($_POST['add_to_cart']) && isset($_POST['id_produk']) && isset($_POST['quantity'])) {
    $id_produk = $_POST['id_produk'];
    $quantity = $_POST['quantity'];

    // Query untuk memasukkan produk ke keranjang
    $query = "INSERT INTO keranjang (id_user, id_produk, quantity) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iii', $id_user, $id_produk, $quantity);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Produk berhasil ditambahkan ke keranjang!'); window.location.href='keranjang.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan produk ke keranjang.');</script>";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('Data produk tidak lengkap.');</script>";
}

mysqli_close($conn);
?>
