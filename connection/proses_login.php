<?php 
// mengaktifkan session pada php
session_start();
 
// menghubungkan php dengan koneksi database
require '../connection/koneksi.php';
 
// menangkap data yang dikirim dari form login
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
 
 
// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($conn,"SELECT * FROM users WHERE username='$username' AND email= '$email' AND password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);
 
// cek apakah username dan password di temukan pada database
if($cek > 0){
 
	$data = mysqli_fetch_assoc($login);
 
	// cek jika user login sebagai admin
	if($data['role']=="admin"){
 
		// buat session login dan username
		$_SESSION['id_user'] = $id_user;
		$_SESSION['username'] = $username;
		$_SESSION['email'] = $email;
		$_SESSION['role'] = "admin";
		// alihkan ke halaman dashboard admin
		header("location:../halaman.php");
 
	// cek jika user login sebagai pegawai
	}else if($data['role']=="customer"){
		// buat session login dan username
		$_SESSION['id_user'] = $id_user;
		$_SESSION['username'] = $username;
		$_SESSION['email'] = $email;
		$_SESSION['role'] = "customer";
		// alihkan ke halaman dashboard pegawai
		header("location:../halaman.php");
 
	// cek jika user login sebagai pengurus
	}else{
 
		// alihkan ke halaman login kembali
		header("location:login.php?pesan=gagal");
	}	
}else{
	header("location:login.php?pesan=gagal");
}
 





?>