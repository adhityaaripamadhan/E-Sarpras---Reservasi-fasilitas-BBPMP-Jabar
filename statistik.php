<?php
$current_page = basename($_SERVER['PHP_SELF']);
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id'])) {
    echo "
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <title>Akses Ditolak</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Akses Ditolak',
                text: 'Silakan login terlebih dahulu',
                confirmButtonText: 'OK',
                confirmButtonColor: '#007bff'
            }).then(() => {
                window.location.href = 'formlogin.php';
            });
        </script>
    </body>
    </html>";
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <title>Akses Ditolak</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Akses Ditolak',
                text: 'Halaman ini hanya bisa diakses oleh Admin',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            }).then(() => {
                window.location.href = 'Dashboard.php';
            });
        </script>
    </body>
    </html>";
    exit;
}

$id_admin = $_SESSION['id'];
$query_admin = mysqli_query($koneksi, "SELECT username FROM akun WHERE id = '$id_admin' LIMIT 1");
$admin = mysqli_fetch_assoc($query_admin);

$total_ruangan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM ruangan"))['total'];
$total_reservasi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM reservasi"))['total'];

// === Status Data ===
$status_data = [];
$status_labels = ['pending', 'proses', 'disetujui', 'ditolak'];
foreach ($status_labels as $status) {
    $status_data[$status] = mysqli_fetch_assoc(mysqli_query(
        $koneksi,
        "SELECT COUNT(*) as total FROM reservasi WHERE status='$status'"
    ))['total'];
}

