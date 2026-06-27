<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$nohp = trim($_POST['nohp']);
$password = trim($_POST['password']);
$confirm_password = trim($_POST['confirm_password']);
$kategori = isset($_POST['kategori']) ? $_POST['kategori'] : '';

// ALERT
function showAlert($icon, $title, $text, $redirect)
{
    echo "
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Proses Registrasi</title>
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
                window.location.href = '../$redirect';
            });
        </script>
    </body>
    </html>
    ";
    exit;
}

// CEK INPUT KOSONG
if (empty($username) || empty($email) || empty($nohp) || empty($password) || empty($confirm_password) || empty($kategori)) {
    showAlert('warning', 'Form Tidak Lengkap', 'Semua field harus diisi.', 'daftar.php');
}

// CEK PASSWORD SAMA
if ($password !== $confirm_password) {
    showAlert('error', 'Password Tidak Sama', 'Konfirmasi password tidak sesuai.', 'daftar.php');
}

// CEK KATEGORI VALID
if (!in_array($kategori, ['internal', 'eksternal'])) {
    showAlert('error', 'Kategori Tidak Valid', 'Silakan pilih kategori pengguna yang sesuai.', 'daftar.php');
}

// HASH PASSWORD
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// CEK USERNAME ATAU EMAIL SUDAH ADA
$stmt = $koneksi->prepare("SELECT id FROM akun WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    showAlert('error', 'Registrasi Gagal', 'Username atau Email sudah digunakan.', 'daftar.php');
}

// SIMPAN DATA KE DATABASE DENGAN KATEGORI
$stmt = $koneksi->prepare("INSERT INTO akun (username, email, nohp, password, kategori) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $username, $email, $nohp, $hashed_password, $kategori);

if ($stmt->execute()) {
    showAlert('success', 'Registrasi Berhasil', 'Akun kamu berhasil dibuat. Silakan login.', 'login.php');
} else {
    showAlert('error', 'Gagal Menyimpan', 'Terjadi kesalahan saat menyimpan data.', 'daftar.php');
}
?>
