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
    <title>Tambah Produk</title>
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../style/tambah-produk.css">
</head>
<body style="background: linear-gradient(#edbfac, #dbd8bb);">

<div class="container-add-product">
    <!-- <div class="row justify-content-center"> -->
        <div class="col">
            <div class="card ">
                <div class="card-title">
                    <h4>Tambah Produk Baru</h4>
                </div>

                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                        <!-- Input Nama, Deskripsi, Kategori, Harga, Gambar -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Produk</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Produk" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Deskrpsi" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" name="kategori" id="kategori" class="form-control" placeholder="Kategori" required>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control" placeholder="Harga    " required>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Tambahkan Gambar</label>
                            <input type="file" name="gambar" id="gambar" class="form-control" accept=".jpg, .jpeg, .png" placeholder="Gambar" required>
                        </div>

                        <!-- Input Varian -->
                        <div id="varianContainer" class="mb-3">
                            <label class="form-label">Varian</label>
                            <div class="input-group mb-2">
                                <input type="text" name="varian[]" class="form-control" placeholder="Masukkan varian rasa">
                                <button type="button" class="btn btn-secondary" onclick="addVarianField()"><i class="fa-solid fa-plus"></i> Tambah Varian</button>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="submit" class="btn bg-info fw-bold">Submit</button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <a href="../data_toko/data.php" class="btn btn-priary">Lihat Data Produk</a>
                </div>

            </div>
        </div>
    <!-- </div> -->
</div>

<script>
function addVarianField() {
    const container = document.getElementById("varianContainer");
    const inputGroup = document.createElement("div");
    inputGroup.classList.add("input-group", "mb-2");
    inputGroup.innerHTML = `
        <input type="text" name="varian[]" class="form-control" placeholder="Masukkan varian rasa">
        <button type="button" class="btn btn-danger" onclick="removeVarianField(this)"><i class="fa-thin fa-x"></i> Hapus</button>`;
    container.appendChild(inputGroup);
}

function removeVarianField(button) {
    button.parentElement.remove();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
