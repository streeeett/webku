<?php
// Koneksi ke database
require '../connection/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validasi data
    if ($password !== $confirmPassword) {
        echo "<script>alert('Password dan konfirmasi password tidak cocok');</script>";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 'customer'; // Tetapkan peran pengguna baru sebagai "customer"

        // Masukkan data ke database
        $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssss', $username, $email, $hashedPassword, $role);

        if ($stmt->execute()) {
            echo "<script>alert('Registrasi berhasil!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal, coba lagi');</script>";
        }

        $stmt->close();
    }

    // Tutup koneksi
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url('https://c4.wallpaperflare.com/wallpaper/673/218/396/anime-landscape-anime-garden-sunshine-flowers-wallpaper-preview.jpg');
      height: 100vh;
      background-size: 100% 100%;
      background-repeat: no-repeat;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .register-container {
      width: 100%;
      max-width: 400px;
      padding: 20px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>

  <div class="register-container bg-warning bg-opacity-75">
    <h3 class="text-center mb-4">Register</h3>
    <form method="POST" action="">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Masukan Username Anda" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Masukan Email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password" required>
      </div>
      <div class="mb-3">
        <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Konfirmasi Password" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn bg-info text-light w-100">Daftar</button>
      </div>
    </form>
    <p class="text-center mt-3">
      Sudah Punya Akun? <a href="login.php" class="text-decoration-none">Login</a>
    </p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
