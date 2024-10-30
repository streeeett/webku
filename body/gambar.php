<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Circle Image Layout</title>
    <style>
        /* CSS untuk lingkaran gambar */
        .circle-image {
            width: 150px; /* Ukuran gambar */
            height: 150px; /* Ukuran gambar */
            border-radius: 50%; /* Membuat gambar berbentuk lingkaran */
            object-fit: cover; /* Menyesuaikan gambar */
            margin: 10px; /* Jarak antara gambar */
        }
    </style>
</head>
<body >
    <div class="container">
        <div class="row">
            <!-- Gambar Lingkaran Kiri Atas -->
            <div class="col-6 text-start">
                <img src="img/baso.jpg" alt="Image 1" class="circle-image">
            </div>
            <!-- Gambar Lingkaran Kanan Atas -->
            <div class="col-6 text-end">
                <img src="img/baso.jpg" alt="Image 2" class="circle-image">
            </div>
        </div>
        <div class="row">
            <!-- Gambar Lingkaran Kiri Bawah -->
            <div class="col-6 text-start">
                <img src="img/baso.jpg" alt="Image 3" class="circle-image">
            </div>
            <!-- Gambar Lingkaran Kanan Bawah -->
            <div class="col-6 text-end">
                <img src="img/baso.jpg" alt="Image 4" class="circle-image">
            </div>
        </div>
    </div>

</body>
</html>