// === Reservasi Per Bulan ===
$reservasi_per_bulan = mysqli_query($koneksi, "
    SELECT DATE_FORMAT(TanggalAwal, '%Y-%m') as bulan, COUNT(*) as jumlah
    FROM reservasi
    GROUP BY DATE_FORMAT(TanggalAwal, '%Y-%m')
    ORDER BY bulan ASC
");
$bulan_labels = [];
$bulan_data = [];
while ($row = mysqli_fetch_assoc($reservasi_per_bulan)) {
    $bulan_labels[] = $row['bulan'];
    $bulan_data[] = $row['jumlah'];
}

// === Ruangan Populer ===
$ruangan_populer = mysqli_query($koneksi, "
    SELECT Ruangan, COUNT(*) as jumlah
    FROM reservasi
    GROUP BY Ruangan
    ORDER BY jumlah DESC
    LIMIT 5
");
$ruangan_labels = [];
$ruangan_jumlah = [];
while ($row = mysqli_fetch_assoc($ruangan_populer)) {
    $ruangan_labels[] = $row['Ruangan'];
    $ruangan_jumlah[] = $row['jumlah'];
}

// === Kategori Internal vs Eksternal ===
$reservasi_kategori = mysqli_query($koneksi, "
    SELECT a.kategori, COUNT(r.id) AS jumlah
    FROM reservasi r
    JOIN akun a ON r.Email = a.email
    GROUP BY a.kategori
");
$kategori_labels = [];
$kategori_data = [];
while ($row = mysqli_fetch_assoc($reservasi_kategori)) {
    $kategori_labels[] = ucfirst($row['kategori']);
    $kategori_data[] = $row['jumlah'];
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Statistik - BBPMP Jabar</title>
    <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .nav-sidebar .nav-link {
            transition: all 0.2s ease-in-out;
            border-radius: 6px;
            display: flex;
            align-items: center;
        }

        .nav-sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }

        .nav-sidebar .nav-link:hover {
            background-color: #0056b3 !important;
            color: #fff !important;
        }

        .nav-sidebar .nav-link.active {
            background-color: #007bff !important;
            color: #fff !important;
            font-weight: bold;
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
        }

        .small-box {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .small-box:hover {
            transform: translateY(-5px);
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            font-weight: bold;
            background: linear-gradient(45deg, #007bff, #00bcd4);
            color: white;
            border-radius: 12px 12px 0 0 !important;
        }

        h2 i {
            color: #007bff;
            margin-right: 10px;
        }

        #calendar {
            max-width: 95%;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a href="Dashboard2.php" class="brand-link">
                <img src="../ASSET/logoicon.png" alt="Logo" class="brand-image img-circle " style="opacity: .8">
                <span class="brand-text font-weight-light">BBPMP Jabar</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="image">
                            <img src="../ASSET/pp.jpeg" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block"><?= htmlspecialchars($admin['username']) ?></a>
                        </div>
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

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                        <li class="nav-item">
                            <a href="statistik.php"
                                class="nav-link <?= $current_page == 'statistik.php' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="infomin.php"
                                class="nav-link <?= $current_page == 'infomin.php' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <p>Fasilitas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="Dashboard2.php"
                                class="nav-link <?= $current_page == 'Dashboard2.php' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Data Peminjam</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="kalender.php" class="nav-link" <?= $current_page == 'kalender.php' ? 'active' : '' ?>>
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Kalender Jadwal</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper p-3">
            <div class="container-fluid">
                <h2 class="mb-4"><i class="fas fa-chart-line"></i> Statistik Reservasi & Ruangan</h2>

                <div class="row">
                    <div class="col-lg-3 col-6">
                        <a href="infomin.php" style="text-decoration:none;color:white;">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?= $total_ruangan ?></h3>
                                    <p>Total Ruangan</p>
                                </div>
                                <div class="icon"><i class="fas fa-door-open"></i></div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-6">
                        <a href="Dashboard2.php" style="text-decoration:none;color:white;">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $total_reservasi ?></h3>
                                    <p>Total Reservasi</p>
                                </div>
                                <div class="icon"><i class="fas fa-calendar-check"></i></div>
                            </div>
                        </a>
                    </div>

                    <?php foreach ($status_labels as $status): ?>
                        <div class="col-lg-3 col-6">
                            <a href="Dashboard2.php?status=<?= $status ?>" style="text-decoration:none;color:white;">
                                <div class="small-box <?=
                                    $status == 'pending' ? 'bg-warning' :
                                    ($status == 'proses' ? 'bg-primary' :
                                        ($status == 'disetujui' ? 'bg-success' : 'bg-danger')) ?>">
                                    <div class="inner">
                                        <h3><?= $status_data[$status] ?></h3>
                                        <p>
                                            <?php if ($status == 'pending'): ?>
                                                <i class="fas fa-hourglass-half"></i> <?= ucfirst($status) ?>
                                            <?php elseif ($status == 'proses'): ?>
                                                <i class="fas fa-spinner"></i> <?= ucfirst($status) ?>
                                            <?php elseif ($status == 'disetujui'): ?>
                                                <i class="fas fa-check-circle"></i> <?= ucfirst($status) ?>
                                            <?php else: ?>
                                                <i class="fas fa-times-circle"></i> <?= ucfirst($status) ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="icon"><i class="fas fa-tasks"></i></div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header"><i class="fas fa-chart-area"></i> Reservasi Per Bulan</div>
                            <div class="card-body">
                                <canvas id="chartBulan"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header"><i class="fas fa-trophy"></i> Top 5 Ruangan Terpopuler</div>
                            <div class="card-body">
                                <canvas id="chartRuangan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><i class="fas fa-users"></i> Perbandingan Pengguna Internal &
                                Eksternal</div>
                            <div class="card-body text-center">
                                <canvas id="chartKategori" style="max-height: 350px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        new Chart(document.getElementById('chartBulan'), {
            type: 'line',
            data: {
                labels: <?= json_encode($bulan_labels) ?>,
                datasets: [{
                    label: 'Jumlah Reservasi',
                    data: <?= json_encode($bulan_data) ?>,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0,123,255,0.3)',
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#007bff',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 6
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('chartRuangan'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($ruangan_labels) ?>,
                datasets: [{
                    label: 'Jumlah Dipinjam',
                    data: <?= json_encode($ruangan_jumlah) ?>,
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#dc3545'],
                    borderRadius: 6
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });

        new Chart(document.getElementById('chartKategori'), {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($kategori_labels) ?>,
                datasets: [{
                    data: <?= json_encode($kategori_data) ?>,
                    backgroundColor: ['#007bff', '#28a745'],
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#333',
                            font: { size: 14, weight: 'bold' }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Perbandingan Pengguna Internal & Eksternal',
                        color: '#007bff',
                        font: { size: 16, weight: 'bold' }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        bodyColor: '#333',
                        titleColor: '#007bff',
                        borderColor: '#007bff',
                        borderWidth: 1
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true
                },
                cutout: '65%' // bikin lubang tengah biar lebih modern
            }
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