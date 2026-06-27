<?php
$current_page = basename($_SERVER['PHP_SELF']);
session_start();
include 'koneksi.php';

// === CEK LOGIN ===
if (!isset($_SESSION['id'])) {
    echo "
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <title>Akses Ditolak</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <style>
            body {
                background: linear-gradient(135deg, #e0eafc, #cfdef3);
                font-family: 'Poppins', sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
        </style>
    </head>
    <body>
        <script>
            Swal.fire({
                <title>Akses Ditolak</title>
        <!-- Memuat library SweetAlert2 untuk menampilkan pop-up notifikasi -->
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script> 
    </head>
    <body>
        <script>
            // Menampilkan pop-up peringatan menggunakan SweetAlert2
            Swal.fire({
                icon: 'warning', // Ikon peringatan
                title: 'Akses Ditolak', // Headline notifikasi
                text: 'Silakan login terlebih dahulu', // Pesan notifikasi
                confirmButtonText: 'OK', // Teks pada tombol konfirmasi
                confirmButtonColor: '#007bff' // Warna tombol konfirmasi
            }).then(() => {
                // Setelah pengguna menekan OK, arahkan ke halaman login
                window.location.href = 'formlogin.php';
            });
        </script>
    </body>
    </html>";
    exit;
}

// === CEK ROLE ADMIN ===
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <title>Akses Ditolak</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css'/>
        <style>
            body {
                background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
                font-family: 'Poppins', sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
        </style>
    </head>
    <body>
        <script>
            Swal.fire({
                title: '🚫 Akses Ditolak',
                text: 'Halaman ini hanya dapat diakses oleh Admin.',
                icon: 'error',
                background: 'rgba(255,255,255,0.95)',
                confirmButtonText: 'Kembali ke Dashboard',
                confirmButtonColor: '#dc3545',
                backdrop: `
                    rgba(0,0,0,0.4)
                    url('https://media.tenor.com/7zLh9G0m0yAAAAAC/error.gif')
                    center top
                    no-repeat
                `,
                customClass: {
                    popup: 'rounded-4 shadow-lg p-3'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then(() => {
                window.location.href = 'Dashboard2.php';
            });
        </script>
    </body>
    </html>";
    exit;
}



$id_admin = $_SESSION['id']; // Mengambil ID admin yang sedang login dari session

// Melakukan query ke tabel akun untuk mengambil data username berdasarkan ID admin
$query_admin = mysqli_query($koneksi, "SELECT username FROM akun WHERE id = '$id_admin' LIMIT 1");

$admin = mysqli_fetch_assoc($query_admin);// Mengambil hasil query dalam bentuk array asosiatif

// Cek apakah ada parameter status yang dikirim melalui URL (GET)
// Jika ada, simpan nilainya ke variabel $filter_status, jika tidak, beri nilai kosong ('')
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

// Membuat query SQL berdasarkan apakah filter status digunakan atau tidak
// Jika $filter_status tidak kosong, ambil data reservasi dengan status tertentu
// Jika kosong, ambil semua data dari tabel reservasi
$sql = $filter_status ?
    "SELECT * FROM reservasi WHERE status = '$filter_status'" :
    "SELECT * FROM reservasi";

// Menjalankan query dan menyimpan hasilnya ke variabel $hasil
$hasil = $koneksi->query($sql);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - E-Sapras BBPMP Jabar</title>
    <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
    <!-- IMPORT ADMIN LTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- IMPORT FONT AWESOME ICON -->
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

        td:last-child {
            white-space: nowrap;
            width: 100%;
        }


        .text_peminjaman {
            position: relative;
            background-color: #007bff;
            width: 100%;
            height: 90px;
            padding-top: 24px;
            color: white;
            border-radius: 5px;
        }

        .btn-group {
            margin: 5px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 20px;
            padding: 6px 12px;
            border: 1px solid #ccc;
            margin-left: 10px;
        }

        .dataTables_wrapper .dataTables_filter {
            text-align: left !important;
        }

        .dataTables_wrapper .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 20px;
            padding: 6px 12px 6px 30px;
            border: 1px solid #ccc;
            width: 220px;
            background: url('https://cdn-icons-png.flaticon.com/512/622/622669.png') no-repeat 8px center;
            background-size: 14px;
        }

        .btn-bukti {
            background-color: #17a2b8;
            color: #fff;
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 13px;
        }

        .btn-bukti:hover {
            background-color: #138496;
            color: #fff;
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

        <!-- Sidebar Navigasi Utama -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a href="Dashboard2.php" class="brand-link">
                <!-- Logo dan keterangan lembaga-->
                <img src="../ASSET/logoicon.png" alt="Logo" class="brand-image img-circle" style="opacity: .8">
                <span class="brand-text font-weight-light">BBPMP Jabar</span>
            </a>
            <div class="sidebar">
                <!-- Panel pengguna (menampilkan username dan tombol logout) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-between align-items-center">
                    <!-- Info pengguna -->
                    <div class="d-flex align-items-center">
                        <div class="image">
                            <!-- Profile pengguna -->
                            <img src="../ASSET/pp.jpeg" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <!-- Menampilkan nama pengguna dari database -->
                            <a href="#" class="d-block"><?= htmlspecialchars($admin['username']) ?></a>
                        </div>
                    </div>

                    <!-- Tombol logout di sisi kanan -->
                    <div>
                        <form id="logoutForm" action="logout.php" method="POST" style="display:inline;">
                            <button type="button" class="btn btn-danger btn-sm" title="Logout"
                                onclick="konfirmasiLogout()">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Menu navigasi utama -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                        <!-- Item menu Dashboard -->
                        <li class="nav-item">
                            <a href="statistik.php"
                                class="nav-link <?= $current_page == 'statistik.php' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Item menu Fasilitas -->
                        <li class="nav-item">
                            <a href="infomin.php"
                                class="nav-link <?= $current_page == 'infomin.php' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <p>Fasilitas</p>
                            </a>
                        </li>

                        <!-- Item menu Data Peminjam -->
                        <li class="nav-item">
                            <a href="Dashboard2.php"
                                class="nav-link <?= $current_page == 'Dashboard2.php' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Data Peminjam</p>
                            </a>
                        </li>

                        <!-- Item menu Kalender Jadwal -->
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

        <!-- Konten Data Peminjaman -->
        <div class="content-wrapper">
            <section class="content-header text-center">
                <center>
                    <h1 class="text_peminjaman">Data Peminjaman Fasilitas</h1>
                </center>
            </section>

            <section class="content">
                <div class="card mb-3">
                    <div class="card-body d-flex align-items-center gap-2 flex-wrap">

                        <!-- Button export data -->
                        <div class="btn-group">
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Export
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="exportExcel()">Excel</a>
                                <a class="dropdown-item" href="#" onclick="exportPDF()">PDF</a>
                            </div>
                        </div>

                        <!-- Drop down Filter Status Reservasi -->
                        <div class="btn-group">
                            <!-- Tombol dropdown -->
                            <button class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">
                                <?= $filter_status ? ucfirst($filter_status) : 'Semua Status' ?>
                            </button>

                            <!-- Menu dropdown yang berisi pilihan status -->
                            <div class="dropdown-menu">
                                <!-- Semua data tanpa filter -->
                                <a href="<?= $current_page ?>"
                                    class="dropdown-item <?= ($filter_status == '' ? 'active' : '') ?>">Semua</a>

                                <!-- Filter data dengan status 'pending' -->
                                <a href="<?= $current_page ?>?status=pending"
                                    class="dropdown-item <?= ($filter_status == 'pending' ? 'active' : '') ?>">Pending</a>

                                <!-- Filter data dengan status 'proses' -->
                                <a href="<?= $current_page ?>?status=proses"
                                    class="dropdown-item <?= ($filter_status == 'proses' ? 'active' : '') ?>">Proses</a>

                                <!-- Filter data dengan status 'disetujui' -->
                                <a href="<?= $current_page ?>?status=disetujui"
                                    class="dropdown-item <?= ($filter_status == 'disetujui' ? 'active' : '') ?>">Disetujui</a>

                                <!-- Filter data dengan status 'ditolak' -->
                                <a href="<?= $current_page ?>?status=ditolak"
                                    class="dropdown-item <?= ($filter_status == 'ditolak' ? 'active' : '') ?>">Ditolak</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="tabelData" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead class="text-center">
                                <tr>
                                    <th style="width:60px">No</th>
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
                                    <th>Surat Resmi</th>
                                    <th>Status</th>
                                    <th>Bukti Reservasi</th>
                                    <th style="width:160px">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($data = $hasil->fetch_assoc()) { ?>
                                    <?php
                                    $status = $data['status'] ?? 'pending';
                                    $badgeClass = $status === 'disetujui' ? 'badge-success'
                                        : ($status === 'ditolak' ? 'badge-danger'
                                            : ($status === 'proses' ? 'badge-info' : 'badge-secondary'));
                                    ?>
                                    <tr class="<?= $status === 'ditolak' ? 'table-danger' : '' ?>">
                                        <td></td>
                                        <td><?= htmlspecialchars($data["Nama"]) ?></td>
                                        <td><?= htmlspecialchars($data["NoHP"]) ?></td>
                                        <td><?= htmlspecialchars($data["Email"]) ?></td>
                                        <td><?= htmlspecialchars($data["NamaKegiatan"]) ?></td>
                                        <td><?= htmlspecialchars($data["Pengusul"]) ?></td>
                                        <td><?= htmlspecialchars($data["Namainstansi"]) ?></td>
                                        <td><?= htmlspecialchars($data["Alamat"]) ?></td>
                                        <td><?= htmlspecialchars($data["TanggalAwal"]) ?></td>
                                        <td><?= htmlspecialchars($data["TanggalAkhir"]) ?></td>
                                        <td><?= htmlspecialchars($data["WaktuAwal"]) ?></td>
                                        <td><?= htmlspecialchars($data["WaktuAkhir"]) ?></td>
                                        <td><?= htmlspecialchars($data["JenisUsulan"]) ?></td>
                                        <td><?= htmlspecialchars($data["Ruangan"]) ?></td>

                                        <!-- Kolom Lampiran -->
                                        <td class="text-center">
                                            <?php if (!empty($data["lampiran"])): ?>
                                                <?php
                                                $filePath = "/ASSET/GALERIDB/" . $data["lampiran"];
                                                $ext = strtolower(pathinfo($data["lampiran"], PATHINFO_EXTENSION));
                                                ?>
                                                <?php if (in_array($ext, ["jpg", "jpeg", "png", "gif"])): ?>
                                                    <a href="<?= $filePath ?>" target="_blank" title="Lihat lampiran">
                                                        <img src="<?= $filePath ?>" alt="Lampiran"
                                                            style="width:60px;height:auto;border-radius:4px;">
                                                    </a>
                                                <?php elseif ($ext === "pdf"): ?>
                                                    <a href="lihat_lampiran.php?file=<?= urlencode($data['lampiran']) ?>"
                                                        target="_blank">
                                                        <i class="fas fa-file-pdf fa-2x text-danger"></i><br>Lihat PDF
                                                    </a>
                                                <?php elseif (in_array($ext, ["doc", "docx"])): ?>
                                                    <a href="lihat_lampiran.php?file=<?= urlencode($data['lampiran']) ?>"
                                                        target="_blank">
                                                        <i class="fas fa-file-word fa-2x text-primary"></i><br>Lihat Dokumen
                                                    </a>
                                                <?php else: ?>
                                                    <a href="lihat_lampiran.php?file=<?= urlencode($data['lampiran']) ?>"
                                                        target="_blank">
                                                        <i class="fas fa-file fa-2x"></i><br>Lihat File
                                                    </a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Kolom Surat Resmi -->
                                        <td class="text-center">
                                            <?php if (!empty($data['surat_resmi'])): ?>
                                                <?php
                                                $suratPath = "uploads/surat_resmi/" . $data['surat_resmi'];
                                                $ext = strtolower(pathinfo($data['surat_resmi'], PATHINFO_EXTENSION));
                                                ?>
                                                <a href="<?= $suratPath ?>" target="_blank"
                                                    class="btn btn-sm btn-outline-success shadow-sm" title="Lihat Surat">
                                                    <i class="fas fa-file-alt"></i> Lihat Surat
                                                </a>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-primary shadow-sm"
                                                    onclick="uploadSuratResmi(<?= $data['id'] ?>)">
                                                    <i class="fas fa-upload"></i> Upload Surat
                                                </button>
                                            <?php endif; ?>
                                        </td>

                                        <!-- === SCRIPT UPLOAD MODERN === -->
                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                        <link rel="stylesheet"
                                            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

                                        <!-- Kolom Status -->
                                        <td class="text-center">
                                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                                        </td>

                                        <!-- Kolom Bukti Reservasi -->
                                        <td class="text-center">
                                            <?php if ($status == 'disetujui'): ?>
                                                <a href="bukti_reservasi?id=<?= $data['id'] ?>" target="_blank"
                                                    class="btn btn-bukti">
                                                    <i class="fas fa-file-pdf"></i> Lihat Bukti
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Kolom Aksi -->
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center" style="gap:8px;">
                                                <form method="POST" action="update_status" class="flex-grow-1"
                                                    onsubmit="return handleStatusChange(event, this);">
                                                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                                    <input type="hidden" name="alasan_penolakan" value="">
                                                    <select name="status" class="form-control form-control-sm"
                                                        style="width:130px;min-width:80px;"
                                                        onchange="this.form.requestSubmit();">
                                                        <option value="">Kosong</option>
                                                        <option value="pending" <?= ($status == 'pending' ? 'selected' : '') ?>>Pending</option>
                                                        <option value="proses" <?= ($status == 'proses' ? 'selected' : '') ?>>
                                                            Proses</option>
                                                        <option value="disetujui" <?= ($status == 'disetujui' ? 'selected' : '') ?>>Disetujui</option>
                                                        <option value="ditolak" <?= ($status == 'ditolak' ? 'selected' : '') ?>>Ditolak</option>
                                                    </select>
                                                </form>

                                                <div class="d-flex justify-content-end flex-shrink-0" style="gap:6px;">
                                                    <a href="edit.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-success"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button onclick="konfirmasiHapus(<?= $data['id'] ?>)"
                                                        class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
        </div>
    </div>

    <!-- JS Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css" />

    <!-- Export Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>


    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function handleStatusChange(event, form) {
            event.preventDefault(); // cegah submit langsung
            const status = form.querySelector('select[name="status"]').value;
            if (status === 'disetujui') {
                // Konfirmasi saat setuju
                Swal.fire({
                    icon: 'question',
                    title: 'Setujui Reservasi?',
                    text: 'Status akan diubah menjadi Disetujui.',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Setujui',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#d33',
                    background: '#f9fafb',
                }).then((res) => {
                    if (res.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading(),
                        });
                        setTimeout(() => {
                            form.submit();
                        }, 600);
                    }
                });

            } else {
                // Untuk status lain langsung submit
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Perubahan status sedang diproses...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading(),
                });
                setTimeout(() => {
                    form.submit();
                }, 600);
            }
        }

        $(document).ready(function () {
            var t = $('#tabelData').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                lengthMenu: [5, 10, 25, 50, 100],
                info: false,
                language: {
                    search: "",
                    searchPlaceholder: "Cari data...",
                    lengthMenu: "Tampilkan _MENU_ data",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "→",
                        previous: "←"
                    }
                },
                columnDefs: [
                    { orderable: false, targets: [14, 15, 16] }
                ],
                order: [[1, 'asc']],

                dom:
                    "<'row mb-3 d-flex justify-content-start align-items-center'<'col-md-12 d-flex align-items-start gap-2'Bf>>" +
                    "<'row'<'col-12'tr>>" +
                    "<'row mt-3'<'col-md-6 d-flex justify-content-start'p>>",


                buttons: [
                    {
                        text: '📊 Excel',
                        className: 'btn btn-success btn-sm rounded-pill',
                        action: function () { exportExcel(); }
                    },
                    {
                        text: '📄 PDF',
                        className: 'btn btn-danger btn-sm rounded-pill',
                        action: function () { exportPDF(); }
                    }
                ]
            });

            // Penomoran otomatis
            t.on('order.dt search.dt draw.dt', function () {
                let i = 1;
                t.cells(null, 0, { search: 'applied', order: 'applied' }).every(function () {
                    this.data(i++);
                });
            }).draw();
        });
 function exportExcel() {
    const table = document.getElementById("tabelData");
    if (!table) return Swal.fire("Error", "Tabel tidak ditemukan!", "error");

    const clone = table.cloneNode(true);

    // === Identifikasi kolom yang akan dihapus ===
    const headerCells = clone.querySelectorAll("thead th");
    let statusColumns = [];
    let removeIndexes = [];

    headerCells.forEach((th, idx) => {
        const text = th.innerText.trim().toLowerCase();
        if (text === "status") statusColumns.push(idx);
        if (
            text.includes("aksi") ||
            text.includes("action") ||
            text.includes("lampiran") ||
            text.includes("bukti reservasi")
        ) {
            removeIndexes.push(idx);
        }
    });

    // Hapus kolom Status kedua (dropdown)
    if (statusColumns.length > 1) {
        removeIndexes.push(statusColumns[1]);
    }

    // Urutkan dari belakang supaya indeks tidak berubah
    removeIndexes = [...new Set(removeIndexes)].sort((a, b) => b - a);

    clone.querySelectorAll("tr").forEach(tr => {
        removeIndexes.forEach(idx => {
            if (tr.cells.length > idx) tr.deleteCell(idx);
        });
    });

    // === Bersihkan isi sel agar tidak ada tombol/teks tambahan ===
    clone.querySelectorAll("td, th").forEach(cell => {
        let text = cell.innerText || "";

        // Ambil isi badge / tombol saja
        const badge = cell.querySelector(".badge");
        const btn = cell.querySelector("button, a");
        if (badge) text = badge.innerText.trim();
        else if (btn && text.trim() === "") text = btn.innerText.trim();

        // Hapus kode / spasi berlebih
        text = text
            .replace(/<[^>]*>/g, "")
            .replace(/\s{2,}/g, " ")
            .replace(/\n/g, " ")
            .trim();

        cell.textContent = text;
    });

    // === Format tanggal agar rapi ===
    clone.querySelectorAll("tbody tr").forEach(tr => {
        for (let td of tr.cells) {
            const text = td.innerText.trim();
            if (/^\d{4}-\d{2}-\d{2}$/.test(text)) {
                const date = new Date(text);
                if (!isNaN(date)) {
                    td.innerText = date.toLocaleDateString("id-ID");
                }
            }
        }
    });

    // === Buat workbook Excel ===
    const wb = XLSX.utils.table_to_book(clone, { sheet: "Data Reservasi" });
    const ws = wb.Sheets["Data Reservasi"];

    // === Atur lebar kolom otomatis ===
    const range = XLSX.utils.decode_range(ws["!ref"]);
    const colWidths = [];
    for (let C = range.s.c; C <= range.e.c; ++C) {
        let maxWidth = 10;
        for (let R = range.s.r; R <= range.e.r; ++R) {
            const cell = ws[XLSX.utils.encode_cell({ r: R, c: C })];
            if (cell && cell.v) {
                const len = String(cell.v).length;
                if (len > maxWidth) maxWidth = len;
            }
        }
        colWidths.push({ wch: Math.min(maxWidth + 2, 35) });
    }
    ws["!cols"] = colWidths;

    // === Simpan file Excel ===
    const fileName = `Data_Reservasi_${new Date().toISOString().slice(0, 10)}.xlsx`;
    XLSX.writeFile(wb, fileName);

    Swal.fire({
        icon: "success",
        title: "Berhasil",
        text: "Data berhasil diekspor tanpa kolom Aksi & Lampiran.",
        showConfirmButton: false,
        timer: 1600
    });
}

        // === EXPORT PDF ===
        async function exportPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: "landscape", unit: "mm", format: "a3" });

            // Tambahkan logo
            const logo = new Image();
            logo.src = "../ASSET/logoicon.png";
            await new Promise((resolve) => { logo.onload = resolve; logo.onerror = resolve; });
            doc.addImage(logo, "PNG", 15, 12, 20, 20);

            // Header
            doc.setFont("helvetica", "bold");
            doc.setFontSize(18);
            doc.text("Data Peminjaman Fasilitas - BBPMP Jabar", 45, 22);
            doc.setFontSize(12);
            doc.setTextColor(100);
            const now = new Date().toLocaleString("id-ID");
            doc.text(`Diperbarui: ${now}`, 45, 30);

            // Ambil tabel
            const table = document.getElementById("tabelData");
            const headerCells = table.querySelectorAll("thead th");

            let removeIndexes = [];
            let statusIndexes = [];

            headerCells.forEach((th, idx) => {
                const txt = th.innerText.trim().toLowerCase();
                if (
                    txt.includes("aksi") ||
                    txt.includes("lampiran") ||
                    txt.includes("bukti reservasi") ||
                    txt === "status aksi"
                ) {
                    removeIndexes.push(idx);
                }
                if (txt === "status") statusIndexes.push(idx);
            });

            if (statusIndexes.length > 1) {
                removeIndexes.push(statusIndexes[1]);
            }

            removeIndexes = [...new Set(removeIndexes)].sort((a, b) => a - b);

            // Header baru tanpa kolom terhapus
            const headers = [];
            headerCells.forEach((th, idx) => {
                if (!removeIndexes.includes(idx)) headers.push(th.innerText.trim());
            });

            // Body baru tanpa kolom terhapus
            const rows = [];
            table.querySelectorAll("tbody tr").forEach(tr => {
                const row = [];
                tr.querySelectorAll("td").forEach((td, idx) => {
                    if (!removeIndexes.includes(idx)) row.push(td.innerText.trim());
                });
                if (row.length > 0) rows.push(row);
            });

            // Tabel ke PDF
            doc.autoTable({
                startY: 40,
                head: [headers],
                body: rows,
                styles: { fontSize: 9, cellPadding: 3, overflow: 'linebreak' },
                headStyles: { fillColor: [0, 123, 255], textColor: 255, fontSize: 10, halign: 'center' },
                alternateRowStyles: { fillColor: [245, 245, 245] },
                margin: { left: 15, right: 15 },
                didDrawPage: (data) => {
                    const pageCount = doc.internal.getNumberOfPages();
                    doc.setFontSize(9);
                    doc.text(`Halaman ${data.pageNumber} dari ${pageCount}`, 400, 200);
                },
                tableWidth: 'auto'
            });

            doc.save("Data_Reservasi.pdf");
        }





        // FUNSGI SWEETALERT KONFIRMASI HAPUS
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

        // FUNGSI SWEETALERT KONFIRMASI LOGOUT
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

        // FUNGSI NOTIFIKASI HAPUS DATA
        <?php if (isset($_GET['hapus']) && $_GET['hapus'] == 'berhasil') { ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil dihapus',
                confirmButtonColor: '#007bff'
            });
        <?php } ?>

        function uploadSuratResmi(id) {
                                                Swal.fire({
                                                    title: ' Upload Surat Resmi',
                                                    html: `
      <form id="formUploadSurat" enctype="multipart/form-data">
        <input type="file" id="fileSurat" name="surat_resmi" accept=".pdf,.jpg,.jpeg,.png"
          class="swal2-input" style="width:100%;margin-top:10px;" required>
        <input type="hidden" name="id" value="${id}">
      </form>
    `,
                                                    confirmButtonText: 'Upload Sekarang',
                                                    cancelButtonText: 'Batal',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#007bff',
                                                    cancelButtonColor: '#6c757d',
                                                    background: 'rgba(255, 255, 255, 0.9)',
                                                    backdrop: `
      rgba(0,0,0,0.4)
      url('https://media.tenor.com/-ZP3cZ1sx6kAAAAi/upload-cloud.gif')
      center top
      no-repeat
    `,
                                                    customClass: {
                                                        popup: 'rounded-4 shadow-lg animate__animated animate__fadeInDown',
                                                        confirmButton: 'px-4 py-2 rounded-pill fw-semibold',
                                                        cancelButton: 'px-4 py-2 rounded-pill fw-semibold'
                                                    },
                                                    preConfirm: () => {
                                                        const fileInput = document.getElementById('fileSurat');
                                                        if (!fileInput.files.length) {
                                                            Swal.showValidationMessage('Silakan pilih file terlebih dahulu 📂');
                                                            return false;
                                                        }

                                                        const formData = new FormData(document.getElementById('formUploadSurat'));
                                                        return fetch('upload_surat.php', {
                                                            method: 'POST',
                                                            body: formData
                                                        })
                                                            .then(response => {
                                                                if (!response.ok) throw new Error('Gagal upload file');
                                                                return response.text();
                                                            })
                                                            .catch(error => {
                                                                Swal.showValidationMessage(`Upload gagal: ${error}`);
                                                            });
                                                    }
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        Swal.fire({
                                                            title: ' Upload Berhasil!',
                                                            text: 'Surat resmi telah disimpan dengan sukses.',
                                                            icon: 'success',
                                                            confirmButtonColor: '#28a745',
                                                            background: 'rgba(255,255,255,0.95)',
                                                            backdrop: `
          rgba(0,0,0,0.3)
          url('https://media.tenor.com/qzR_FTmgQH0AAAAi/success-tick.gif')
          center top
          no-repeat
        `,
                                                            customClass: {
                                                                popup: 'rounded-4 shadow-lg animate__animated animate__fadeInDown'
                                                            }
                                                        }).then(() => location.reload());
                                                    }
                                                });
                                            }
    </script>
</body>

</html>