<?php
session_start();
require '../connection/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    header("location:login.php?pesan=harus_login");
    exit;
}

// Tangkap data dari URL dan validasi
$id_user = $_SESSION['id_user'];
$id_produk = $_GET['id_produk'];
$id_produk = isset($_GET['id_produk']) ? (int) $_GET['id_produk'] : 0;

// Periksa apakah $id_produk valid
if ($id_produk > 0) {
    // Hanya menghapus produk dari keranjang, tidak menghapus data varian
    $queryDeleteKeranjang = "DELETE FROM keranjang WHERE id_user = ? AND id_produk = ?";
    $stmtKeranjang = mysqli_prepare($conn, $queryDeleteKeranjang);
    mysqli_stmt_bind_param($stmtKeranjang, 'ii', $id_user, $id_produk);
    $deleteKeranjangSuccess = mysqli_stmt_execute($stmtKeranjang);
    mysqli_stmt_close($stmtKeranjang);

    // Cek apakah operasi berhasil
    if ($deleteKeranjangSuccess) {
        echo "<script>alert('Produk berhasil dihapus dari keranjang!'); window.location.href='keranjang.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus produk dari keranjang.'); window.location.href='keranjang.php';</script>";
    }
} 

mysqli_close($conn);
?>
`
