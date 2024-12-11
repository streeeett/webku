<?php 
require 'connection/koneksi.php';



// Pagination configuration (Optional)
$limit = 6; // Jumlah card per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$start = ($page > 1) ? ($page * $limit) - $limit : 0; // Mulai data pada halaman saat ini

// Mengambil data dari database
$result = mysqli_query($conn, "SELECT * FROM produk");
$total = mysqli_num_rows($result); // Total jumlah card

$pages = ceil($total / $limit); // Total halaman
// Query produk dari database
$result = mysqli_query($conn, "SELECT * FROM produk LIMIT $start, $limit");
$total = mysqli_num_rows($result);

$role = $_SESSION['role'] ?? 'guest'; // Possible values: 'admin', 'customer', 'guest'

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>

    <!-- Bootstrap CSS -->

    <style>
        body {
            background: linear-gradient(180deg, #e27b15, #222121);
            font-family: Arial, sans-serif;
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        .card {
            margin-bottom: 20px;
        }
        .btn-custom {
            margin: 5px;
        }
    </style>
</head>
<body class="bg-opacity-75">

<div class="container my-5">

    <?php if ($total > 0): ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="halaman/img/<?= htmlspecialchars($row['gambar']); ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama']); ?>">
                        <div class="card-body bg-warning-subtle">
                            <h5 class="card-title"><?= htmlspecialchars($row['nama']); ?></h5>
                            <p class="card-text">Rp. <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                            <p class="card-text"><small class="text-muted"><?= htmlspecialchars($row['kategori']); ?></small></p>
                        </div>
                        <div class="card-footer bg-warning-subtle">
                            <?php if ($role === 'admin'): ?>
                                <a href="halaman/edit.php?id_produk=<?= $row['id_produk']; ?>" class="btn btn-warning btn-custom "><i class="fa-solid fa-pen-to-square"></i> Ubah</a>
                                <a href="detail_produk.php?id_produk=<?= $row['id_produk']; ?>" class="btn btn-primary btn-custom"><i class="fa-solid fa-eye"></i> Lihat</a>
                            <a href="halaman/hapus.php?id_produk=<?= $row['id_produk']; ?>" class="btn btn-danger btn-custom"><i class="fa-solid fa-trash"></i> Hapus</a>
            <?php elseif ($role === 'customer'): ?>
                <a href="detail_produk.php?id_produk=<?= $row['id_produk']; ?>" class="btn btn-primary btn-custom"><i class="fa-solid fa-eye"></i> Lihat</a>

            <?php else: ?>
                <a href="detail_produk.php?id_produk=<?= $row['id_produk']; ?>" class="btn btn-primary btn-custom"><i class="fa-solid fa-eye"></i> Lihat</a>

            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center mt-4">Tidak ada produk yang tersedia.</div>
    <?php endif; ?>

    <div class="pagination justify-content-center mt-4 border-dark">

        <?php if ($page > 1): ?>
        <li class="page-item">
            <a class="page-link" href="?page=<?= $page - 1 ?>"><i class="fa-solid fa-chevron-left"></i> Previous</a>
        </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $pages; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a class="page-link " href="?page=<?= $i ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>

        <?php if ($page < $pages): ?>
        <li class="page-item">
            <a class="page-link" href="?page=<?= $page + 1 ?>">Next <i class="fa-solid fa-chevron-right"></i></a>
        </li>
        <?php endif; ?>
        
    </div>
        
    
</div>

<!-- Bootstrap JS (Optional for interactivity) -->

</body>
</html>
