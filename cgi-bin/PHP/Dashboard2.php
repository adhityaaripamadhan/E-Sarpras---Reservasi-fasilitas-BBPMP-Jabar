<?php
$current_page = basename($_SERVER['PHP_SELF']);
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id'])) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Akses Ditolak',
            text: 'Silakan login terlebih dahulu',
            confirmButtonText: 'OK',
            confirmButtonColor: '#007bff'
        }).then(() => {
            window.location='formlogin.php';
        });
    </script>";
    exit;
}

$id_admin = $_SESSION['id'];
$query_admin = mysqli_query($koneksi, "SELECT username FROM akun WHERE id = '$id_admin' LIMIT 1");
$admin = mysqli_fetch_assoc($query_admin);

$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

if ($filter_status != '') {
    $sql = "SELECT * FROM reservasi WHERE status = '$filter_status'";
} else {
    $sql = "SELECT * FROM reservasi";
}

$hasil = $koneksi->query($sql);
$no = 1;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - E-Sapras BBPMP Jabar</title>
    <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .nav-sidebar .nav-link {
            transition: all 0.2s ease-in-out;
            border-radius: 6px;
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

        .nav-sidebar .nav-icon {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
        }

        .content-wrapper {
            margin-left: 250px;
        }

        body {
            background: #f4f6f9;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
        }

        .table td,
        .table th {
            vertical-align: middle;
            font-size: 13px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            color: white;
            font-weight: bold;
        }

        .status-pending {
            background-color: #f39c12;
        }

        .status-proses {
            background-color: #3498db;
        }

        .status-disetujui {
            background-color: #27ae60;
        }

        .status-ditolak {
            background-color: #e74c3c;
        }

        .btn-action {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .btn-action a,
        .btn-action select {
            flex: 1;
        }

        .text_peminjaman {
            position: relative;
            background-color: #007bff;
            width: 986px;
            height: 90px;
            padding-top: 24px;
            color: white;
            border-radius: 5px;
        }

        .btn-group {
            margin: 5px;
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
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <section class="content-header text-center">
                <center>
                    <h1 class="text_peminjaman">Data Peminjaman Fasilitas</h1>
                </center>
            </section>
            <section class="content">
                <div class="card mb-3">
                    <div class="card-body d-flex align-items-center gap-2">
                        <div class="btn-group">
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Export
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="exportExcel()">Excel</a>
                                <a class="dropdown-item" href="#" onclick="exportPDF()">PDF</a>
                            </div>
                        </div>

                        <div class="btn-group">
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <?php
                                echo $filter_status ? ucfirst($filter_status) : 'Semua Status';
                                ?>
                            </button>
                            <div class="dropdown-menu">
                                <a href="<?= $current_page ?>"
                                    class="dropdown-item <?= ($filter_status == '' ? 'active' : '') ?>">Semua</a>
                                <a href="<?= $current_page ?>?status=pending"
                                    class="dropdown-item <?= ($filter_status == 'pending' ? 'active' : '') ?>">Pending</a>
                                <a href="<?= $current_page ?>?status=proses"
                                    class="dropdown-item <?= ($filter_status == 'proses' ? 'active' : '') ?>">Proses</a>
                                <a href="<?= $current_page ?>?status=disetujui"
                                    class="dropdown-item <?= ($filter_status == 'disetujui' ? 'active' : '') ?>">Disetujui</a>
                                <a href="<?= $current_page ?>?status=ditolak"
                                    class="dropdown-item <?= ($filter_status == 'ditolak' ? 'active' : '') ?>">Ditolak</a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="tabelData" class="table table-bordered table-striped table-hover">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <th>Email</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Pengusul</th>
                                    <th>Nama Instansi</th>
                                    <th>Alamat</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Waktu Mulai</th>
                                    <th>Waktu Selesai</th>
                                    <th>Jenis Usulan</th>
                                    <th>Ruangan</th>
                                    <th>Lampiran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($data = $hasil->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data["Nama"] ?></td>
                                        <td><?= $data["NoHP"] ?></td>
                                        <td><?= $data["Email"] ?></td>
                                        <td><?= $data["NamaKegiatan"] ?></td>
                                        <td><?= $data["Pengusul"] ?></td>
                                        <td><?= $data["Namainstansi"] ?></td>
                                        <td><?= $data["Alamat"] ?></td>
                                        <td><?= $data["TanggalAwal"] ?></td>
                                        <td><?= $data["TanggalAkhir"] ?></td>
                                        <td><?= $data["WaktuAwal"] ?></td>
                                        <td><?= $data["WaktuAkhir"] ?></td>
                                        <td><?= $data["JenisUsulan"] ?></td>
                                        <td><?= $data["Ruangan"] ?></td>
                                        <td class="text-center">
                                            <?php if (!empty($data["lampiran"])): 
                                                $filePath = "../ASSET/GALERIDB/" . $data["lampiran"];
                                                $ext = strtolower(pathinfo($data["lampiran"], PATHINFO_EXTENSION));
                                                if (in_array($ext, ["jpg","jpeg","png","gif"])): ?>
                                                    <a href="<?= $filePath ?>" target="_blank">
                                                        <img src="<?= $filePath ?>" alt="Lampiran" style="width:60px;height:auto;border-radius:4px;">
                                                    </a>
                                                <?php elseif ($ext === "pdf"): ?>
                                                    <a href="<?= $filePath ?>" target="_blank" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-file-pdf"></i> Lihat PDF
                                                    </a>
                                                <?php elseif (in_array($ext, ["doc","docx"])): ?>
                                                    <a href="<?= $filePath ?>" target="_blank" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-file-word"></i> Lihat Dokumen
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?= $filePath ?>" target="_blank" class="btn btn-secondary btn-sm">
                                                        <i class="fas fa-file"></i> Lihat File
                                                    </a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-<?= ($data['status'] == 'disetujui' ? 'success' : ($data['status'] == 'ditolak' ? 'danger' : ($data['status'] == 'proses' ? 'warning' : 'secondary'))) ?>">
                                                <?= ucfirst($data['status'] ?? 'Pending') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-action">
                                                <form method="POST" action="update_status.php"
                                                    style="display:inline-block;">
                                                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                                    <select name="status" class="form-control form-control-sm"
                                                        onchange="this.form.submit()">
                                                        <option value="">Pilih</option>
                                                        <option value="pending" <?= ($data['status'] == 'pending' ? 'selected' : '') ?>>Pending</option>
                                                        <option value="proses" <?= ($data['status'] == 'proses' ? 'selected' : '') ?>>Proses</option>
                                                        <option value="disetujui" <?= ($data['status'] == 'disetujui' ? 'selected' : '') ?>>Disetujui</option>
                                                        <option value="ditolak" <?= ($data['status'] == 'ditolak' ? 'selected' : '') ?>>Ditolak</option>
                                                    </select>
                                                </form>

                                                <a href="edit.php?id=<?= $data['id'] ?>" class="btn btn-success btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button onclick="konfirmasiHapus(<?= $data['id'] ?>)"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

        </div>
        </section>
    </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function exportExcel() {
            let table = document.getElementById("tabelData");
            let wb = XLSX.utils.table_to_book(table, { sheet: "Data Reservasi" });
            XLSX.writeFile(wb, "data_reservasi.xlsx");
        }

        async function exportPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: "landscape", unit: "mm", format: "a3" });
            doc.setFontSize(14);
            doc.text("Data Peminjaman Fasilitas", 14, 15);

            const rows = [];
            document.querySelectorAll("#tabelData tbody tr").forEach(tr => {
                const row = [];
                tr.querySelectorAll("td").forEach((td, idx) => {
                    if (idx < 15) row.push(td.innerText.trim());
                });
                rows.push(row);
            });

            doc.autoTable({
                startY: 20,
                head: [[
                    "No", "Nama", "No HP", "Email", "Nama Kegiatan", "Pengusul", "Instansi",
                    "Alamat", "Tanggal Mulai", "Tanggal Selesai", "Waktu Mulai", "Waktu Selesai",
                    "Jenis Usulan", "Ruangan", "Status"
                ]],
                body: rows,
                styles: { fontSize: 9, cellPadding: 3, overflow: 'linebreak' },
                headStyles: { fillColor: [52, 152, 219], textColor: 255, halign: 'center' },
                bodyStyles: { halign: 'left' }
            });

            doc.save("data_reservasi.pdf");
        }

        function konfirmasiHapus(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "hapus.php?id=" + id;
                }
            });
        }

        function konfirmasiLogout() {
            Swal.fire({
                title: 'Yakin ingin logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }

        <?php if (isset($_GET['hapus']) && $_GET['hapus'] == 'berhasil') { ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil dihapus',
                confirmButtonColor: '#007bff'
            });
        <?php } ?>
    </script>
</body>
</html>
