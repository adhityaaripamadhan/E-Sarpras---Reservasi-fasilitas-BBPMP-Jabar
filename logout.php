<?php
session_start();// Memulai sesi agar bisa mengakses data session yang sedang aktif
session_destroy();// Menghapus semua data yang ada di dalam session
header("Location: index.php");// Redirect pengguna kembali ke halaman index
exit();// Menghentikan eksekusi kode setelah redirect agar tidak ada kode lain yang dijalankan
?>
