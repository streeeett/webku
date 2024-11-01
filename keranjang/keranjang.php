<?php
require '../connection/koneksi.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php?pesan=harus_login");
    exit;
}

// Ambil id_user dari session
$id_user = $_SESSION['id_user'];

// Query untuk mengambil produk yang ada di keranjang
$query = "
    SELECT produk.id_produk, produk.nama, produk.gambar, produk.harga, keranjang.quantity
    FROM keranjang
    JOIN produk ON keranjang.id_produk = produk.id_produk
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
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Keranjang Belanja</h1>

        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Foto Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Quantity</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_belanja = 0;
                    while ($row = $result->fetch_assoc()): 
                        $total_harga = $row['harga'] * $row['quantity'];
                        $total_belanja += $total_harga;
                    ?>
                    <tr>
                        <td>
                            <img src="../halaman/img/<?= htmlspecialchars($row['gambar']); ?>" alt="<?= htmlspecialchars($row['nama']); ?>" style="width: 80px;">
                        </td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td>Rp <?= number_format($row['harga'], 2, ',', '.'); ?></td>
                        <td>
                            <form action="update_keranjang.php" method="post" class="d-flex">
                                <input type="hidden" name="id_produk" value="<?= $row['id_produk']; ?>">
                                <input type="number" name="quantity" value="<?= $row['quantity']; ?>" min="1" class="form-control" style="width: 70px;">
                                <button type="submit" class="btn btn-primary btn-sm ms-2">Update</button>
                            </form>
                        </td>
                        <td>Rp <?= number_format($total_harga, 2, ',', '.'); ?></td>
                        <td>
                            <a href="hapus_keranjang.php?id_produk=<?= $row['id_produk']; ?>" onclick="return confirm('Yakin ingin menghapus barang ini?')" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total Belanja</strong></td>
                        <td colspan="2"><strong>Rp <?= number_format($total_belanja, 2, ',', '.'); ?></strong></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">Keranjang Anda kosong!</p>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="../halaman.php" class="btn btn-secondary">Lanjut Belanja</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
