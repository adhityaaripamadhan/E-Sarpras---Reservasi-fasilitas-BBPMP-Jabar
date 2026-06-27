<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: formlogin.php");
    exit;
}

$reservasi = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $reservasi = $koneksi->query("SELECT * FROM reservasi WHERE id='$id'")->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Reservasi</title>
</head>
<body>
<?php if ($reservasi): ?>
  <h2><?= htmlspecialchars($reservasi['NamaKegiatan']); ?></h2>
  <p>Ruangan: <?= htmlspecialchars($reservasi['Ruangan']); ?></p>
  <p>Status: <?= htmlspecialchars($reservasi['status']); ?></p>
  <p>Tanggal: <?= $reservasi['TanggalAwal']; ?> s/d <?= $reservasi['TanggalAkhir']; ?></p>
<?php else: ?>
  <p>Reservasi tidak ditemukan.</p>
<?php endif; ?>
</body>
</html>
