<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $uploadDir = "uploads/surat_resmi/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES['surat_resmi']) && $_FILES['surat_resmi']['error'] == 0) {
        $fileName = time() . "_" . basename($_FILES['surat_resmi']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['surat_resmi']['tmp_name'], $targetPath)) {
            $query = "UPDATE reservasi SET surat_resmi = '$fileName' WHERE id = '$id'";
            if (mysqli_query($koneksi, $query)) {
                echo "<script>
                    alert('Surat berhasil diupload.');
                    window.location.href='admin_reservasi.php';
                </script>";
            } else {
                echo "<script>
                    alert('Gagal menyimpan ke database.');
                    window.history.back();
                </script>";
            }
        } else {
            echo "<script>
                alert('Upload gagal. Coba lagi.');
                window.history.back();
            </script>";
        }
    }
}
?>
