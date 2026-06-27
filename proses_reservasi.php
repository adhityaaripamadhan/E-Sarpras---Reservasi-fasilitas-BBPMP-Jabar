<?php
session_start();
include 'koneksi.php';

$nama = $_POST['nama'];
$nohp = $_POST['NoHP'];
$email = $_POST['Email'];
$namakegiatan = $_POST['NamaKegiatan'];
$pengusul = $_POST['Pengusul'];
$namainstansi = $_POST['Namainstansi'];
$alamat = $_POST['Alamat'];
$jenisusulan = $_POST['JenisUsulan'];
$ruangan = $_POST['Ruangan'];
$layout_ruangan = $_POST['layout_ruangan'];

$tanggalawal = $_POST['TanggalAwal'];
$tanggalakhir = $_POST['TanggalAkhir'];

$waktuawal = str_pad($_POST['WaktuAwal_Jam'], 2, '0', STR_PAD_LEFT) . ':' . str_pad($_POST['WaktuAwal_Menit'], 2, '0', STR_PAD_LEFT);
$waktuakhir = str_pad($_POST['WaktuAkhir_Jam'], 2, '0', STR_PAD_LEFT) . ':' . str_pad($_POST['WaktuAkhir_Menit'], 2, '0', STR_PAD_LEFT);

$lampiranName = '';
if (isset($_FILES['lampiran']) && $_FILES['lampiran']['error'] == 0) {
    $targetDir = "../ASSET/GALERIDB/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $lampiranName = time() . "_" . basename($_FILES['lampiran']['name']);
    $targetFile = $targetDir . $lampiranName;
    move_uploaded_file($_FILES['lampiran']['tmp_name'], $targetFile);
}

$sql = "INSERT INTO reservasi 
(Nama, NoHP, Email, NamaKegiatan, Pengusul, Namainstansi, Alamat, 
TanggalAwal, WaktuAwal, TanggalAkhir, WaktuAkhir, 
JenisUsulan, Ruangan, layout_ruangan, lampiran, Status)
VALUES 
('$nama', '$nohp', '$email', '$namakegiatan', '$pengusul', '$namainstansi', '$alamat',
'$tanggalawal', '$waktuawal', '$tanggalakhir', '$waktuakhir',
'$jenisusulan', '$ruangan', '$layout_ruangan', '$lampiranName', 'pending')";


if (mysqli_query($koneksi, $sql)) {
    $id_baru = mysqli_insert_id($koneksi);
    $_SESSION['reservasi_id'] = $id_baru;
    ?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            .swal2-popup {
                font-size: 16px !important;
                max-width: 90% !important;
                width: 25% !important;
            }

            .swal2-title {
                font-size: 18px !important;
                font-weight: 600;
            }

            .swal2-html-container {
                font-size: 14px !important;
            }

            .swal2-actions button {
                min-width: 100px;
                padding: 8px 16px;
                font-size: 14px !important;
                font-weight: 500;
            }

            @media (max-width: 600px) {
                .swal2-popup {
                    font-size: 14px !important;
                    width: 95% !important;
                }

                .swal2-title {
                    font-size: 16px !important;
                }

                .swal2-actions button {
                    width: 100% !important;
                }
            }
        </style>
    </head>

    <body>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Reservasi berhasil!',
                html: 'Terima kasih telah memesan!<br>Mohon tunggu konfirmasi dari admin.<br>(Minimal 3 hari kerja).',
                confirmButtonText: 'OK',
                confirmButtonColor: '#007bff'
            }).then(() => {
                window.location.href = 'Dashboard.php';
            });

        </script>
    </body>

    </html>
    <?php
    exit;
} else {
    $err = mysqli_error($koneksi);
    ?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            .swal2-popup {
                max-width: 90% !important;
                width: auto !important;
                font-size: 14px !important;
            }

            @media (max-width: 600px) {
                .swal2-popup {
                    width: 95% !important;
                }
            }
        </style>
    </head>

    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Reservasi gagal!',
                text: 'Terjadi kesalahan: <?= addslashes($err) ?>',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'Dashboard.php';
            });
        </script>
    </body>

    </html>
    <?php
    exit;
}
?>