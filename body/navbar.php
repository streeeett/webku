<?php
require 'connection/koneksi.php';
// Example: Check if the user is logged in and their role
$role = $_SESSION['role'] ?? 'guest'; // Possible values: 'admin', 'customer', 'guest'

if (isset($_POST["cari"])) {
  $row = cari($_POST["keyword"]);
}
?>



<nav class="navbar sticky-top navbar-expand-lg bg-warning-subtle">
  <div class="container-fluid">
    <a class="navbar-brand" href="halaman.php">🅣🅞🅚🅞 🅖🅤🅐</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="halaman.php"><i class="fa-solid fa-house"></i> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li> -->

      </ul>

  <form action="hasil.php" method="GET" class="navbar-nav me-auto mb-2 mb-lg-0" role="search">
        <input name="keyword" class="form-control bg-warning-subtle border-dark fs-5 me-2" type="search" placeholder="Cari produk..." required>
        <button class="btn btn-outline-dark" type="submit">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>

      <ul class="navbar-nav mb-2 mb-lg-0" style="margin-right: 105px;">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-user"></i>
          </a>
          <ul class="dropdown-menu">
            <?php if ($role === 'admin'): ?>
              <li><a class="dropdown-item" href="halaman/tambah.php"><i class="fa-solid fa-plus"></i> Tambah produk</a></li>
              <li><a class="dropdown-item" href="data_toko/data.php"><i class="fa-solid fa-chart-simple"></i> Data</a></li>
              <li><a class="dropdown-item" href="cek/admin_pesanan.php"><i class="fa-solid fa-list"></i> Data Pesanan</a></li>
              <li><a class="dropdown-item" href="cek/pesanan.php"><i class="fa-solid fa-bag-shopping"></i> Pesanan</a></li>
              <li><a class="dropdown-item" href="keranjang/keranjang.php"><i class="fa-solid fa-cart-shopping"></i> Keranjang</a></li>
              <li><a class="dropdown-item" href="profil/profil.php"><i class="fa-solid fa-circle-user"></i> Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="logreg/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            <?php elseif ($role === 'customer'): ?>
              <li><a class="dropdown-item" href="keranjang/keranjang.php"><i class="fa-solid fa-cart-shopping"></i> Keranjang</a></li>
              <li><a class="dropdown-item" href="cek/pesanan.php"><i class="fa-solid fa-bag-shopping"></i> Pesanan</a></li>
              <li><a class="dropdown-item" href="profil/profil.php"><i class="fa-solid fa-circle-user"></i> Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="logreg/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            <?php else: ?>
              <li><a class="dropdown-item" href="logreg/register.php"><i class="fa-solid fa-registered"></i> Register</a></li>
              <li><a class="dropdown-item" href="logreg/login.php"><i class="fa-solid fa-right-from-bracket"></i> Login</a></li>
            <?php endif; ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
