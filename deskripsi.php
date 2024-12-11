<?php
// Koneksi ke database
require 'connection/koneksi.php';

// Cek apakah ID ada di URL
if (isset($_GET['id_produk'])) {
    // Ambil ID dari URL
    $id_produk = $_GET['id_produk'];

    // Query untuk mendapatkan data produk sesuai ID
    $query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id_produk");

    // Query untuk mendapatkan varian rasa sesuai ID produk
    $varianQuery = mysqli_query($conn, "SELECT * FROM varian WHERE id_produk = $id_produk");

    // Cek apakah data produk ditemukan
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $varianList = mysqli_fetch_all($varianQuery, MYSQLI_ASSOC);
    } else {
        echo "row tidak ditemukan!";
        exit;
    }
} else {
    echo "barang tidak ada!";
    exit;
}

// Cek apakah tombol 'Tambah ke Keranjang' ditekan
$role = $_SESSION['role'] ?? 'guest'; // Possible values: 'admin', 'customer', 'guest'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Deskripsi</title>
    <link rel="stylesheet" href="style/deskripsi.css">
</head>
<body style="background: linear-gradient(#ff7f00, #fbf400);">

<form action="keranjang/tambah.php" method="post">
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

                <!-- Pilihan Varian Rasa -->
                <label for="varian">Pilih Varian Rasa:</label>
                <select class="form-select" name="id_varian" id="id_varian" required>
        <?php
        // Query untuk mendapatkan varian produk dari database
        $varianQuery = "SELECT id_varian, nama_varian FROM varian WHERE id_produk = ?";
        $varianStmt = $conn->prepare($varianQuery);
        $varianStmt->bind_param('i', $row['id_produk']);
        $varianStmt->execute();
        $varianResult = $varianStmt->get_result();
        while ($varianRow = $varianResult->fetch_assoc()) {
            echo "<option value='{$varianRow['id_varian']}'>{$varianRow['nama_varian']}</option>";
        }
        ?>
    </select>

                <?php if ($role === 'admin' || $role === 'customer'): ?>
                    <!-- Input quantity -->
                    <label for="quantity">Quantity:</label>
                    <input class="form-control" type="number" name="quantity" value="1" min="1" required>

                    <!-- Tombol Tambah ke Keranjang -->
                    <input type="submit" class="btn btn-info" value="Tambah ke Keranjang" name="add_to_cart">
                <?php endif; ?>    

            </div>
        </div>
    </div>
</form>

</body>
</html>
