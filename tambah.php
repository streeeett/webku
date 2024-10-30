<?php
require '../connection/koneksi.php'; // Koneksi database
session_start(); // Pastikan session berjalan

// Ambil id_user dari session (misal user login)
$id_user = $_SESSION['id_user'];

// Ambil id_produk dari parameter GET
if (isset($_GET['id_produk'])) {
    $id_produk = $_GET['id_produk'];

    // Cek apakah produk sudah ada di keranjang
    $query = "SELECT * FROM cart WHERE id_user = ? AND id_produk = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $id_user, $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika produk sudah ada, update kuantiti
        $query = "UPDATE cart SET kuantiti = kuantiti + 1 WHERE id_user = ? AND id_produk = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $id_user, $id_produk);
    } else {
        // Jika produk belum ada, tambahkan ke keranjang
        $query = "INSERT INTO cart (id_user, id_produk, kuantiti) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $id_user, $id_produk);
    }

    if ($stmt->execute()) {
        echo "<script>
            alert('Produk berhasil ditambahkan ke keranjang!');
            document.location.href = 'cart.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menambahkan produk!');
            document.location.href = 'halaman.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID produk tidak ditemukan!');
        document.location.href = 'halaman.php';
    </script>";
}
?>
