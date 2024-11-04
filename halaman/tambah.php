<?php 
require '../connection/koneksi.php';
session_start();

// Cek apakah user sudah login dan memiliki peran sebagai admin
if ($_SESSION['role'] != "admin") {
    header("location:../halaman.php?");
}

if (isset($_POST["submit"])) {
    $nama = $_POST["nama"];
    $deskripsi = $_POST["deskripsi"];
    $kategori = $_POST["kategori"];
    $harga = $_POST["harga"];
    $varianArray = $_POST["varian"]; // Ambil array varian dari input

    if ($_FILES["gambar"]["error"] === 4) {
        echo "<script> alert('gambar tidak tersedia ')</script>";
    } else {
        $fileName = $_FILES["gambar"]["name"];
        $fileSize = $_FILES["gambar"]["size"];
        $tmpName = $_FILES["gambar"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script> alert('ekstensi gambar tidak tersedia ')</script>";
        } else if ($fileSize > 1000000) {
            echo "<script> alert('ukuran gambar kebesaran')</script>"; 
        } else {
            $newImageName = uniqid() . '.' . $imageExtension;
            move_uploaded_file($tmpName, 'img/' . $newImageName);

            // Insert data produk ke database
            $query = "INSERT INTO produk (nama, harga, kategori, deskripsi, gambar) VALUES ('$nama', '$harga', '$kategori', '$deskripsi', '$newImageName')";
            mysqli_query($conn, $query);

            // Dapatkan ID produk yang baru saja ditambahkan
            $id_produk = mysqli_insert_id($conn);

            // Insert setiap varian rasa ke tabel varian
            foreach ($varianArray as $varian) {
                $varian = htmlspecialchars($varian); // Sanitasi data
                $queryVarian = "INSERT INTO varian (id_produk, nama_varian) VALUES ('$id_produk', '$varian')";
                mysqli_query($conn, $queryVarian);
            }

            echo "<script> alert('Produk dan varian berhasil ditambahkan');
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
                        <!-- Input Nama, Deskripsi, Kategori, Harga, Gambar -->
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

                        <!-- Input Varian -->
                        <div id="varianContainer" class="mb-3">
                            <label class="form-label">Varian Rasa</label>
                            <div class="input-group mb-2">
                                <input type="text" name="varian[]" class="form-control" placeholder="Masukkan varian rasa">
                                <button type="button" class="btn btn-outline-secondary" onclick="addVarianField()">Tambah Varian</button>
                            </div>
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

<script>
function addVarianField() {
    const container = document.getElementById("varianContainer");
    const inputGroup = document.createElement("div");
    inputGroup.classList.add("input-group", "mb-2");
    inputGroup.innerHTML = `
        <input type="text" name="varian[]" class="form-control" placeholder="Masukkan varian rasa">
        <button type="button" class="btn btn-outline-danger" onclick="removeVarianField(this)">Hapus</button>
    `;
    container.appendChild(inputGroup);
}

function removeVarianField(button) {
    button.parentElement.remove();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
