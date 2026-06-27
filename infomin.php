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
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Informasi Fasilitas BBPMP Jabar</title>
    <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn-edit,
        .btn-hapus {
            flex: 1;
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 4px;
            transition: all 0.2s ease;
            text-align: center;
        }

        .btn-edit {
            background-color: #007bff;
            color: white;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }

        .btn-hapus {
            background-color: #dc3545;
            color: white;
        }

        .btn-hapus:hover {
            background-color: #a71d2a;
        }

        .btn-detail {
            background-color: #bfc0c2ff;
            color: white;
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 4px;
            transition: all 0.2s ease;
            text-align: center;
        }

        .btn-detail:hover {
            background-color: #8a8a8aff;
        }


        .group1 {
            margin-top: 25px;
            display: flex;
            justify-content: flex-start;
            flex-wrap: nowrap;
            gap: 14px;
            overflow-x: auto;
            padding: 10px 5px;
            scrollbar-width: thin;
        }

        .group1::-webkit-scrollbar {
            height: 6px;
        }

        .group1::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .group1 a {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            font-size: 15px;
            border-radius: 30px;
            text-decoration: none;
            background: linear-gradient(135deg, #fdfdfd, #ececec);
            color: #333;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .group1 a.active {
            background: #007bff;
            color: white;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            display: flex;
            flex-direction: column;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid #ddd;
            background: #fff;
            height: 100%;
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            cursor: pointer;
        }

        .card-content {
            display: flex;
            flex-direction: column;
            flex: 1;
            padding: 10px;
        }

        .card-content p {
            margin-bottom: 8px;
        }

        .status-kosong {
            color: green;
            font-weight: bold;
        }

        .status-pinjam {
            color: red;
            font-weight: bold;
        }

        .category {
            color: #007bff;
        }

        .title {
            font-weight: bold;
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
                <img src="../ASSET/logoicon.png" alt="Logo" class="brand-image img-circle" style="opacity: .8">
                <span class="brand-text font-weight-light">BBPMP Jabar</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="image"><img src="../ASSET/pp.jpeg" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info"><a href="#" class="d-block"><?= htmlspecialchars($admin['username']) ?></a>
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
                        <li class="nav-item"><a href="statistik.php"
                                class="nav-link <?= $current_page == 'statistik.php' ? 'active' : '' ?>"><i
                                    class="nav-icon fas fa-chart-bar"></i>
                                <p>Dashboard</p>
                            </a></li>
                        <li class="nav-item"><a href="infomin.php"
                                class="nav-link <?= $current_page == 'infomin.php' ? 'active' : '' ?>"><i
                                    class="nav-icon fas fa-info-circle"></i>
                                <p>Fasilitas</p>
                            </a></li>
                        <li class="nav-item"><a href="Dashboard2.php"
                                class="nav-link <?= $current_page == 'Dashboard2.php' ? 'active' : '' ?>"><i
                                    class="nav-icon fas fa-file-alt"></i>
                                <p>Data Peminjam</p>
                            </a></li>
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
        <main class="content-wrapper p-3">
            <div class="container-fluid">
                <div class="p-4 mb-3" style="background-color:#007bff; color:#fff; border-radius:8px;">
                    <h2 class="mb-1">Informasi Fasilitas BBPMP Jabar</h2>
                    <p class="mb-0">Daftar ruangan dan kapasitas yang tersedia</p>
                </div>
                <div class="mb-3">
                    <button onclick="window.location.href='tambah_ruangan.php'" class="btn btn-primary">+ Tambah
                        Ruangan</button>
                </div>
                <div class="group1 mb-4">
                    <a class="active" onclick="filterKategori(this, 'semua')">Semua</a>
                    <?php
                    $kategoriList = [];
                    $queryKategori = mysqli_query($koneksi, "SELECT nama_ruangan FROM ruangan");
                    while ($rowKategori = mysqli_fetch_assoc($queryKategori)) {
                        $nama_ruangan = strtolower($rowKategori['nama_ruangan']);
                        if (stripos($nama_ruangan, 'aula') !== false) {
                            $kategori = 'aula';
                        } elseif (stripos($nama_ruangan, 'kelas') !== false) {
                            $kategori = 'kelas';
                        } elseif (stripos($nama_ruangan, 'mess') !== false) {
                            $kategori = 'mess';
                        } else {
                            $kategori = 'lainnya';
                        }
                        if (!in_array($kategori, $kategoriList)) {
                            $kategoriList[] = $kategori;
                            echo "<a onclick=\"filterKategori(this, '$kategori')\">" . ucfirst($kategori) . "</a>";
                        }
                    }
                    ?>
                </div>
                <div class="card-container">
                    <?php
                    $query = "SELECT * FROM ruangan ORDER BY id_ruangan ASC";
                    $result = mysqli_query($koneksi, $query);
                    $today = date('Y-m-d');
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id_ruangan = $row['id_ruangan'];
                        $nama = htmlspecialchars($row['nama_ruangan']);
                        $deskripsi = nl2br(htmlspecialchars($row['deskripsi']));
                        $foto = htmlspecialchars($row['photo']);
                        $url = "jadwal.php?jenis=" . urlencode($nama);
                        if (stripos($nama, 'aula') !== false) {
                            $kategori = 'aula';
                        } elseif (stripos($nama, 'kelas') !== false) {
                            $kategori = 'kelas';
                        } elseif (stripos($nama, 'mess') !== false) {
                            $kategori = 'mess';
                        } else {
                            $kategori = 'lainnya';
                        }
                        $cek = mysqli_query($koneksi, "
                        SELECT Status FROM reservasi
                        WHERE Ruangan = '$nama'
                        AND '$today' BETWEEN TanggalAwal AND TanggalAkhir
                        ORDER BY id DESC LIMIT 1
                    ");
                        $statusText = 'Kosong';
                        $statusClass = 'status-kosong';
                        if (mysqli_num_rows($cek) > 0) {
                            $statusRow = mysqli_fetch_assoc($cek);
                            $status = strtolower($statusRow['Status']);
                            switch ($status) {
                                case 'disetujui':
                                    $statusText = 'Sudah Dipinjam';
                                    $statusClass = 'status-pinjam';
                                    break;
                                case 'proses':
                                    $statusText = 'Sedang Diproses';
                                    $statusClass = 'status-pinjam';
                                    break;
                                case 'pending':
                                    $statusText = 'Menunggu Verifikasi';
                                    $statusClass = 'status-pinjam';
                                    break;
                                case 'ditolak':
                                    $statusText = 'Ditolak';
                                    $statusClass = 'status-pinjam';
                                    break;
                            }
                        }
                        echo "
                    <div class='card' data-kategori='$kategori'>
                        <img src='../ASSET/GALERIDB/$foto' alt='$nama'>
<div class='card-content'>
    <p class='category'>Ruangan</p>
    <p class='title'>$nama</p>
    <p class='desc'>$deskripsi</p>
    <p class='status $statusClass'>$statusText</p>
    <div class='action-buttons'>
        <button class='btn-detail' onclick=\"window.location.href='../$url'\">Detail</button>
        <button class='btn-edit' onclick=\"window.location.href='edit_ruangan.php?id=$id_ruangan'\">Edit</button>
        <button class='btn-hapus' onclick=\"hapusRuangan($id_ruangan)\">Hapus</button>
    </div>
</div>

                    </div>";
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function filterKategori(element, kategori) {
            document.querySelectorAll('.group1 a').forEach(a => a.classList.remove('active'));
            element.classList.add('active');
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                const cardKategori = card.getAttribute('data-kategori');
                card.style.display = (kategori === 'semua' || cardKategori === kategori) ? 'flex' : 'none';
            });
        }
        function hapusRuangan(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data ruangan ini akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `hapus_ruangan.php?id=${id}`;
                }
            });
        }
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
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }
    </script>
</body>

</html>