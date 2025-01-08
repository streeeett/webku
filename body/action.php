<?php 
require 'connection/koneksi.php';
$role = $_SESSION['role'] ?? 'guest'; // Possible values: 'admin', 'customer', 'guest'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

</head>
<style>
    .kategori-icon {
        margin-right: 5px;
        margin-top: 30px;
    }

    .kotak{
        /* border-radius: 100px; */
        height: 100px;
        align-items: center;
        font-size: medium;
        width: 100px;
        height: 60px;
    }
</style>

<body>



<div class="mb-4">
<h4 class="text-black">Aksi Cepat</h4>
<ul class="list-inline">

        <?php if ($role === 'admin'): ?>

          <li class="list-inline-item">
        <a href="../halaman/tambah.php" class="kotak btn btn-secondary">
             Tambah Produk
        </a>
    </li>

        <li class="list-inline-item">
            <a href="../admin/tambah_kategori.php" class="kotak btn btn-success">
                <i class=" text-center kategori-icon"></i>Tambah Kategori
            </a>
        </li>

        <li class="list-inline-item">
        <a href="../keranjang/keranjang.php" class="kotak btn btn-secondary">
             Keranjang
        </a>
    </li>

        <li class="list-inline-item">
            <a href="../cek/pesanan.php" class="kotak btn btn-success">
                <i class=" text-center kategori-icon"></i>Pesanan
            </a>
        </li>
               
<?php elseif ($role === 'customer'): ?>

  <li class="list-inline-item">
        <a href="../keranjang/keranjang.php" class="kotak btn btn-secondary">
             Keranjang
        </a>
    </li>

        <li class="list-inline-item">
            <a href="../cek/pesanan.php" class="kotak btn btn-success">
                <i class=" text-center kategori-icon"></i>Pesanan
            </a>
        </li>
        
<?php else: ?>
                   
        <?php endif; ?>

   

</ul>
</div>


</body>

</html>