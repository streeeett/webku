<?php
require '../connection/koneksi.php';

session_start();

// Cek apakah user sudah login dan memiliki peran sebagai admin
if ($_SESSION['role'] != "admin") {
    header("location:../halaman.php?");
}

// Mendapatkan ID produk dari URL
$id_produk = $_GET['id_produk'];

// Query untuk mengambil data produk berdasarkan ID
$query = "SELECT * FROM produk WHERE id_produk = $id_produk";
$result = mysqli_query($conn, $query);
$barang = mysqli_fetch_assoc($result);

// Query untuk mengambil data varian yang terkait dengan produk
$queryVarian = "SELECT * FROM varian WHERE id_produk = $id_produk";
$resultVarian = mysqli_query($conn, $queryVarian);
$varianList = [];
while ($row = mysqli_fetch_assoc($resultVarian)) {
    $varianList[] = $row;
}

// Cek apakah tombol submit telah diklik
if (isset($_POST["submit"])) {
    $nama = $_POST["nama"];
    $deskripsi = $_POST["deskripsi"];
    $kategori = $_POST["kategori"];
    $harga = $_POST["harga"];
    $varianArray = $_POST["varian"]; // Ambil array varian dari input

    // Cek apakah pengguna mengupload gambar baru atau tidak
    if ($_FILES["gambar"]["error"] === 4) {
        $newImageName = $barang['gambar'];
    } else {
        $fileName = $_FILES["gambar"]["name"];
        $fileSize = $_FILES["gambar"]["size"];
        $tmpName = $_FILES["gambar"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

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

    // Update data produk
    $query = "UPDATE produk SET 
                nama = '$nama', 
                deskripsi = '$deskripsi', 
                kategori = '$kategori', 
                harga = '$harga', 
                gambar = '$newImageName' 
              WHERE id_produk = $id_produk";
    
    mysqli_query($conn, $query);

    // Update data varian
    // Hapus varian yang tidak ada di array input
    $queryDeleteVarian = "DELETE FROM varian WHERE id_produk = $id_produk";
    mysqli_query($conn, $queryDeleteVarian);

    // Tambah atau update varian yang diinput
    foreach ($varianArray as $varian) {
        $varian = htmlspecialchars($varian);
        $queryVarian = "INSERT INTO varian (id_produk, nama_varian) VALUES ('$id_produk', '$varian')";
        mysqli_query($conn, $queryVarian);
    }

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
    <title>Edit</title>
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body style="background: linear-gradient(#edbfac, #dbd8bb);">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary bg-warning-subtle">
                    <h3 class="text-center">Edit Produk</h3>
                </div>
                <div class="card-body bg-warning bg-opacity-75">
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

                        <!-- Input Varian Rasa -->
                        <div id="varianContainer" class="mb-3">
                            <label class="form-label">Varian Rasa</label>
                            <?php foreach ($varianList as $varian): ?>
                                <div class="input-group mb-2">
                                    <input type="text" name="varian[]" class="form-control" value="<?= htmlspecialchars($varian['nama_varian']); ?>" required>
                                    <button type="button" class="btn btn-danger" onclick="removeVarianField(this)">Hapus</button>
                                </div>
                            <?php endforeach; ?>
                            <div class="input-group mb-2">
                                <input type="text" name="varian[]" class="form-control" placeholder="Masukkan varian rasa baru">
                                <button type="button" class="btn btn-secondary" onclick="addVarianField()">Tambah Varian</button>
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

<script>
function addVarianField() {
    const container = document.getElementById("varianContainer");
    const inputGroup = document.createElement("div");
    inputGroup.classList.add("input-group", "mb-2");
    inputGroup.innerHTML = `
        <input type="text" name="varian[]" class="form-control" placeholder="Masukkan varian rasa">
        <button type="button" class="btn btn-danger" onclick="removeVarianField(this)">Hapus</button>
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
