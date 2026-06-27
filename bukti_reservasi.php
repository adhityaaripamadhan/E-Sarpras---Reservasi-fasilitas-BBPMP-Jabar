<?php
session_start();
include 'koneksi.php';


if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
} elseif (isset($_SESSION['reservasi_id'])) {
  $id = $_SESSION['reservasi_id'];
} else {
  header("Location: reservasi.php");
  exit;
}

// Query
$query = mysqli_query($koneksi, "SELECT * FROM reservasi WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
  die("Data reservasi tidak ditemukan!");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bukti Reservasi</title>
  <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: #f7f7f7;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .container {
      width: 100%;
      max-width: 600px;
      position: relative;
    }

    .card {
      background: #ffffff;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .close-btn {
      position: absolute;
      top: 12px;
      right: 15px;
      font-size: 22px;
      color: #000;
      cursor: pointer;
      border: none;
      background: none;
      font-weight: bold;
    }

    .logo {
      text-align: center;
      margin-bottom: 15px;
    }

    .logo img {
      width: 120px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 22px;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    td {
      padding: 10px;
      border-bottom: 1px solid #eee;
      font-size: 16px;
    }

    td.label {
      font-weight: bold;
      width: 35%;
      background: #fafafa;
    }

    td.value {
      width: 65%;
    }

    .btns {
      text-align: center;
      margin-top: 25px;
    }

    .btns button {
      padding: 12px 16px;
      margin: 5px;
      border: none;
      border-radius: 50%;
      cursor: pointer;
      font-size: 18px;
      transition: 0.3s;
      color: #fff;
      align-items: center;
    }

    .imgBtn {
      background: #28a745;
    }

    .imgBtn:hover {
      background: #218838;
    }

    .pdfBtn {
      background: #007bff;
    }

    .pdfBtn:hover {
      background: #0056b3;
    }

    .no-print {
      display: inline-block;
    }
  </style>
</head>

<body>
  <div class="container">
    <div id="capture" class="card">
      <button class="close-btn no-print" onclick="window.location.href='Dashboard2.php'">×</button>

      <div class="logo"><img src="../ASSET/logo bbpmp baru.png" crossorigin="anonymous"></div>
      <h2>Bukti Reservasi Ruangan</h2>
      <table>
        <tr>
          <td class="label">Nama</td>
          <td class="value"><?= htmlspecialchars($data['Nama']) ?></td>
        </tr>
        <tr>
          <td class="label">Telepon</td>
          <td class="value"><?= htmlspecialchars($data['NoHP']) ?></td>
        </tr>
        <tr>
          <td class="label">Email</td>
          <td class="value"><?= htmlspecialchars($data['Email']) ?></td>
        </tr>
        <tr>
          <td class="label">Nama Kegiatan</td>
          <td class="value"><?= htmlspecialchars($data['NamaKegiatan']) ?></td>
        </tr>
        <tr>
          <td class="label">Pengusul</td>
          <td class="value"><?= htmlspecialchars($data['Pengusul']) ?></td>
        </tr>
        <tr>
          <td class="label">Instansi</td>
          <td class="value"><?= htmlspecialchars($data['Namainstansi']) ?></td>
        </tr>
        <tr>
          <td class="label">Tanggal Mulai</td>
          <td class="value"><?= htmlspecialchars($data['TanggalAwal']) ?></td>
        </tr>
        <tr>
          <td class="label">Tanggal Selesai</td>
          <td class="value"><?= htmlspecialchars($data['TanggalAkhir']) ?></td>
        </tr>
        <tr>
          <td class="label">Waktu Mulai</td>
          <td class="value"><?= htmlspecialchars($data['WaktuAwal']) ?></td>
        </tr>
        <tr>
          <td class="label">Waktu Selesai</td>
          <td class="value"><?= htmlspecialchars($data['WaktuAkhir']) ?></td>
        </tr>
        <tr>
          <td class="label">Jenis Usulan</td>
          <td class="value"><?= htmlspecialchars($data['JenisUsulan']) ?></td>
        </tr>
        <tr>
          <td class="label">Ruangan</td>
          <td class="value"><?= htmlspecialchars($data['Ruangan']) ?></td>
        </tr>
        <tr>
          <td class="label">Alamat</td>
          <td class="value"><?= htmlspecialchars($data['Alamat']) ?></td>
        </tr>
      </table>

      <!-- Tombol Export -->
      <center>
        <div class="btns no-print">
          <button class="imgBtn" onclick="downloadIMG()" title="Download IMG"><i class="fas fa-file-image"></i></button>
          <button class="pdfBtn" onclick="downloadPDF()" title="Download PDF"><i class="fas fa-file-pdf"></i></button>
      </center>
    </div>
  </div>
  </div>

  <script>
    // FUNGSI EXPORT
    function downloadIMG() {
      html2canvas(document.querySelector("#capture"), {
        scale: 2,
        backgroundColor: "#ffffff",
        useCORS: true,
        allowTaint: true,
        ignoreElements: (el) => el.classList.contains("no-print")
      }).then(canvas => {
        let link = document.createElement("a");
        link.download = "bukti_reservasi.png";
        link.href = canvas.toDataURL("image/png", 1.0);
        link.click();
      });
    }

    function downloadPDF() {
      html2canvas(document.querySelector("#capture"), {
        scale: 2,
        backgroundColor: "#ffffff",
        useCORS: true,
        allowTaint: true,
        ignoreElements: (el) => el.classList.contains("no-print")
      }).then(canvas => {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF("p", "mm", "a4");
        const imgData = canvas.toDataURL("image/png", 1.0);
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
        pdf.save("bukti_reservasi.pdf");
      });
    }
  </script>
</body>

</html>