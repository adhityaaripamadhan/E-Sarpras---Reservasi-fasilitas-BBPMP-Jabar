<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'koneksi.php';

$username = trim($_POST['username']);
$password = trim($_POST['password']);

if (empty($username) || empty($password)) {
    showAlert('warning', 'Form Tidak Lengkap', 'Username dan password harus diisi!', 'login.php');
    exit;
}

$stmt = $koneksi->prepare("SELECT * FROM akun WHERE username = ?");
if (!$stmt) {
    die("Query gagal: " . $koneksi->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $username;
        $_SESSION['status'] = "login";
        $_SESSION['role'] = $row['role'];

        if ($row['role'] == 'admin') {
            showAlert('success', 'Login Berhasil', 'Selamat datang, Admin!', '../statistik.php');
        } else {
            showAlert('success', 'Login Berhasil', 'Selamat datang!', '../Dashboard.php');
        }
        exit;
    }
}

showAlert('error', 'Login Gagal', 'Username atau password salah!', 'login.php');
exit;
function showAlert($icon, $title, $text, $redirect)
{
    echo "
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Proses Login</title>
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
?>