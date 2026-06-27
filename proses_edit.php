<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

function showAlert($icon, $title, $text, $redirect)
{
    echo "
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Proses Edit</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: '$icon',
                title: '$title',
                text: '$text',
                confirmButtonColor: '#007bff'
            }).then(() => {
                window.location.href = '$redirect';
            });
        </script>
    </body>
    </html>
    ";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_ruangan'];
    $nama = $_POST['nama_ruangan'];
    $deskripsi = $_POST['deskripsi'];

    $foto = $_FILES['foto']['name'] ?? '';
    $tmp = $_FILES['foto']['tmp_name'] ?? '';

    $folder = __DIR__ . "/ASSET/GALERIDB/";
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    if (!empty($foto)) {
        $ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];

        if (in_array($ext, $allowed)) {
            $nama_file_baru = uniqid() . '_' . $foto;
            move_uploaded_file($tmp, $folder . $nama_file_baru);
            $query = "UPDATE ruangan 
                      SET nama_ruangan='$nama', deskripsi='$deskripsi', photo='$nama_file_baru' 
                      WHERE id_ruangan='$id'";
        } else {
            showAlert('error', 'Format Tidak Didukung', 'Hanya boleh JPG, JPEG, atau PNG.', 'history.back()');
            exit;
        }
    } else {
        $query = "UPDATE ruangan 
                  SET nama_ruangan='$nama', deskripsi='$deskripsi' 
                  WHERE id_ruangan='$id'";
    }

    $update = mysqli_query($koneksi, $query);

    if ($update) {
        showAlert('success', 'Berhasil!', 'Ruangan berhasil diedit.', '../infomin.php');
    } else {
        $error_msg = mysqli_error($koneksi);
        showAlert('error', 'Update Gagal', $error_msg, 'history.back()');
    }
}
?>