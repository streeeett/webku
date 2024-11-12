<?php
session_start();
require '../connection/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    header("location:login.php?pesan=harus_login");
    exit;
}

// Tangkap data dari URL
$id_user = $_SESSION['id_user'];
$id_produk = $_GET['id_produk'];

// Hapus data terkait di keranjang
$queryDeleteKeranjang = "DELETE FROM keranjang WHERE id_produk = $id_produk";
mysqli_query($conn, $queryDeleteKeranjang);

// Hapus varian yang tidak ada di array input
$queryDeleteVarian = "DELETE FROM varian WHERE id_produk = $id_produk";
mysqli_query($conn, $queryDeleteVarian);


if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Produk berhasil dihapus dari keranjang!'); window.location.href='keranjang.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus produk dari keranjang.'); window.location.href='keranjang.php';</script>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
