<?php 

require '../connection/koneksi.php';


session_start();

// Cek apakah user sudah login
if($_SESSION['role'] != "admin"){
    header("location:../halaman.php?");
}



if(isset($_POST["submit"])){

    $nama = $_POST["nama"];
    $deskripsi = $_POST["deskripsi"];
    $kategori = $_POST["kategori"];
    $harga = $_POST["harga"];

    if($_FILES["gambar"]["error"] === 4){
        echo "<script> alert('gambar tidak tersedia ')</script>";
    }else{
        $fileName = $_FILES["gambar"]["name"];
        $fileSize = $_FILES["gambar"]["size"];
        $tmpName = $_FILES["gambar"]["tmp_name"];
    
        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
        if(!in_array($imageExtension, $validImageExtension)){
            echo "<script> alert('ekstensi gambar tidak tersedia ')</script>";
        }else if($fileSize > 1000000){
            echo "<script> alert('ukuran gambar kebesaran')</script>"; 
        }else{
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;
            
            move_uploaded_file($tmpName, 'img/' .$newImageName);
            $query = "INSERT INTO produk VALUES('', '$nama', '$harga', '$kategori', '$deskripsi', '$newImageName')";
            mysqli_query($conn, $query);
            echo "<script> alert('sukses ditambahkan');
                document.location.href = '../halaman.php';
            </script>";

    }
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Produk</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h4>Upload Produk</h4>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data" autocomplete="off">

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Produk</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" name="kategori" id="kategori" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Upload Gambar</label>
                            <input type="file" name="gambar" id="gambar" class="form-control" accept=".jpg, .jpeg, .png" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="../halaman.php" class="btn btn-link">Lihat Data Produk</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Optional for interactivity) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
