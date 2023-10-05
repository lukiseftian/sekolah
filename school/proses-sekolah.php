<?php
session_start();

if (isset($_SESSION["ssLogin"])) {
    header("location:../auth/login.php");
    exit;
}

require_once "../config.php";

// Jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    // Ambil nilai dari form
    $id = $_POST['id'];
    $nama = trim(htmlspecialchars($_POST['nama']));
    $email = trim(htmlspecialchars($_POST['email']));
    $status = $_POST['status'];
    $akreditasi = $_POST['akreditasi'];
    $alamat = trim(htmlspecialchars($_POST['alamat']));
    $visimisi = trim(htmlspecialchars($_POST['visimisi']));
    $gbrLama = $_POST['gbrlama'];

    // Cek apakah gambar diubah
    if ($_FILES['image']['error'] === 4) {
        $gbrSekolah = $gbrLama;
    } else {
        $url = 'profile-sekolah.php';
        $gbrSekolah = uploadimg($url);
        @unlink('../asset/image/' . $gbrLama);
    }

    // Update data
    mysqli_query($koneksi, "UPDATE tbl_sekolah SET
        nama = '$nama',
        email = '$email',
        status = '$status',
        akreditasi = '$akreditasi',
        alamat = '$alamat',
        visimisi = '$visimisi',
        gambar = '$gbrSekolah'
        WHERE id = $id
    ");

    header("location:profile-sekolah.php?msg=updated");
    exit();
}
?>
