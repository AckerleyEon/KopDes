<?php
include __DIR__ . '/../../../config/koneksi.php';

$id       = $_POST['id_menu'];
$nama     = $_POST['nama'];
$kategori = $_POST['kategori'];
$harga    = $_POST['harga'];
$status   = $_POST['status'];

$gambar = $_POST['gambar_lama'];

if(isset($_FILES['gambar']) && $_FILES['gambar']['name'] != ''){

    $namaFile = time() . '_' . $_FILES['gambar']['name'];
    $tmp      = $_FILES['gambar']['tmp_name'];

    move_uploaded_file(
        $tmp,
        __DIR__ . '/../../../public/assets/img/' . $namaFile
    );

    $gambar = $namaFile;
}

$query = "UPDATE menu SET
            nama_menu='$nama',
            kategori_menu='$kategori',
            harga='$harga',
            status='$status',
            gambar='$gambar'
          WHERE id_menu='$id'";

mysqli_query($conn, $query);

header("Location: /KopiDesa/public/index.php?page=admin_menu");
exit;
?>