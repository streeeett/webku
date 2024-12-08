<?php
require 'connection/koneksi.php';

// Ambil keyword dari parameter GET
$keyword = $_GET['keyword'] ?? '';

if (!$keyword) {
    header('Location: halaman.php'); // Kembali ke home jika keyword kosong
    exit;
}

// Fungsi pencarian produk
function cari($keyword) {
    global $conn;
    $query = "SELECT * FROM produk WHERE 
              nama LIKE '%$keyword%' OR 
              kategori LIKE '%$keyword%' OR 
              harga LIKE '%$keyword%'";
    return mysqli_query($conn, $query);
}

$hasil = cari($keyword);

$role = $_SESSION['role'] ?? 'guest'; // Possible values: 'admin', 'customer', 'guest'

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Pencarian</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
        body {
            /* background-color: #f8f9fa; */
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
<body style="background: linear-gradient(#ff7f00, #fbf400);">
  <?php include 'body/navbar.php'; ?>

  <div class="container mt-5">
    <h2 class="fs-5 fw-bold">Hasil Pencarian: "<?php echo htmlspecialchars($keyword); ?>"</h2>
    <?php if (mysqli_num_rows($hasil) > 0): ?>
      <div class="row">
        <?php while ($produk = mysqli_fetch_assoc($hasil)): ?>
          <div class="col-md-4">
            <div class="card mb-4">
            <img src="halaman/img/<?= htmlspecialchars($produk['gambar']); ?>" class="card-img-top" alt="<?= htmlspecialchars($produk['nama']); ?>">
              <div class="card-body bg-warning-subtle">
                <h5 class="card-title"><?= htmlspecialchars($produk['nama']); ?></h5>
                <p class="card-text">Kategori: <?= htmlspecialchars($produk['kategori']); ?></p>
                <p class="card-text">Harga: Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></p>
              </div>
              <div class="card-footer bg-warning-subtle">
                            <?php if ($role === 'admin'): ?>
                                <a href="halaman/edit.php?id_produk=<?= $produk['id_produk']; ?>" class="btn btn-warning btn-custom"><i class="fa-solid fa-pen-to-square"></i> Ubah</a>
                                <a href="detail_produk.php?id_produk=<?= $produk['id_produk']; ?>" class="btn btn-primary btn-custom"><i class="fa-solid fa-eye"></i> Lihat</a>
                            <a href="halaman/hapus.php?id_produk=<?= $produk['id_produk']; ?>" class="btn btn-danger btn-custom"><i class="fa-solid fa-trash"></i> Hapus</a>
            <?php elseif ($role === 'customer'): ?>
                <a href="detail_produk.php?id_produk=<?= $produk['id_produk']; ?>" class="btn btn-primary btn-custom"><i class="fa-solid fa-eye"></i> Lihat</a>

            <?php else: ?>
                <a href="detail_produk.php?id_produk=<?= $produk['id_produk']; ?>" class="btn btn-primary btn-custom"><i class="fa-solid fa-eye"></i> Lihat</a>

            <?php endif; ?>
                        </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p>Tidak ada produk yang ditemukan.</p>
    <?php endif; ?>
    <a href="halaman.php" class="btn btn-secondary mt-3">Kembali</a>
  </div>

  <?php include 'body/footer.php'; ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

