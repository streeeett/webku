<?php
require '../connection/koneksi.php';
session_start();

$id_pesanan = intval($_GET['id_pesanan']); // Pastikan id_pesanan berupa angka

// Update status pembayaran
$query = "UPDATE pesanan SET status_pembayaran = 'Lunas' WHERE id_pesanan = $id_pesanan";
if (mysqli_query($conn, $query)) {
    echo "<script>alert('Pembayaran berhasil dikonfirmasi.'); window.location.href = 'admin_pesanan.php';</script>";
} else {
    echo "<script>alert('Gagal mengonfirmasi pembayaran.'); window.location.href = 'admin_pesanan.php';</script>";
}
?>
