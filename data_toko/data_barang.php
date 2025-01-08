
<?php 


// Cek apakah user sudah login dan memiliki peran sebagai admin
if ($_SESSION['role'] != "admin") {
    header("location:../halaman.php?");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


<body>
<table class="table table-striped table-warning">
  <thead class="table-danger">
    <tr>
        <th style="background-color: #edbfac;">DATA PRODUK</th>
    </tr>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">FOTO PRODUK</th>
      <th scope="col">NAMA PRODUK</th>
      <th scope="col">HARGA</th>
      <th scope="col">KATEGORI</th>
      <th scope="col">AKSI</th>
    </tr>
  </thead>
  <tbody>
  <?php
    require '../connection/koneksi.php';
    $query = mysqli_query($conn, "SELECT * FROM produk");
    while($row = mysqli_fetch_array($query)){
        ?>
       <tr>
       <td>
            <?= $row['id_produk']?></td>
        </td>

        <td>
        <img src="../halaman/img/<?= htmlspecialchars($row['gambar']); ?>" alt="<?= htmlspecialchars($row['nama']); ?>" style="width: 80px;">
        </td>

        <td>
            <?= $row['nama']?></td>
        </td>

        <td>
            <?= $row['harga']?></td>
        </td>

        <td>
            <?= $row['kategori']?></td>
        </td>

        <td>
        <a href="../detail_produk.php?id_produk=<?= $row['id_produk']; ?>" class="btn btn-primary btn-custom"><i class="fa-solid fa-eye"></i> Lihat</a>
        <a href="../halaman/edit.php?id_produk=<?= $row['id_produk']; ?>" class="btn btn-warning btn-custom "><i class="fa-solid fa-pen-to-square"></i> Ubah</a>
        <a href="../halaman/hapus.php?id_produk=<?= $row['id_produk']; ?>" class="btn btn-danger btn-custom"><i class="fa-solid fa-trash"></i> Hapus</a>
        <a href="../halaman.php" class="btn btn-warning btn-custom"><i class="fa-solid fa-caret-left"></i> KEMBALI</a>
        </td>
       </tr>
        <?php
    }

    ?>
  </tbody>
</table>

</body>
</html>