<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['id'])) {
  header("Location: formlogin.php");
  exit;
}
$id = $_SESSION['id'];

// Jika ada request hapus
if (isset($_GET['hapus'])) {
  $id_hapus = intval($_GET['hapus']);
  $koneksi->query("DELETE FROM notifikasi WHERE id='$id_hapus' AND user_id='$id'");
  $_SESSION['notif_success'] = "Notifikasi berhasil dihapus";
  header("Location: notifikasi.php");
  exit;
}

$notifikasi = $koneksi->query("
    SELECT id, pesan, tanggal, status
    FROM notifikasi
    WHERE user_id='$id'
    ORDER BY tanggal DESC
");
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Notifikasi</title>
  <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- SweetAlert -->
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
      gap: 12px;
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
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
    }

    .card h3 {
      margin-top: 0;
      display: flex;
      align-items: center;
      gap: 8px;
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
      vertical-align: top;
    }

    th {
      background: #007bff;
      color: white;
    }

    tr:nth-child(even) {
      background: #f9f9f9;
    }

    .badge {
      font-weight: bold;
      padding: 6px 10px;
      border-radius: 6px;
      font-size: 13px;
      display: inline-block;
    }

    .badge-belum {
      background: #f8d7da;
      color: #721c24;
    }

    .badge-dibaca {
      background: #d4edda;
      color: #155724;
    }

    .btn-delete {
      background: #dc3545;
      color: white;
      border: none;
      padding: 6px 10px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-delete:hover {
      background: #a71d2a;
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
        padding: 8px 10px;
        border: none;
      }

      td[data-label="Pesan"]::before {
        content: "Pesan:";
        font-weight: bold;
        display: block;
        margin-bottom: 4px;
      }

      td[data-label="Tanggal"]::before {
        content: "Tanggal:";
        font-weight: bold;
        margin-right: 6px;
      }

      td[data-label="Status"]::before {
        content: "Status:";
        font-weight: bold;
        margin-right: 6px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="top-bar">
      <a href="Dashboard.php" class="btn-back">← Kembali</a>
      <div class="nav-history">
        <a href="history.php"><i class="fa-solid fa-calendar-check"></i> Reservasi</a>
        <a href="notifikasi.php" class="active"><i class="fa-solid fa-bell"></i> Notifikasi</a>
      </div>
    </div>

    <div class="card">
      <h3> Daftar Notifikasi</h3>
      <table>
        <thead>
          <tr>
            <th>Pesan</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $notifikasi->fetch_assoc()): ?>
            <tr>
              <td data-label="Pesan"><?= ($row['pesan']); ?></td>
              <td data-label="Tanggal"><?= date("d-m-Y H:i", strtotime($row['tanggal'])); ?></td>
              <td data-label="Status">
                <span class="badge <?= $row['status'] == 'belum_dibaca' ? 'badge-belum' : 'badge-dibaca'; ?>">
                  <?= ucfirst(str_replace('_', ' ', $row['status'])); ?>
                </span>
              </td>
              <td>
                <button class="btn-delete" onclick="hapusNotifikasi(<?= $row['id']; ?>)">
                  <i class="fa fa-trash"></i> Hapus
                </button>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function hapusNotifikasi(id) {
      Swal.fire({
        title: 'Yakin hapus?',
        text: "Data ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "notifikasi.php?hapus=" + id;
        }
      });
    }

    <?php if (isset($_SESSION['notif_success'])): ?>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '<?= $_SESSION['notif_success']; ?>',
        timer: 2000,
        showConfirmButton: false
      });
      <?php unset($_SESSION['notif_success']); ?>
    <?php endif; ?>
  </script>
</body>

</html>