<?php
require '../connection/koneksi.php';

// Mendapatkan ID barang dari URL
$id_produk = $_GET['id_produk'];

// Query untuk mengambil data berdasarkan ID
$query = "SELECT * FROM produk WHERE id_produk = $id_produk";
$result = mysqli_query($conn, $query);
$barang = mysqli_fetch_assoc($result);

// Cek apakah tombol submit telah diklik
if (isset($_POST["submit"])) {

    $nama = $_POST["nama"];
    $deskripsi = $_POST["deskripsi"];
    $kategori = $_POST["kategori"];
    $harga = $_POST["harga"];
    
    // Cek apakah pengguna mengupload gambar baru atau tidak
    if ($_FILES["gambar"]["error"] === 4) {
        $newImageName = $barang['gambar'];
    } else {
        $fileName = $_FILES["gambar"]["name"];
        $fileSize = $_FILES["gambar"]["size"];
        $tmpName = $_FILES["gambar"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = strtolower(end(explode('.', $fileName)));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script>alert('Ekstensi gambar tidak valid!');</script>";
            exit;
        } else if ($fileSize > 1000000) {
            echo "<script>alert('Ukuran gambar terlalu besar!');</script>";
            exit;
        } else {
            unlink('img/' . $barang['gambar']); // Hapus gambar lama
            $newImageName = uniqid() . '.' . $imageExtension;
            move_uploaded_file($tmpName, 'img/' . $newImageName); // Upload gambar baru
        }
    }

    $query = "UPDATE produk SET 
                nama = '$nama', 
                deskripsi = '$deskripsi', 
                kategori = '$kategori', 
                harga = '$harga', 
                gambar = '$newImageName' 
              WHERE id_produk = $id_produk";
    
    mysqli_query($conn, $query);

    echo "<script>
            alert('Data berhasil diubah!');
            document.location.href = '../halaman.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="text-center">Edit Barang</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= $barang['nama']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" required><?= $barang['deskripsi']; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" class="form-control" name="kategori" id="kategori" value="<?= $barang['kategori']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" name="harga" id="harga" value="<?= $barang['harga']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" name="gambar" id="gambar" accept=".jpg, .jpeg, .png">
                            <div class="mt-2">
                                <img src="img/<?= $barang['gambar']; ?>" width="100" class="rounded">
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="submit" class="btn btn-success">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
