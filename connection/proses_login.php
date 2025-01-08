<?php 
session_start();

require '../connection/koneksi.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$login = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND email='$email'");

if (mysqli_num_rows($login) > 0) {
    $data = mysqli_fetch_assoc($login);
    
    if (password_verify($password, $data['password'])) {
        $_SESSION['id_user'] = $data['id_user']; 
        $_SESSION['username'] = $data['username'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['role'] = $data['role'];

        setcookie("username", $data['username'], time() + (7 * 24 * 60 * 60), "/");
        setcookie("role", $data['role'], time() + (7 * 24 * 60 * 60), "/");

        if ($data['role'] === "admin") {
            header("location:../halaman.php");
        } else if ($data['role'] === "customer") {
            header("location:../halaman.php");
        } else {
            header("location:../logreg/login.php?pesan=gagal");
        }
    } else {
        header("location:../logreg/login.php?pesan=gagal");
    }
} else {
    header("location:../logreg/login.php?pesan=gagal");
}
?>
