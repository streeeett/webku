<?php
require '../connection/koneksi.php';
session_start();

// Pastikan pengguna adalah admin
if (isset($_SESSION['customer'])) {
    header("Location: ../login.php?pesan=akses_ditolak");
    exit;
}

// Cek apakah ada id_pesanan yang dikirim
if (isset($_GET['id_pesanan'])) {
    $id_pesanan = intval($_GET['id_pesanan']); // Pastikan id_pesanan adalah integer

    // Hapus pesanan berdasarkan ID
    $query = "DELETE FROM pesanan WHERE id_pesanan = $id_pesanan";
    if (mysqli_query($conn, $query)) {
        header("Location: admin_pesanan.php?pesan=pesanan_terhapus");
    } else {
        header("Location: admin_pesanan.php?pesan=pesanan_gagal_hapus");
    }
} else {
    header("Location: admin_pesanan.php?pesan=tidak_ada_id");
}
?>
