<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $koneksi->query("UPDATE notifikasi SET status='dibaca' WHERE user_id='$id' AND status='belum_dibaca'");
}
