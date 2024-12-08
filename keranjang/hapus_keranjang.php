<?php
session_start();
require '../connection/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    header("location:login.php?pesan=harus_login");
    exit;
}

// Tangkap data dari URL dan validasi
$id_user = intval($_SESSION['id_user']);
$id_produk = isset($_GET['id_produk']) ? intval($_GET['id_produk']) : 0;

// Periksa apakah $id_produk valid
if ($id_produk > 0) {
    // Hapus produk dari keranjang
    $queryDeleteKeranjang = "DELETE FROM keranjang WHERE id_user = $id_user AND id_produk = $id_produk";
    $deleteKeranjangSuccess = mysqli_query($conn, $queryDeleteKeranjang);

    // Cek apakah operasi berhasil
    if ($deleteKeranjangSuccess) {
        echo "<script>alert('Produk berhasil dihapus dari keranjang!'); window.location.href='keranjang.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus produk dari keranjang.'); window.location.href='keranjang.php';</script>";
    }
}

mysqli_close($conn);
?>
