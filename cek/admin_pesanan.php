<?php
require '../connection/koneksi.php';
session_start();

// Pastikan admin sudah login
if ($_SESSION['role'] != "admin") {
    header("location:../logreg/login.php");
}

// Ambil semua pesanan
$query = "
    SELECT pesanan.*, users.username 
    FROM pesanan
    JOIN users ON pesanan.id_user = users.id_user
    ORDER BY pesanan.tanggal_pesanan DESC";
$result = $conn->query($query);

// Ambil detail barang untuk semua pesanan
$detail_query = "
    SELECT dp.id_pesanan, p.nama AS nama_produk, v.nama_varian, dp.quantity 
    FROM detail_pesanan dp
    JOIN produk p ON dp.id_produk = p.id_produk
    LEFT JOIN varian v ON dp.id_varian = v.id_varian";
$details = $conn->query($detail_query)->fetch_all(MYSQLI_ASSOC);

// Kelompokkan detail barang berdasarkan id_pesanan
$grouped_details = [];
foreach ($details as $detail) {
    $grouped_details[$detail['id_pesanan']][] = $detail;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-left">Kelola Pesanan</h1>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>ID User</th>
                    <th>Nama Pemesan</th>
                    <th>Total Harga</th>
                    <th>Status Pesanan</th>
                    <th>Detail Barang</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_pesanan']; ?></td>
                        <td><?= $row['id_user']; ?></td>
                        <td><?= htmlspecialchars($row['username']); ?></td>
                        <td>Rp <?= number_format($row['total_harga'], 2, ',', '.'); ?></td>
                        <td><?= $row['status_pesanan']; ?></td>
                        <td>
                            <button 
                                class="btn btn-info btn-sm" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#detail-<?= $row['id_pesanan']; ?>" 
                                aria-expanded="false" 
                                aria-controls="detail-<?= $row['id_pesanan']; ?>">
                                Lihat Barang
                            </button>
                            <div class="collapse mt-2" id="detail-<?= $row['id_pesanan']; ?>">
                                <ul class="list-group">
                                    <?php if (isset($grouped_details[$row['id_pesanan']])): ?>
                                        <?php foreach ($grouped_details[$row['id_pesanan']] as $item): ?>
                                            <li class="list-group-item">
                                                <?= htmlspecialchars($item['nama_produk']); ?> - 
                                                Varian: <?= htmlspecialchars($item['nama_varian'] ); ?> - 
                                                Quantity: <?= $item['quantity']; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li class="list-group-item">Tidak ada detail barang.</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </td>
                        
                        <td>
    <?php if ($row['bukti_transfer']): ?>
        <a href="uploads/<?= $row['bukti_transfer']; ?>" target="_blank">Lihat Bukti Transfer</a>
    <?php else: ?>
        <span>Belum Ada Bukti</span>
    <?php endif; ?>
</td>
<td>
    <?php if ($row['status_pembayaran'] === 'Menunggu Konfirmasi'): ?>
        <a href="konfirmasi_pembayaran.php?id_pesanan=<?= $row['id_pesanan']; ?>" class="btn btn-primary btn-sm">Konfirmasi</a>
    <?php endif; ?>
</td>


                        <td>
                            <?php if ($row['status_pesanan'] === 'Dipesan'): ?>
                                <a href="proses_pesanan.php?id_pesanan=<?= $row['id_pesanan']; ?>&status=Diproses" class="btn btn-primary btn-sm">Proses</a>
                            <?php elseif ($row['status_pesanan'] === 'Diproses'): ?>
                                <a href="proses_pesanan.php?id_pesanan=<?= $row['id_pesanan']; ?>&status=Dikirim" class="btn btn-warning btn-sm">Kirim</a>
                            <?php elseif ($row['status_pesanan'] === 'Dikirim'): ?>
                                <a href="proses_pesanan.php?id_pesanan=<?= $row['id_pesanan']; ?>&status=Selesai" class="btn btn-success btn-sm">Selesaikan</a>
                            <?php endif; ?>
                            <a href="hapus_pesanan.php?id_pesanan=<?= $row['id_pesanan']; ?>" 
                               onclick="return confirm('Yakin ingin menghapus pesanan ini?')" 
                               class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                        
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="../halaman.php" class="btn btn-warning">Kembali</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
