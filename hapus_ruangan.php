<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    $hapus = mysqli_query($koneksi, "DELETE FROM ruangan WHERE id_ruangan = '$id'");

    if ($hapus) {

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    echo "ID tidak ditemukan.";
}
?>