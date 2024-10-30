<?php

require '../connection/koneksi.php';


function hapus($id_produk) {
    global $conn; // Mengakses koneksi database dari luar fungsi

    // Sanitasi ID untuk menghindari SQL Injection
    $id_produk = mysqli_real_escape_string($conn, $id_produk);

    // Query untuk menghapus data
    $query = "DELETE FROM produk WHERE id_produk = $id_produk";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        return 1; // Mengembalikan 1 jika berhasil
    } else {
        return 0; // Mengembalikan 0 jika gagal
    }
}

// Penggunaan fungsi hapus
$id_produk = $_GET["id_produk"];
if (hapus($id_produk) > 0) {
    echo "<script>
    alert('berhasil');
    document.location.href = '../halaman.php';
    </script> ";
} else {
    echo "<script>
    alert('gagal menghapus');
    document.location.href = '../halaman.php';
    </script> ";
}
?>
