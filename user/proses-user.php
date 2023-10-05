<?php
session_start();

if (isset($_SESSION["ssLogin"])) {
    header("location: ../auth/login.php");
    exit;
}

require_once "../config.php";

// Jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    // Ambil nilai elemen yang di-posting
    $username = trim(htmlspecialchars($_POST['username']));
    $nama = trim(htmlspecialchars($_POST['nama']));
    $jabatan = $_POST['jabatan'];
    $alamat = trim(htmlspecialchars($_POST['alamat']));
    $gambar = $_FILES['image']['name'];
    $password = "1234"; // Password default
    $pass = password_hash($password, PASSWORD_DEFAULT);

    // Cek username
    $cekUsername = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username = '$username'");
    if (mysqli_num_rows($cekUsername) > 0) {
        header("location: add-user.php?msg=cancel");
        exit();
    }

    // Upload gambar
    if ($gambar != null) {
        $url = 'add-user.php';
        $gambar = uploadimg($url);
    } else {
        $gambar = 'default.png';
    }

    mysqli_query($koneksi, "INSERT INTO tbl_user (username, password, nama, alamat, jabatan, gambar) VALUES ('$username', '$pass', '$nama', '$alamat', '$jabatan', '$gambar')");

    header("location: add-user.php?msg-added");
    exit();
}
?>
