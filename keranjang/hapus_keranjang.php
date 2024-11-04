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
<<<<<<< HEAD
$id_produk = $_GET['id_produk'];

// Hapus produk dari keranjang
$query = "DELETE FROM keranjang WHERE id_user = ? AND id_produk = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $id_user, $id_produk);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Produk berhasil dihapus dari keranjang!'); window.location.href='keranjang.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus produk dari keranjang.'); window.location.href='keranjang.php';</script>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
=======

// Hapus produk dari keranjang
// $query = "DELETE FROM keranjang WHERE id_user = ? AND id_produk = ?";
// $stmt = mysqli_prepare($conn, $query);
// mysqli_stmt_bind_param($stmt, "ii", $id_user, $id_produk);


    $id_produk = $_GET['id_produk'];
    mysqli_query($conn, "DELETE FROM `keranjang` WHERE id_produk = '$id_produk'");
    header('location:keranjang.php');
 
 
 
 ?>
>>>>>>> a5f4d975c6beefa0110785810ba45fb2446ebd54
