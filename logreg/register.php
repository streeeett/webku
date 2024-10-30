<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #d2bab0;
      height: 100vh;
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

  <div class="register-container bg-info">
    <h3 class="text-center mb-4">Register</h3>
    <form>
      <div class="mb-3">
        <label for="fullName" class="form-label">Nama Asli</label>
        <input type="text" class="form-control" id="fullName" placeholder="Masukan Nama ASli Anda" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Masukan Email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Masukan Password" required>
      </div>
      <div class="mb-3">
        <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
        <input type="password" class="form-control" id="confirmPassword" placeholder="Konfirmasi Password" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary w-100">Daftar</button>
      </div>
    </form>
    <p class="text-center mt-3">
      Sudah Punya Akun? <a href="login.php" class="text-decoration-none">Login</a>
    </p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
