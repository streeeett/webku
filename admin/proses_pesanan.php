<?php
require '../connection/koneksi.php';
session_start();

// Pastikan admin sudah login
if ($_SESSION['role'] != "admin") {
    header("location:../logreg/login.php?");
    exit;
}

// Pastikan ada id_pesanan dan status
if (!isset($_GET['id_pesanan']) || !isset($_GET['status'])) {
    header("Location: admin_pesanan.php?pesan=error");
    exit;
}

// Sanitasi input
$id_pesanan = intval($_GET['id_pesanan']);
$status = mysqli_real_escape_string($conn, $_GET['status']);

// Perbarui status pesanan
$query = "UPDATE pesanan SET status_pesanan = '$status' WHERE id_pesanan = $id_pesanan";

if (mysqli_query($conn, $query)) {
    header("Location: admin_pesanan.php?pesan=update_sukses");
} else {
    header("Location: admin_pesanan.php?pesan=update_gagal");
}
exit;
?>
