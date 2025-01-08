<?php 
require 'connection/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<link rel="stylesheet" href="style/index.css">
<body style="background-color: #fed495;">
<?php 
include 'body/navbar.php';
// include 'body/carousel.php';
// include 'body/gambar.php';
?>
<div class="back" style="width: 100%; height:100%;">

    <div class="text">
        <h1>
            Selamat Datang Di ShoU
        </h1>
        <p class="tex2">Nikmati Aneka Makanan Dan Minuman Unggulan Dari Kami</p>
        <button>
            <b>
                <a href="logreg/login.php">Login Untuk Melanjutkan</a>
            </b>
        </button>
    </div>
</div>


<div class="back2" >
    <img src="https://c1.wallpaperflare.com/preview/114/619/629/designer-desk-gardens-home-office.jpg" alt="">

    <div class="desk">
        <h1><b>Salam Hangat</b></h1>
        <p>Selamat datang di ShoU Store, tempat dimana kalian bisa belanja makanan dan minuman buatan tangan-tangan yang terampil</p>
        
    </div>
</div>


<!-- <div class="back3" >
    <img src="img/gantengnyoo.jpg" alt="">

    <div class="gambar">
        <h1><b>HELLO WIRD</b></h1>
        <p>Selamat datang di ShoU Store, tempat dimana kalian bisa belanja makanan dan minuman buatan tangan-tangan yang terampil</p>
        
    </div>

    <img src="img/gantengnyoo.jpg" alt="">

<div class="gambar">
    <h1><b>HELLO WIRD</b></h1>
    <p>Selamat datang di ShoU Store, tempat dimana kalian bisa belanja makanan dan minuman buatan tangan-tangan yang terampil</p>
    
</div>  
</div> -->



<?php include 'body/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>