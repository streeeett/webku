<?php 
require 'connection/koneksi.php';
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
</head>

<style>
    .produk{
        background: linear-gradient(#ff7f00, #fbf400);
        padding: 1px;
    }

    .kaki{
        margin-top: -25px;
    }
</style>

<body>

<?php 
        include 'body/navbar.php';
    ?>
    <div class="karosel">
        <?php include 'body/carousel.php'; ?>
    </div>

    <div class="produk">
        <?php include 'halaman/produk.php'; ?>
    </div>

    <div class="kaki">
        <?php include 'body/footer.php'; ?>
    </div>

    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>