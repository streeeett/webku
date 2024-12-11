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
        <th style="background-color: #edbfac;">DATA USER</th>
    </tr>
    <tr>
      <th scope="col">TELPON</th>
      <th scope="col">USERNAME</th>
      <th scope="col">EMAIL</th>
      <th scope="col">FOTO</th>
      <th scope="col">ROLE</th>
      <th scope="col">AKSI</th>
    </tr>
  </thead>
  <tbody>
  <?php
    require '../connection/koneksi.php';
    $query = mysqli_query($conn, "SELECT * FROM users");
    while($row = mysqli_fetch_array($query)){
        ?>
       <tr>
       <td>
            <?= $row['phone']?></td>
        </td>

        <td>
            <?= $row['username']?></td>
        </td>

        <td>
            <?= $row['email']?></td>
        </td>

        <td>
        <img src="../profil/uploads/<?= htmlspecialchars($row['photo']); ?>" style="width: 80px;" >
        </td>
        
        <td>
            <?= $row['role']?></td>
        </td>

        <td>
        <!-- <a href="../detail_produk.php?id_produk=<?= $row['id_produk']; ?>" class="btn btn-primary btn-custom"><i class="fa-solid fa-eye"></i> Lihat</a> -->
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