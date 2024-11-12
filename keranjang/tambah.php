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

// Cek apakah produk, varian, dan kuantitas sudah diterima
if (isset($_POST['add_to_cart']) && isset($_POST['id_produk']) && isset($_POST['quantity']) && isset($_POST['id_varian'])) {
    $id_produk = $_POST['id_produk'];
    $id_varian = $_POST['id_varian']; // Tambahkan ini untuk menangani varian
    $quantity = $_POST['quantity'];

    // Query untuk memasukkan produk beserta variannya ke keranjang
    $query = "INSERT INTO keranjang (id_user, id_produk, id_varian, quantity) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iiii', $id_user, $id_produk, $id_varian, $quantity);

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
