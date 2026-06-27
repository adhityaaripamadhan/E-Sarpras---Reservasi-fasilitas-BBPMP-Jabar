<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-sapras BBPMP Jabar - Jadwal Ruangan</title>
  <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">

  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * {margin:0; padding:0; box-sizing:border-box;}
    body {
      font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background:linear-gradient(180deg,#f0f6fb,#e6eef4);
      padding:30px 20px;
      color:#333;
    }

    h2 {
      color:#0077b6;
      font-size:28px;
      margin-bottom:30px;
      text-align:center;
      text-transform:uppercase;
      letter-spacing:1px;
    }

    .schedule-container {
      max-width:850px;
      margin:0 auto;
      display:flex;
      flex-direction:column;
      gap:18px;
    }

    .event-card {
      background:#ffffff;
      padding:20px 22px;
      border-radius:16px;
      border:1px solid #e0e7ef;
      border-left:7px solid #0090d4;
      box-shadow:0 4px 12px rgba(0,0,0,0.05);
      transition:transform 0.25s ease, box-shadow 0.25s ease;
    }
    .event-card:hover {
      transform:translateY(-4px);
      box-shadow:0 6px 18px rgba(0,0,0,0.12);
    }

    .event-title {
      font-size:19px;
      font-weight:600;
      color:#0090d4;
      margin-bottom:12px;
      border-bottom:1px dashed #d6e4ef;
      padding-bottom:6px;
      display:flex;
      align-items:center;
      gap:8px;
    }

    .event-info {
      font-size:15px;
      margin:8px 0;
      display:flex;
      align-items:center;
      color:#444;
      gap:8px;
    }

    .event-info i {
      color:#0077b6;
      font-size:16px;
      width:18px;
      text-align:center;
    }

    .event-footer {
      margin-top:12px;
      font-size:14px;
      color:#555;
      background:#f8fbfd;
      padding:8px 12px;
      border-radius:8px;
      border-left:3px solid #a8d0e6;
      display:flex;
      align-items:center;
      gap:8px;
    }

    .event-footer i {
      color:#0077b6;
    }

    .btn_kembali {
      display:flex;
      justify-content:center;
      margin-top:30px;
    }

    .btn_kembali a {
      display:inline-block;
      background:#0090d4;
      color:white;
      padding:12px 28px;
      border-radius:10px;
      font-weight:bold;
      font-size:15px;
      text-decoration:none;
      transition:background 0.3s, transform 0.2s;
    }
    .btn_kembali a:hover {
      background:#007bb3;
      transform:translateY(-2px);
    }

    @media (max-width:768px) {
      body {padding:20px;}
      h2 {font-size:22px;}
      .event-card {padding:16px;}
      .event-title {font-size:17px;}
      .event-info {font-size:14px;}
    }
  </style>
</head>
<body>
<?php
// fungsi ubah tanggal ke format Indonesia
function tanggal_indo($tanggal) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $pecah = explode('-', $tanggal);
    return $pecah[2] . ' ' . $bulan[(int)$pecah[1]] . ' ' . $pecah[0];
}

if (isset($_GET['jenis'])) {
  include 'koneksi.php';
  $jenis = $_GET['jenis'];

  $stmt = $koneksi->prepare("
      SELECT NamaKegiatan, TanggalAwal, TanggalAkhir, WaktuAwal, WaktuAkhir, Nama, Pengusul 
      FROM reservasi 
      WHERE Ruangan = ? AND status = 'disetujui'
      ORDER BY TanggalAwal ASC
  ");
  $stmt->bind_param('s', $jenis);
  $stmt->execute();
  $result = $stmt->get_result();

  echo '<h2>' . htmlspecialchars($jenis) . '</h2>';
  echo "<div class='schedule-container'>";

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $tglAwal = tanggal_indo($row['TanggalAwal']);
      $tglAkhir = tanggal_indo($row['TanggalAkhir']);

      echo "<div class='event-card'>
              <div class='event-title'><i class='fa-solid fa-calendar-day'></i>" . htmlspecialchars($row['NamaKegiatan']) . "</div>
              <div class='event-info'><i class='fa-solid fa-calendar'></i><span>$tglAwal s/d $tglAkhir</span></div>
              <div class='event-info'><i class='fa-solid fa-clock'></i><span>" . htmlspecialchars($row['WaktuAwal']) . " - " . htmlspecialchars($row['WaktuAkhir']) . "</span></div>
              <div class='event-footer'><i class='fa-solid fa-user'></i><span>" . htmlspecialchars($row['Nama']) . " (" . htmlspecialchars($row['Pengusul']) . ")</span></div>
            </div>";
    }
  } else {
    echo "<p style='text-align:center; color:#666; font-size:16px;'>✅ Ruangan tersedia, belum ada jadwal kegiatan.</p>";
  }

  echo "</div>";
  $stmt->close();
  $koneksi->close();
} else {
  echo "<p style='text-align:center; color:red;'>Jenis ruangan tidak ditentukan.</p>";
}
?>

<div class="btn_kembali">
  <a href="#" onclick="history.back(); return false;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>
</body>
</html>
