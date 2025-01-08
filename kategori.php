<?php 
require 'connection/koneksi.php';
$kategoriId = $_GET['kategori'] ?? null;
$queryProduk = "SELECT * FROM produk";
if ($kategoriId) {
    $queryProduk .= " WHERE id_kategori = " . intval($kategoriId);
}
$produkResult = mysqli_query($conn, $queryProduk);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/kategori.css">
</head>
<style>

</style>

<body>


<?php
$queryKategori = "SELECT * FROM kategori";
$kategoriResult = mysqli_query($conn, $queryKategori);
?>

<div class="container-category">
<!-- <h4 class="text-black">Pilih Kategori</h4> -->
<ul class="category">
<button class="item" style="background-color: gray;" data-link="hasil.php?keyword=">
            <a href="hasil.php?keyword=" class="all">
                <i class="fas fa-th-large kategori-icon"></i> Semua
            </a>
        </button>
        
        <!-- Tombol kategori dari database -->
        <?php while ($kategori = mysqli_fetch_assoc($kategoriResult)): ?>
            <button class="item" data-link="hasil.php?keyword=<?= urlencode($kategori['nama_kategori']); ?>">
                <a href="hasil.php?keyword=<?= urlencode($kategori['nama_kategori']); ?>" class="name-category">
                    <i class="<?= htmlspecialchars($kategori['icon']); ?> kategori-icon"></i>
                    <?= htmlspecialchars($kategori['nama_kategori']); ?>
                </a>
            </button>
        <?php endwhile; ?>
 

</ul>

</div>

<script>
        document.querySelectorAll('.item').forEach(button => {
        button.addEventListener('click', function() {
            const link = this.getAttribute('data-link'); // Ambil URL dari atribut data-link
            window.location.href = link; // Arahkan pengguna ke URL
        });
    });
</script>

</body>

</html>