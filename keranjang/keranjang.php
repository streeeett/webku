<?php
require '../connection/koneksi.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../logreg/login.php?pesan=harus_login");
    exit;
}

// Ambil id_user dari session
$id_user = $_SESSION['id_user'];

// Query untuk mengambil produk yang ada di keranjang beserta varian rasa yang dipilih
$query = "
    SELECT produk.id_produk, produk.nama, produk.gambar, produk.harga, keranjang.quantity, varian.nama_varian 
    FROM keranjang
    JOIN produk ON keranjang.id_produk = produk.id_produk
    LEFT JOIN varian ON keranjang.id_varian = varian.id_varian
    WHERE keranjang.id_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../style/keranjang.css">
</head>
<body style="background: linear-gradient(#edbfac, #dbd8bb);">
    <div class="container-cart">
        <h1 class="cart-title">Keranjang Belanja</h1>

        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                    <tr>
                        <th>Foto Produk</th>
                        <th>Nama Produk</th>
                        <th>Varian</th>
                        <th>Harga</th>
                        <th>Quantity</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                    <?php 
                    $total_belanja = 0;
                    while ($row = $result->fetch_assoc()): 
                        $total_harga = $row['harga'] * $row['quantity'];
                        $total_belanja += $total_harga;
                    ?>
                    <tr>
                        <td>
                            <img src="../halaman/img/<?= htmlspecialchars($row['gambar']); ?>" alt="<?= htmlspecialchars($row['nama']); ?>">
                        </td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['nama_varian']) ?: 'Tidak ada varian'; ?></td> <!-- Tampilkan nama varian -->
                        <td>Rp <?= number_format($row['harga'], 2, ',', '.'); ?></td>
                        <td>
                            <form action="update_keranjang.php" method="post" class="update">
                                <input type="hidden" name="id_produk" value="<?= $row['id_produk']; ?>">
                                <input type="number" name="quantity" value="<?= $row['quantity']; ?>" min="1" class="control" style="width: 70px;">
                                <button type="submit" class="buton"><i class="fa-solid fa-arrows-rotate"></i> Update</button>
                            </form>
                        </td>
                        <td>Rp <?= number_format($total_harga, 2, ',', '.'); ?></td>
                        <td>
                            <a href="hapus_keranjang.php?id_produk=<?= $row['id_produk']; ?>" onclick="return confirm('Yakin ingin menghapus barang ini?')" class="btn btn-danger btn-sm"><i class="fa-thin fa-x"></i> Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="5" class="text-center"><strong>Total Belanja</strong></td>
                        <td colspan="2"><strong>Rp <?= number_format($total_belanja, 2, ',', '.'); ?></strong></td>
                    </tr>
            </table>
        <?php else: ?>
            <p class="text-center fs-4">Keranjang Anda kosong!</p>
            <a href="../halaman.php" class="btn btn-secondary"><i class="fa-solid fa-house"></i> Lanjut Belanja</a>

        <?php endif; ?>

        <?php
// Tambahan tombol checkout
if ($result->num_rows > 0): 
?>
    <div class="text-center mt-4">
        <a href="../cek/checkout.php" class="btn btn-success btn-lg">Checkout</a>
        <a href="../halaman.php" class="btn btn-secondary"><i class="fa-solid fa-house"></i> Lanjut Belanja</a>
    </div>
<?php 
else: 
?><?php 
endif; 
?>

    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
