<?php
session_start();
require '../connection/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php?pesan=harus_login");
    exit;
}

$id_user = $_SESSION['id_user'];
$username = $_POST['username'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Proses upload foto jika ada file yang diunggah
$photo = $_FILES['photo'];
if ($photo['error'] == UPLOAD_ERR_OK) {
    $ext = pathinfo($photo['name'], PATHINFO_EXTENSION);
    $photoName = "photo_" . $id_user . "." . $ext;
    $uploadDir = "uploads/";
    $uploadFile = $uploadDir . $photoName;

    if (move_uploaded_file($photo['tmp_name'], $uploadFile)) {
        // Simpan nama file foto ke dalam database
        $query = "UPDATE users SET username = ?, email = ?, phone = ?, photo = ? WHERE id_user = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $username, $email, $phone, $photoName, $id_user);
    } else {
        echo "Gagal mengunggah foto.";
        exit;
    }
} else {
    // Jika tidak ada foto baru, perbarui data tanpa mengubah kolom foto
    $query = "UPDATE users SET username = ?, email = ?, phone = ? WHERE id_user = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $username, $email, $phone, $id_user);
}

if ($stmt->execute()) {
    header("Location: profil.php?pesan=update_berhasil");
} else {
    echo "Gagal memperbarui profil.";
}
