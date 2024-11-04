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
<<<<<<< HEAD
$query = "UPDATE keranjang SET quantity = ? WHERE id_user = ? AND id_produk = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('iii', $quantity, $id_user, $id_produk);

if ($stmt->execute()) {
    header("Location: keranjang.php");
} else {
    echo "Gagal memperbarui keranjang.";
}

$stmt->close();
$conn->close();
=======
$update_keranjang = mysqli_query($conn, "UPDATE `keranjang` SET quantity = '$quantity' WHERE id_user = '$id_user' AND id_produk = '$id_produk'");
   if($update_keranjang){
      header('location:keranjang.php');
   }else {
    echo "Gagal memperbarui keranjang.";
}


>>>>>>> a5f4d975c6beefa0110785810ba45fb2446ebd54
?>
