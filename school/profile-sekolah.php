<?php

session_start();

if (isset( $_SESSION["ssLogin"])) {
    header("location:../auth/login.php");
    exit;
}


require_once "../config.php";

$title = "Profile Sekolah - SMK LUKI SEFTIAN";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = '';
}

$alert = '';
if ($msg == 'notimage') {
    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <i class="fa-solid fa-triangle-exclamation"></i> Gagal mengupdate data sekolah. File yang diunggah bukan gambar.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if ($msg == 'oversize') {
    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <i class="fa-solid fa-triangle-exclamation"></i> Gagal mengupdate data sekolah. Ukuran gambar maksimal 1 MB.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if ($msg == 'updated') {
    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <i class="fa-solid fa-circle-check"></i> Data sekolah berhasil diperbarui.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}

$sekolah = mysqli_query($koneksi, "SELECT * FROM tbl_sekolah WHERE id = 1");
$data = mysqli_fetch_array($sekolah);
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Sekolah</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"> <a href="../index.php">Beranda</a></li>
                <li class="breadcrumb-item active">Profil Sekolah</li>
            </ol>

            <?php
            if ($msg !== '') {
                echo $alert;
            }
            ?>

            <form action="proses-sekolah.php" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="h5"><i class="fa-solid fa-pen-to-square"></i> Data Sekolah</span>
                        <button type="submit" name="simpan" class="btn btn-primary float-end"><i class="fa-solid fa-floppy-disk fa-beat-fade me-1"></i>Simpan</button>
                        <button type="reset" name="reset" class="btn btn-danger float-end me-1"><i class="fa-solid fa-xmark fa-beat-fade me-1"></i>Reset</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 text-center px-5">
                                <input type="hidden" name="gbrlama" value="<?=$data['gambar']?>">
                                <img src="../asset/image/<?=$data['gambar']?>" alt="Gambar Sekolah" class="mb-3" width="50%">
                                <input type="file" name="image" id="image" class="form-control form-control-sm">
                                <small class="text-secondary">Pilih gambar PNG, JPG, atau JPEG dengan ukuran maksimal 1 MB.</small>
                            </div>
                            <div class="col-8">
                                <input type="hidden" name="id" value="<?=$data['id']?>">
                                <div class="mb-3 row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                    <label for="nama" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px;">
                                        <input type="text" class="form-control border-0 border-bottom" id="nama" name="nama" value="<?=$data['nama']?>" placeholder="Nama Sekolah" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <label for="email" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px;">
                                        <input type="email" class="form-control border-0 border-bottom" id="email" name="email" value="<?=$data['email']?>" placeholder="Email Sekolah" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                                    <label for="status" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px;">
                                        <select name="status" id="status" class="form-select border-0 border-bottom" required>
                                            <option value="negeri" <?=($data['status'] == 'negeri') ? 'selected' : ''?>>Negeri</option>
                                            <option value="swasta" <?=($data['status'] == 'swasta') ? 'selected' : ''?>>Swasta</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="akreditasi" class="col-sm-2 col-form-label">Akreditasi</label>
                                    <label for="akreditasi" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px;">
                                        <select name="akreditasi" id="akreditasi" class="form-select border-0 border-bottom" required>
                                            <option value="A" <?=($data['akreditasi'] == 'A') ? 'selected' : ''?>>A</option>
                                            <option value="B" <?=($data['akreditasi'] == 'B') ? 'selected' : ''?>>B</option>
                                            <option value="C" <?=($data['akreditasi'] == 'C') ? 'selected' : ''?>>C</option>
                                            <option value="D" <?=($data['akreditasi'] == 'D') ? 'selected' : ''?>>D</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                    <label for="alamat" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px;">
                                        <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control" required><?=$data['alamat']?></textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="visimisi" class="col-sm-2 col-form-label">Visi dan Misi</label>
                                    <label for="visimisi" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px;">
                                        <textarea name="visimisi" id="visimisi" cols="30" rows="3" class="form-control" required><?=$data['visimisi']?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

<?php
require_once "../template/footer.php";
?>
