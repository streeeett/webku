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

// Hapus produk dari keranjang
// $query = "DELETE FROM keranjang WHERE id_user = ? AND id_produk = ?";
// $stmt = mysqli_prepare($conn, $query);
// mysqli_stmt_bind_param($stmt, "ii", $id_user, $id_produk);


    $id_produk = $_GET['id_produk'];
    mysqli_query($conn, "DELETE FROM `keranjang` WHERE id_produk = '$id_produk'");
    header('location:keranjang.php');
 
 
 
 ?>
