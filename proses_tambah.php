<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    $folder = __DIR__ . "/ASSET/GALERIDB/";

    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    $ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png'];

    function showAlert($icon, $title, $text, $redirect, $color = '#007bff', $withLoading = false) {
        echo "
        <!DOCTYPE html>
        <html lang='id'>
        <head>
            <meta charset='UTF-8'>
            <title>Proses Tambah</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>";
        
        if ($withLoading) {
            echo "
                Swal.fire({
                    icon: '$icon',
                    title: '$title',
                    text: '$text',
                    confirmButtonColor: '$color',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                setTimeout(() => {
                    window.location.href = '$redirect';
                }, 1800);
            ";
        } else {
            echo "
                Swal.fire({
                    icon: '$icon',
                    title: '$title',
                    text: '$text',
                    confirmButtonColor: '$color'
                }).then(() => {
                    window.location.href = '$redirect';
                });
            ";
        }

        echo "</script>
        </body>
        </html>";
        exit;
    }

    if (in_array($ext, $allowed)) {
        $nama_file_baru = uniqid() . '_' . preg_replace('/\s+/', '_', $foto);

        if (move_uploaded_file($tmp, $folder . $nama_file_baru)) {
            $query = "INSERT INTO ruangan (nama_ruangan, deskripsi, photo) 
                      VALUES ('$nama', '$deskripsi', '$nama_file_baru')";
            $insert = mysqli_query($koneksi, $query);

            if ($insert) {
                showAlert('success', 'Berhasil!', 'Ruangan berhasil ditambahkan!', 'infomin.php', '#007bff', true);
            } else {
                showAlert('error', 'Gagal!', 'Gagal menyimpan ke database.', 'infomin.php', '#dc3545');
            }
        } else {
            showAlert('error', 'Upload Gagal', 'File tidak dapat dipindahkan!', 'tambah_ruangan.php', '#dc3545');
        }
    } else {
        showAlert('warning', 'Format Tidak Didukung', 'Hanya JPG, JPEG, atau PNG yang diperbolehkan!', 'tambah_ruangan.php', '#ffc107');
    }
} else {
    echo "
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <title>Request Tidak Valid</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Request Tidak Valid',
                text: 'Silakan gunakan form untuk mengunggah data!',
                confirmButtonColor: '#dc3545'
            }).then(() => {
                window.location.href = 'tambah_ruangan.php';
            });
        </script>
    </body>
    </html>
    ";
}
?>
