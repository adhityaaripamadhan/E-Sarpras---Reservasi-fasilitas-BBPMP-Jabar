<?php
include 'koneksi.php'; // Menghubungkan file ini dengan koneksi ke database
$id = $_GET['id']; // Mengambil nilai id dari URL 

// Cek apakah variabel $id tidak kosong
if (!empty($id)) {
    // Menjalankan perintah SQL untuk menghapus data dari tabel reservasi berdasarkan id
    // Jika terjadi error saat query dijalankan, tampilkan pesan error dari MySQL
    mysqli_query($koneksi, "DELETE FROM reservasi WHERE id='$id'") or die(mysqli_error($koneksi));
}

// Setelah data dihapus, arahkan (redirect) pengguna ke halaman Dashboard2.php
// dan kirimkan parameter hapus=berhasil agar bisa ditampilkan pesan sukses di sana
header("Location: Dashboard2.php?hapus=berhasil");

exit; // Menghentikan eksekusi kode setelah redirect
?>
