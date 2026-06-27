<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id'])) {
  header("Location: formlogin.php");
  exit;
}

$id = $_SESSION['id'];
$user = $koneksi->query("SELECT email FROM akun WHERE id='$id'")->fetch_assoc();
$email = $user['email'];

// --- PROSES DELETE ---
$msg = "";
if (isset($_GET['delete'])) {
  $id_reservasi = intval($_GET['delete']);
  $delete = $koneksi->query("DELETE FROM reservasi WHERE id='$id_reservasi' AND Email='" . $koneksi->real_escape_string($email) . "'");
  if ($delete) {
    $msg = "deleted";
  } else {
    $msg = "error";
  }
}

// --- QUERY DATA ---
$reservasi = $koneksi->query("
    SELECT id, NamaKegiatan, Ruangan, status, TanggalAwal, TanggalAkhir 
    FROM reservasi 
    WHERE Email='" . $koneksi->real_escape_string($email) . "' 
    ORDER BY TanggalAwal DESC
");

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>History Reservasi</title>
  <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 0;
    }

    .container {
      padding: 20px;
      max-width: 1000px;
      margin: 20px auto;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      flex-wrap: wrap;
      gap: 12px;
    }

    .btn-back {
      background: #007bff;
      color: white;
      border: none;
      padding: 8px 14px;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
      text-decoration: none;
      display: inline-block;
      flex-shrink: 0;
    }

    .btn-back:hover {
      background: #0056b3;
      transform: translateX(-3px);
    }

    .nav-history {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
      justify-content: flex-end;
    }

    .nav-history a {
      text-decoration: none;
      padding: 8px 14px;
      border-radius: 6px;
      background: #e9f1ff;
      color: #007bff;
      font-weight: 600;
      transition: 0.3s;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .nav-history a:hover {
      background: #007bff;
      color: white;
    }

    .nav-history a.active {
      background: #007bff;
      color: white;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
    }

    .card h3 {
      margin-top: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th,
    td {
      padding: 12px 10px;
      text-align: left;
    }

    th {
      background: #007bff;
      color: white;
    }

    tr:nth-child(even) {
      background: #f9f9f9;
    }

    .status {
      font-weight: bold;
      padding: 6px 10px;
      border-radius: 6px;
      font-size: 13px;
      display: inline-block;
    }

    .status.diterima {
      background: #d4edda;
      color: #155724;
    }

    .status.ditolak {
      background: #f8d7da;
      color: #721c24;
    }

    .status.pending {
      background: #fff3cd;
      color: #856404;
    }

    .btn-delete {
      color: white;
      background: #dc3545;
      padding: 6px 10px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 13px;
      transition: 0.2s;
      cursor: pointer;
      border: none;
    }

    .btn-delete:hover {
      background: #b52a37;
    }

    @media (max-width: 768px) {
      .top-bar {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }

      .btn-back {
        width: auto;
        min-width: 80px;
        text-align: center;
      }

      .nav-history {
        justify-content: center;
        width: 100%;
      }

      .nav-history a {
        flex: 1;
        text-align: center;
        justify-content: center;
      }

      table,
      thead,
      tbody,
      th,
      td,
      tr {
        display: block;
      }

      thead {
        display: none;
      }

      tr {
        margin-bottom: 15px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 12px;
      }

      td {
        padding: 6px 8px;
        border: none;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 6px;
      }

      td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #333;
        min-width: 120px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="top-bar">
      <a href="Dashboard.php" class="btn-back">← Kembali</a>
      <div class="nav-history">
        <a href="history.php" class="<?= $current_page == 'history.php' ? 'active' : '' ?>">
          <i class="fa-solid fa-calendar-check"></i> Reservasi
        </a>
        <a href="notifikasi.php" class="<?= $current_page == 'notifikasi.php' ? 'active' : '' ?>">
          <i class="fa-solid fa-bell"></i> Notifikasi
        </a>
      </div>
    </div>

    <div class="card">
      <h3>Daftar History</h3>
      <table>
        <thead>
          <tr>
            <th>Nama Kegiatan</th>
            <th>Ruangan</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $reservasi->fetch_assoc()):
            $statusClass = strtolower($row['status']);
            ?>
            <tr>
              <td data-label="Nama Kegiatan"><?= htmlspecialchars($row['NamaKegiatan']); ?></td>
              <td data-label="Ruangan"><?= htmlspecialchars($row['Ruangan']); ?></td>
              <td data-label="Status">
                <span class="status <?= $statusClass; ?>"><?= htmlspecialchars($row['status']); ?></span>
              </td>
              <td data-label="Tanggal">
                <?= date("d-m-Y", strtotime($row['TanggalAwal'])) . " s/d " . date("d-m-Y", strtotime($row['TanggalAkhir'])); ?>
              </td>
              <td data-label="Aksi">
                <button class="btn-delete" onclick="confirmDelete(<?= $row['id']; ?>)">
                  <i class="fa-solid fa-trash"></i> Hapus
                </button>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    // Konfirmasi hapus
    function confirmDelete(id) {
      Swal.fire({
        title: 'Yakin hapus data ini?',
        text: "Data yang sudah dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "history.php?delete=" + id;
        }
      })
    }

    // Notifikasi setelah hapus
    <?php if ($msg == "deleted"): ?>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data berhasil dihapus.',
        timer: 2000,
        showConfirmButton: false
      })
    <?php elseif ($msg == "error"): ?>
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Data gagal dihapus.',
      })
    <?php endif; ?>
  </script>
</body>

</html>