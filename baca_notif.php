<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: formlogin.php");
    exit;
}

if (isset($_GET['id'])) {
    $id_notif = intval($_GET['id']);

    // Ambil id reservasi
    $notif = $koneksi->query("SELECT reservasi_id FROM notifikasi WHERE id='$id_notif' LIMIT 1")->fetch_assoc();

    if ($notif) {
        $reservasi_id = $notif['reservasi_id'];

        // Tandai notif sudah dibaca
        $koneksi->query("UPDATE notifikasi SET status='dibaca' WHERE id='$id_notif'");

        // Redirect ke detail reservasi
        header("Location: detail_reservasi.php?id=$reservasi_id");
        exit;
    }
}

header("Location: Dashboard.php");
exit;
?>