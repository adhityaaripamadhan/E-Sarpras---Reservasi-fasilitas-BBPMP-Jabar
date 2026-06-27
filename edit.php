<?php
include 'koneksi.php';
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$alert = "";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  $alert = "<script>
      Swal.fire({icon:'error',title:'Akses Ditolak!',text:'Hanya admin yang boleh mengakses'});
      setTimeout(()=>window.location='index.php',2000);
    </script>";
}

if (!isset($_GET['id'])) {
  $alert = "<script>
      Swal.fire({icon:'warning',title:'ID tidak ditemukan',text:'Silakan pilih data yang valid'});
      setTimeout(()=>window.location='index.php',2000);
    </script>";
} else {
  $id = intval($_GET['id']);
  $query = mysqli_query($koneksi, "SELECT * FROM reservasi WHERE id = '$id'") or die(mysqli_error($koneksi));
  $data = mysqli_fetch_assoc($query);

  if (!$data) {
    $alert = "<script>
        Swal.fire({icon:'error',title:'Data tidak ditemukan'});
        setTimeout(()=>window.location='Dashboard2.php',2000);
      </script>";
  }
}

if (isset($_POST['submit'])) {
  $Nama = $_POST['Nama'];
  $NoHP = $_POST['NoHP'];
  $Email = $_POST['Email'];
  $NamaKegiatan = $_POST['NamaKegiatan'];
  $Pengusul = $_POST['Pengusul'];
  $Namainstansi = $_POST['Namainstansi'];
  $Alamat = $_POST['Alamat'];
  $TanggalAwal = $_POST['TanggalAwal'];
  $TanggalAkhir = $_POST['TanggalAkhir'];
  $WaktuAwal = $_POST['WaktuAwal'];
  $WaktuAkhir = $_POST['WaktuAkhir'];
  $JenisUsulan = $_POST['JenisUsulan'];

  $sql = "UPDATE reservasi SET 
        Nama='$Nama',
        NoHP='$NoHP',
        Email='$Email',
        NamaKegiatan='$NamaKegiatan',
        Pengusul='$Pengusul',
        Namainstansi='$Namainstansi',
        Alamat='$Alamat',
        TanggalAwal='$TanggalAwal',
        TanggalAkhir='$TanggalAkhir',
        WaktuAwal='$WaktuAwal',
        WaktuAkhir='$WaktuAkhir',
        JenisUsulan='$JenisUsulan'
        WHERE id='$id'";

  $update = mysqli_query($koneksi, $sql);

  if ($update) {
    $alert = "<script>
        Swal.fire({icon:'success',title:'Berhasil',text:'Data berhasil diperbarui'})
        .then(()=>window.location='Dashboard2.php');
      </script>";
  } else {
    $alert = "<script>
        Swal.fire({icon:'error',title:'Gagal',text:'Error: " . addslashes(mysqli_error($koneksi)) . "'});
      </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Data</title>
  <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f0f0f0;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 900px;
      margin: auto;
      background: #fff;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .column {
      flex: 1;
      min-width: 300px;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    input,
    select,
    textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    textarea {
      resize: vertical;
    }

    .header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 20px;
    }

    .header img {
      width: 50px;
      height: auto;
    }

    .header-text {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .header-text1 {
      font-size: 18px;
      margin-top: 25px;
      position: relative;
      left: -270px;
    }

    .header-text2 {
      font-size: 20px;
      color: rgb(4, 4, 255);
      position: relative;
      left: -275px;
      margin-top: 25px;
    }

    .btn_pesan {
      background: #007bff;
      color: white;
      border: none;
      padding: 10px 25px;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
      width: 200px;
    }

    .btn_batal {
      background: #d3d3d3;
      padding: 10px 25px;
      font-weight: bold;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 15px;
      cursor: pointer;
      width: 90px;
      text-align: center;
      text-decoration: none;
    }

    .btn_group {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 10px;
      margin-left: 324px;
      bottom: 141px;
      position: relative;
    }

    .inline-group {
      display: flex;
      gap: 10px;
    }

    .inline-group span {
      align-self: center;
      font-size: 20px;
      font-weight: bold;
      color: #888;
    }

    .file-upload {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 15px;
    }

    .upload-btn {
      background: #007bff;
      color: #fff;
      padding: 8px 16px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s;
      display: inline-block;
      font-size: 14px;
    }

    .upload-btn:hover {
      background: #0056b3;
    }

    #file-name {
      font-size: 14px;
      color: #555;
      font-style: italic;
    }

    .keterangan_reservasi {
      color: red;
      font-size: 11px;
      text-align: center;
      position: relative;
      left: 329px;
      bottom: 133px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <img src="../ASSET/homelogo.png" alt="Logo">
      <div class="header-text">Formulir Peminjaman Fasilitas</div>
      <div class="header-text1">BBPMP</div>
      <div class="header-text2">Jabar</div>
    </div>

    <?php if (!empty($data)) { ?>
      <form method="post" enctype="multipart/form-data">
        <div class="form-row">
          <div class="column">
            <input type="text" name="Nama" value="<?= $data['Nama'] ?>" placeholder="Nama" required>
            <input type="text" name="NoHP" value="<?= $data['NoHP'] ?>" placeholder="No HP" required>
            <input type="email" name="Email" value="<?= $data['Email'] ?>" placeholder="Email" required>
            <input type="text" name="NamaKegiatan" value="<?= $data['NamaKegiatan'] ?>" placeholder="Nama Kegiatan"
              required>

            <select name="Pengusul" required>
              <option value="" disabled>Pilih Pengusul</option>
              <option value="Pribadi" <?= $data['Pengusul'] == 'Pribadi' ? 'selected' : '' ?>>Pribadi</option>
              <option value="Instansi" <?= $data['Pengusul'] == 'Instansi' ? 'selected' : '' ?>>Instansi</option>
              <option value="Organisasi" <?= $data['Pengusul'] == 'Organisasi' ? 'selected' : '' ?>>Organisasi</option>
              <option value="Tim Kerja (Internal BBPMP)" <?= $data['Pengusul'] == 'Tim Kerja (Internal BBPMP)' ? 'selected' : '' ?>>Tim Kerja (Internal BBPMP)</option>
              <option value="Dukman / Bag. Umum (Internal BBPMP)" <?= $data['Pengusul'] == 'Dukman / Bag. Umum (Internal BBPMP)' ? 'selected' : '' ?>>Dukman / Bag. Umum (Internal BBPMP)</option>
            </select>

            <input type="text" name="Namainstansi" value="<?= $data['Namainstansi'] ?>" placeholder="Nama Instansi">

            <div class="file-upload">
              <input type="file" id="lampiran" name="lampiran" accept=".jpg,.jpeg,.png,.pdf" hidden>
              <label for="lampiran" class="upload-btn">📄 Pilih File</label>
              <span id="file-name">Belum ada file dipilih</span>
            </div>

            <p class="keterangan_reservasi">* Maksimal menunggu jawaban 3 hari kerja</p>
          </div>

          <div class="column">
            <div class="inline-group">
              <input type="date" name="TanggalAwal" value="<?= $data['TanggalAwal'] ?>" required>
              <span>-</span>
              <input type="date" name="TanggalAkhir" value="<?= $data['TanggalAkhir'] ?>" required>
            </div>

            <div class="inline-group">
              <input type="time" name="WaktuAwal" value="<?= $data['WaktuAwal'] ?>" required>
              <span>-</span>
              <input type="time" name="WaktuAkhir" value="<?= $data['WaktuAkhir'] ?>" required>
            </div>

            <select name="JenisUsulan" required>
              <option value="" disabled>Pilih Jenis Usulan</option>
              <option value="internal" <?= $data['JenisUsulan'] == 'internal' ? 'selected' : '' ?>>Internal</option>
              <option value="eksternal/umum" <?= $data['JenisUsulan'] == 'eksternal/umum' ? 'selected' : '' ?>>Eksternal / Umum
              </option>
            </select>

            <textarea name="Alamat" rows="3" placeholder="Alamat"><?= $data['Alamat'] ?></textarea>
          </div>
        </div>

        <div class="btn_group">
          <a href="Dashboard2.php" class="btn_batal">Batal</a>
          <button type="submit" name="submit" class="btn_pesan">Pesan</button>
        </div>
      </form>
    <?php } ?>
  </div>

  <script>
    document.getElementById("lampiran").addEventListener("change", function () {
      const fileName = this.files.length > 0 ? this.files[0].name : "Belum ada file dipilih";
      document.getElementById("file-name").textContent = fileName;
    });
  </script>

  <?= $alert ?>
</body>

</html>