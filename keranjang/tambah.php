<?php
require '../connection/koneksi.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php?pesan=harus_login");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_produk = $_POST['id_produk'];
$id_varian = isset($_POST['id_varian']) ? $_POST['id_varian'] : null;
$quantity = $_POST['quantity'];

// Cek apakah produk dengan varian tersebut sudah ada di keranjang
$query_check = "
    SELECT quantity 
    FROM keranjang 
    WHERE id_user = ? 
    AND id_produk = ? 
    AND (id_varian = ? OR (id_varian IS NULL AND ? IS NULL))";
$stmt_check = $conn->prepare($query_check);
$stmt_check->bind_param("iiii", $id_user, $id_produk, $id_varian, $id_varian);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Jika produk sudah ada, update quantity-nya
    $row = $result_check->fetch_assoc();
    $new_quantity = $row['quantity'] + $quantity;

    $query_update = "
        UPDATE keranjang 
        SET quantity = ? 
        WHERE id_user = ? 
        AND id_produk = ? 
        AND (id_varian = ? OR (id_varian IS NULL AND ? IS NULL))";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bind_param("iiiii", $new_quantity, $id_user, $id_produk, $id_varian, $id_varian);
    $stmt_update->execute();
} else {
    // Jika produk belum ada, tambahkan sebagai item baru
    $query_insert = "
        INSERT INTO keranjang (id_user, id_produk, id_varian, quantity) 
        VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($query_insert);
    $stmt_insert->bind_param("iiii", $id_user, $id_produk, $id_varian, $quantity);
    $stmt_insert->execute();
}

// Redirect ke halaman keranjang setelah berhasil
header("Location: keranjang.php");
exit;
?>
