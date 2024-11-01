<?php
session_start();
require '../connection/koneksi.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php?pesan=harus_login");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_produk = $_POST['id_produk'];
$quantity = $_POST['quantity'];

// Update quantity di tabel keranjang
$update_keranjang = mysqli_query($conn, "UPDATE `keranjang` SET quantity = '$quantity' WHERE id_user = '$id_user' AND id_produk = '$id_produk'");
   if($update_keranjang){
      header('location:keranjang.php');
   }else {
    echo "Gagal memperbarui keranjang.";
}


?>
