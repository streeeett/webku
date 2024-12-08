<?php
session_start();
require '../connection/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php?pesan=harus_login");
    exit;
}

$id_user = $_SESSION['id_user'];

$query = "SELECT * FROM users WHERE id_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Profil Saya</h1>
        
        <?php if ($user): ?>
            <form action="update_profil.php" method="post" enctype="multipart/form-data" class="p-4 border rounded">
                <!-- Tampilkan Foto Profil Jika Ada -->
                <div class="text-center mb-3">
                    <?php if ($user['photo']): ?>
                        <img src="uploads/<?= htmlspecialchars($user['photo']); ?>" alt="Foto Profil" class="img-thumbnail" width="150">
                    <?php else: ?>
                        <p>Foto profil belum diunggah.</p>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Unggah Foto Baru</label>
                    <input type="file" class="form-control" id="photo" name="photo">
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" 
                           value="<?= htmlspecialchars($user['username']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?= htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control" id="phone" name="phone" 
                           value="<?= htmlspecialchars($user['phone'] ?? ''); ?>">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        <?php else: ?>
            <p>Data profil tidak ditemukan.</p>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="../halaman.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
