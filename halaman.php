<?php 
require 'connection/koneksi.php';
session_start();
$role = $_SESSION['role'] ?? 'guest'; // Possible values: 'admin', 'customer', 'guest'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoU</title>
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

</head>

<style>
    .produk{
        background: linear-gradient(#d9d8d1, #fbf400);
        padding: 1px;
    }

    .karosel{
        margin-top: 10px;   
        margin-bottom: -20px;
    }

    .karosel-container{
        display: flex;
    }

    .karosel-container div h1{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-left: 25px;
        margin-top: 10px;   
        width: 600px;
        height: 100px;

    }

    .karosel-container div p{
        font-size: 25px;
    }

    .kategori{
        background-color: #d9d8d1;
        margin-top: 20px;
        padding-left: 10px;
        padding-top: 30px;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .kaki{
        margin-top: -25px;
    }
</style>

<body>

     <?php include 'body/navbar.php';?>

<div class="karosel-container">
    <div class="karosel">
        <?php include 'body/carousel.php'; ?>
    </div>

    <div>
        <h1>HELLOW WIRD</h1>
        <p>Bingung mau ngapain? Belanja di ShoU aja!</p>
    </div>
</div>


      <div class="kategori">
        <?php include 'kategori.php'; ?>
    </div>

    <div class="produk">
        <?php include 'halaman/produk.php'; ?>
    </div>


    <div class="kaki"> <?php include 'body/footer.php'; ?> </div>

    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="js/carousel.js"></script>
</body>
</html>