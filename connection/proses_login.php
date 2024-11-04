<?php 
// Mulai session
session_start();

// Koneksi ke database
require '../connection/koneksi.php';

// Tangkap data dari form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Verifikasi data user
$login = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND email='$email' AND password='$password'");

// Cek apakah user ditemukan
if (mysqli_num_rows($login) > 0) {
    $data = mysqli_fetch_assoc($login);
    
    // Set session sesuai dengan role
    $_SESSION['id_user'] = $data['id_user']; // Sesuaikan 'id_user' dengan kolom yang benar di database
    $_SESSION['username'] = $data['username'];
    $_SESSION['email'] = $data['email'];
    $_SESSION['role'] = $data['role'];
    
    // Redirect ke halaman sesuai role
    if ($data['role'] === "admin") {
        header("location:../halaman.php");
    } else if ($data['role'] === "customer") {
        header("location:../halaman.php");
    } else {
        header("location:login.php?pesan=gagal");
    }
} else {
    // Redirect jika gagal login
    header("location:login.php?pesan=gagal");
}
?>
