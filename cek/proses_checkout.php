<?php
require '../connection/koneksi.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php?pesan=harus_login");
    exit;
}

$id_user = intval($_SESSION['id_user']);
$alamat_pengiriman = mysqli_real_escape_string($conn, $_POST['alamat_pengiriman']);
$metode_pembayaran = mysqli_real_escape_string($conn, $_POST['metode_pembayaran']);

// Mulai transaksi database
mysqli_begin_transaction($conn);

try {
    // Hitung total belanja
    $query = "
        SELECT produk.id_produk, produk.harga, keranjang.quantity 
        FROM keranjang
        JOIN produk ON keranjang.id_produk = produk.id_produk
        WHERE keranjang.id_user = $id_user";
    $result = mysqli_query($conn, $query);

    $total_belanja = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $total_belanja += $row['harga'] * $row['quantity'];
    }

    // Simpan ke tabel pesanan
    $query_order = "
        INSERT INTO pesanan (id_user, tanggal_pesanan, total_harga, alamat_pengiriman, metode_pembayaran) 
        VALUES ($id_user, NOW(), $total_belanja, '$alamat_pengiriman', '$metode_pembayaran')";
    mysqli_query($conn, $query_order);
    $id_pesanan = mysqli_insert_id($conn);

    // Simpan detail pesanan
    $result = mysqli_query($conn, $query); // Query ulang data keranjang
    while ($row = mysqli_fetch_assoc($result)) {
        $id_produk = intval($row['id_produk']);
        $quantity = intval($row['quantity']);
        $harga_satuan = floatval($row['harga']);

        $query_detail = "
            INSERT INTO detail_pesanan (id_pesanan, id_produk, quantity, harga_satuan) 
            VALUES ($id_pesanan, $id_produk, $quantity, $harga_satuan)";
        mysqli_query($conn, $query_detail);
    }

    // Hapus keranjang
    $query_delete_cart = "DELETE FROM keranjang WHERE id_user = $id_user";
    mysqli_query($conn, $query_delete_cart);

    mysqli_commit($conn);

    echo "<script>alert('Checkout berhasil!'); window.location.href = 'pesanan.php';</script>";
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "'); window.location.href = 'keranjang.php';</script>";
}
?>
