<?php
session_start();
include 'koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validasi login admin
if (!isset($_SESSION['id'])) {
  header("Location: formlogin.php");
  exit();
}

// Ambil data admin yang login
$admin_id = $_SESSION['id'];
$query_admin = mysqli_query($koneksi, "SELECT username FROM akun WHERE id='$admin_id'");
$admin = mysqli_fetch_assoc($query_admin);

// Ambil data reservasi yang disetujui & belum lewat
$query = "
  SELECT NamaKegiatan AS nama_kegiatan, 
         Ruangan AS ruangan, 
         TanggalAwal AS tanggal_awal, 
         TanggalAkhir AS tanggal_akhir, 
         WaktuAwal AS waktu_awal, 
         WaktuAkhir AS waktu_akhir
  FROM reservasi
  WHERE status = 'disetujui' 
    AND STR_TO_DATE(TanggalAkhir, '%Y-%m-%d') >= CURDATE()
  ORDER BY STR_TO_DATE(TanggalAwal, '%Y-%m-%d') ASC
";
$result = mysqli_query($koneksi, $query);

// Fungsi menghasilkan warna lembut otomatis berdasarkan nama ruangan
function generateColor($text) {
  $hash = md5($text);
  $r = hexdec(substr($hash, 0, 2));
  $g = hexdec(substr($hash, 2, 2));
  $b = hexdec(substr($hash, 4, 2));
  // Pucatkan warna agar lembut
  $r = ($r + 255) / 2;
  $g = ($g + 255) / 2;
  $b = ($b + 255) / 2;
  return sprintf("#%02X%02X%02X", $r, $g, $b);
}

$events = [];
while ($row = mysqli_fetch_assoc($result)) {
  $color = generateColor($row['ruangan']);
  $start = $row['tanggal_awal'] . "T" . $row['waktu_awal'];
  $end   = $row['tanggal_akhir'] . "T" . $row['waktu_akhir'];

  $events[] = [
    'title' => $row['nama_kegiatan'] . " — " . $row['ruangan'],
    'start' => $start,
    'end'   => $end,
    'backgroundColor' => $color,
    'borderColor' => $color,
    'textColor' => '#000',
    'extendedProps' => [
      'ruangan' => $row['ruangan'],
      'status' => 'disetujui'
    ]
  ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kalender Jadwal - BBPMP Jabar</title>
  <link rel="icon" href="../ASSET/logoicon.png">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales-all.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background: #f5f6f7;
      font-family: "Segoe UI", sans-serif;
      color: #000;
    }

    /* === Layout utama === */
    .content-wrapper {
      margin-left: 270px;
      padding: 25px;
      display: flex;
      gap: 12px;
      align-items: flex-start;
    }

    /* === Kalender utama === */
    #calendar {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      flex: 3;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    /* Tombol navigasi */
    .fc .fc-button {
      border: none !important;
      background: transparent !important;
      color: #000 !important;
      padding: 5px 10px;
      margin: 0 8px;
      border-radius: 6px;
      transition: 0.25s;
      font-weight: 500;
    }
    .fc .fc-button:hover {
      background: #e8e8e8 !important;
      transform: scale(1.05);
    }

    .fc-toolbar-title {
      color: #000;
      font-size: 22px;
      font-weight: 600;
    }

    .fc-col-header-cell-cushion,
    .fc-daygrid-day-number {
      color: #000 !important;
      font-weight: 500;
    }

    .fc-daygrid-day:hover {
      background: #f1f1f1;
      cursor: pointer;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- === Sidebar kiri === -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <a href="Dashboard2.php" class="brand-link">
      <img src="../ASSET/logoicon.png" class="brand-image img-circle" alt="Logo">
      <span class="brand-text font-weight-light">BBPMP Jabar</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <div class="image"><img src="../ASSET/pp.jpeg" class="img-circle elevation-2" alt="User"></div>
          <div class="info"><a href="#" class="d-block"><?= htmlspecialchars($admin['username']) ?></a></div>
        </div>
        <div>
                        <form id="logoutForm" action="logout.php" method="POST" style="display:inline;">
                            <button type="button" class="btn btn-danger btn-sm" title="Logout"
                                onclick="konfirmasiLogout()">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
      </div>

      <!-- === Navigasi Sidebar === -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item"><a href="statistik.php" class="nav-link"><i class="nav-icon fas fa-chart-bar"></i><p>Dashboard</p></a></li>
          <li class="nav-item"><a href="infomin.php" class="nav-link"><i class="nav-icon fas fa-info-circle"></i><p>Fasilitas</p></a></li>
          <li class="nav-item"><a href="Dashboard2.php" class="nav-link"><i class="nav-icon fas fa-file-alt"></i><p>Data Peminjam</p></a></li>
          <li class="nav-item"><a href="kalender.php" class="nav-link active"><i class="nav-icon fas fa-calendar-alt"></i><p>Kalender Jadwal</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- === Konten utama === -->
  <div class="content-wrapper">
    <div id="calendar"></div>
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const events = <?= json_encode($events) ?>;

  const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
    initialView: 'dayGridMonth',
    locale: 'id',
    headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' },
    buttonText: { today: 'Hari Ini', month: 'Bulan', week: 'Minggu', day: 'Hari' },
    events: events,

    eventDidMount: function(info) {
      info.el.setAttribute('title', info.event.title + ' - ' + info.event.extendedProps.ruangan);
    },

    eventClick: function(info) {
      const e = info.event.extendedProps;
      const mulai = new Date(info.event.start).toLocaleString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit'
      });
      const selesai = new Date(info.event.end).toLocaleString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit'
      });

      Swal.fire({
        title: info.event.title,
        html: `
          <p><b>Ruangan:</b> ${e.ruangan}</p>
          <p><b>Waktu:</b> ${mulai} s/d ${selesai}</p>
          <p><b>Status:</b> <span style="color:green">Disetujui</span></p>
        `,
        icon: 'info',
        confirmButtonColor: '#000',
        confirmButtonText: 'Tutup'
      });
    },
    height: 'auto'
  });
  calendar.render();
});

function konfirmasiLogout() {
            Swal.fire({
                title: 'Yakin ingin Keluar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('logoutForm').submit();
            });
        }
</script>
</body>
</html>
