<?php
// Koneksi ke database
require 'connection/koneksi.php';

// Cek apakah ID ada di URL
if (isset($_GET['id_produk'])) {
    // Ambil ID dari URL
    $id_produk = $_GET['id_produk'];

    // Query untuk mendapatkan data sesuai ID
    $query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id_produk");

    // Cek apakah data ditemukan
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
    } else {
        echo "row tidak ditemukan!";
        exit;
    }
} else {
    echo "barang tidak ada!";
    exit;
}

$role = $_SESSION['role'] ?? 'guest'; // Possible values: 'admin', 'customer', 'guest'

?>

<?php 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Deskripsi</title>
    <link rel="stylesheet" href="deskripsi.css">
</head>



<link rel="stylesheet" href="style/deskripsi.css">
<body>

<div class="deskripsi">
        <div class="kartu">
        <img src="halaman/img/<?= $row['gambar']; ?>" alt="<?= $row['nama']; ?>">
            <div class="isi">
                <h2><?= htmlspecialchars($row['nama']); ?></h2>
                <h4>Harga: Rp <?= number_format($row['harga'], 0, ',', '.'); ?></h4>
                <div class="deskripsi-container">
                    <p><?= htmlspecialchars($row['deskripsi']); ?></p>
                </div>
                <h4>Kategori: <?= htmlspecialchars($row['kategori']); ?></h4>

                <!-- Hidden Inputs untuk Mengirim Data Produk -->
                <input type="hidden" name="id_produk" value="<?= $row['id_produk']; ?>">
                <input type="hidden" name="nama" value="<?= htmlspecialchars($row['nama']); ?>">
                <input type="hidden" name="harga" value="<?= $row['harga']; ?>">

                <?php if ($role === 'admin'): ?>
                    <!-- Input Kuantitas -->
                <label for="kuantitas">Kuantitas:</label>
                <input type="number" name="kuantitas" value="1" min="1" required>
                <!-- Tombol Tambah ke Keranjang -->
                <input type="submit" class="btn" value="Tambah ke Keranjang" name="add_to_cart">

            <?php elseif ($role === 'customer'): ?>
                
                    <!-- Input Kuantitas -->
                <label for="kuantitas">Kuantitas:</label>
                <input type="number" name="kuantitas" value="1" min="1" required>

                <!-- Tombol Tambah ke Keranjang -->
                <input type="submit" class="btn" value="Tambah ke Keranjang" name="add_to_cart">

                
                <?php else: ?>
                        <?php endif; ?>    
            
            </div>
        </div>
    </div>

</body>
</html>

