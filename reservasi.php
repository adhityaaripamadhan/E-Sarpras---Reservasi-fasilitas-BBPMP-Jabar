<?php
session_start();
include "koneksi.php";
if (!isset($_SESSION['id'])) {
  ?>
  <!DOCTYPE html>
  <html lang="id">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirect Login</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
      @media (max-width: 768px) {
        .swal2-popup {
          width: 90% !important;
          font-size: 14px !important;
        }
      }
    </style>
  </head>

  <body>
    <script>
      Swal.fire({
        title: 'Silakan Login',
        text: 'Anda harus login terlebih dahulu untuk memesan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Login Sekarang',
        cancelButtonText: 'Kembali',
        confirmButtonColor: '#007bdb',
        cancelButtonColor: '#6c757d',
        width: '400px',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location = 'login.php';
        } else {
          window.location = 'index.php';
        }
      });
    </script>
  </body>

  </html>
  <?php
  exit;
}

$id_user = $_SESSION['id'];
$q_user = mysqli_query($koneksi, "SELECT * FROM akun WHERE id='$id_user'");
$user = mysqli_fetch_assoc($q_user);

$bulan = [
  1 => "Januari",
  2 => "Februari",
  3 => "Maret",
  4 => "April",
  5 => "Mei",
  6 => "Juni",
  7 => "Juli",
  8 => "Agustus",
  9 => "September",
  10 => "Oktober",
  11 => "November",
  12 => "Desember"
];
$tahunSekarang = date("Y");
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
  <title>Form Kegiatan</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background-color: #f5f7fa;
      margin: 0;
      padding: 20px;
      color: #333;
    }

    .container {
      max-width: 900px;
      margin: auto;
      background-color: #fff;
      border-radius: 16px;
      padding: 30px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .header {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 30px;
      text-align: center;
      flex-wrap: wrap;
    }

    .header-text {
      display: flex;
      flex-direction: row;
      gap: 8px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .header-title {
      font-size: 20px;
      font-weight: 700;
      color: #111827;
    }

    .form-row {
      display: flex;
      flex-wrap: wrap;
      gap: 24px;
    }

    .column {
      flex: 1;
      min-width: 300px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      font-size: 14px;
    }

    input,
    select,
    textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 18px;
      border: 1px solid #d1d5db;
      border-radius: 10px;
      font-size: 14px;
      background: #fff;
      transition: all 0.2s ease;
    }

    input:focus,
    select:focus,
    textarea:focus {
      border-color: #2c8dddff;
      box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
      outline: none;
    }

    select {
      appearance: none;
      background-image: url("data:image/svg+xml;utf8,<svg fill='%234f46e5' height='24' viewBox='0 0 24 24' width='24'><path d='M7 10l5 5 5-5z'/></svg>");
      background-repeat: no-repeat;
      background-position: right 12px center;
      background-size: 16px;
      padding-right: 40px;
      cursor: pointer;
    }

    select option {
      padding: 10px;
    }

    textarea {
      resize: vertical;
    }

    .file-upload {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 18px;
      flex-wrap: wrap;
    }

    .upload-btn {
      background: #2c8dddff;
      color: #fff;
      padding: 10px 18px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
      transition: background 0.3s;
      font-size: 14px;
      display: inline-block;
      text-align: center;
      width: 100%;
      max-width: 200px;
    }

    .upload-btn:hover {
      background: #0762adff;
    }

    #file-name {
      font-size: 13px;
      color: #555;
      font-style: italic;
      display: block;
      margin-top: 6px;
    }

    .btn {
      background-color: #2c8dddff;
      padding: 14px;
      font-weight: 600;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      width: 100%;
      margin-top: 10px;
      transition: background-color 0.3s, transform 0.1s;
    }

    .btn:hover {
      background-color: #0762adff;
    }

    .btn:active {
      transform: scale(0.98);
    }

    .btn_batal {
      display: block;
      background-color: #9ca3af;
      padding: 14px;
      font-weight: 600;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      width: 100%;
      margin-top: 10px;
      text-align: center;
      transition: background-color 0.3s, transform 0.1s;
    }

    .btn_batal:hover {
      background-color: #6b7280;
    }

    .btn_batal:active {
      transform: scale(0.98);
    }

    a {
      text-decoration: none;
      color: white;
    }

    .inline-group {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }

    .inline-group select {
      flex: 1;
      min-width: 80px;
      font-size: 15px;
      min-height: 45px;
    }

    label+.inline-group {
      margin-bottom: 18px;
    }

    .keterangan_reservasi {
      color: red;
      font-size: 12px;
      text-align: center;
      margin-top: 10px;
    }

    @media (max-width: 768px) {
      body {
        padding: 10px;
      }

      .container {
        padding: 20px;
        border-radius: 12px;
      }

      .form-row {
        flex-direction: column;
        gap: 16px;
      }

      .column {
        min-width: 100% !important;
      }

      .header {
        flex-direction: column;
        gap: 10px;
      }

      .header-text {
        flex-direction: column;
        gap: 4px;
      }

      .header-title {
        font-size: 18px;
      }

      input,
      select,
      textarea {
        font-size: 13px;
        padding: 10px;
      }

      .btn,
      .btn_batal {
        width: 100%;
        font-size: 14px;
        padding: 12px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <div class="header-text">
        <div class="header-title">Formulir Peminjaman Fasilitas</div>
      </div>
    </div>

    <?php $ruangan = $_GET['ruangan'] ?? ''; ?>
    <form action="proses_reservasi" method="post" enctype="multipart/form-data">
      <input type="hidden" name="Ruangan" value="<?php echo htmlspecialchars($ruangan); ?>">
      <div class="form-row">
        <div class="column">
          <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
          <input type="hidden" name="nama" value="<?php echo htmlspecialchars($user['username']); ?>">
          <input type="text" value="<?php echo htmlspecialchars($user['nohp']); ?>" disabled>
          <input type="hidden" name="NoHP" value="<?php echo htmlspecialchars($user['nohp']); ?>">
          <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
          <input type="hidden" name="Email" value="<?php echo htmlspecialchars($user['email']); ?>">
          <input type="text" value="<?php echo htmlspecialchars($ruangan); ?>" disabled>
          <input type="hidden" name="Ruangan" value="<?php echo htmlspecialchars($ruangan); ?>">

          <label for="NamaKegiatan">Nama Kegiatan</label>
          <input type="text" id="NamaKegiatan" name="NamaKegiatan" required>

          <label for="Pengusul">Pengusul</label>
          <select id="Pengusul" name="Pengusul" required>
            <option value="">Pilih Pengusul</option>
            <option value="Pribadi">Pribadi</option>
            <option value="Instansi">Instansi</option>
            <option value="Organisasi">Organisasi</option>
            <option value="Tim Kerja (Internal BBPMP)">Tim Kerja (Internal BBPMP)</option>
            <option value="Dukman / Bag. Umum (Internal BBPMP)">Dukman / Bag. Umum (Internal BBPMP)</option>
          </select>

          <label for="Namainstansi">Nama Instansi / Timker / Lainnya</label>
          <input type="text" id="Namainstansi" name="Namainstansi">

          <label for="lampiran">Lampirkan Surat Resmi (jika Instansi)</label>
          <div class="file-upload">
            <input type="file" id="lampiran" name="lampiran" accept=".jpg,.jpeg,.png,.pdf" hidden>
            <label for="lampiran" class="upload-btn">📄 Pilih File</label>
            <span id="file-name">Belum ada file dipilih</span>
          </div>

          <?php if (strtolower($ruangan) === 'aula tangkuban parahu'): ?>
            <label for="layout_ruangan">Layout Ruangan</label>
            <select name="layout_ruangan" id="layout_ruangan" required>
              <option value="">Pilih Layout</option>
              <option value="Auditorium Style">Auditorium Style</option>
              <option value="Classroom Style">Classroom Style</option>
              <option value="U Shape Style">U Shape Style</option>
            </select>
          <?php endif; ?>
        </div>

        <div class="column">
          <label for="TanggalAwal">Tanggal Kegiatan - Mulai</label>
<input type="date" id="TanggalAwal" name="TanggalAwal" required>

<label for="TanggalAkhir">Tanggal Kegiatan - Selesai</label>
<input type="date" id="TanggalAkhir" name="TanggalAkhir" required>


          <label>Waktu Kegiatan - Mulai</label>
          <div class="inline-group">
            <select name="WaktuAwal_Jam" required>
              <option value="">Jam</option>
              <?php for ($i = 0; $i < 24; $i++): ?>
                <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
              <?php endfor; ?>
            </select>
            <select name="WaktuAwal_Menit" required>
              <option value="">Menit</option>
              <?php for ($i = 0; $i < 60; $i += 5): ?>
                <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
              <?php endfor; ?>
            </select>
          </div>

          <label>Waktu Kegiatan - Selesai</label>
          <div class="inline-group">
            <select name="WaktuAkhir_Jam" required>
              <option value="">Jam</option>
              <?php for ($i = 0; $i < 24; $i++): ?>
                <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
              <?php endfor; ?>
            </select>
            <select name="WaktuAkhir_Menit" required>
              <option value="">Menit</option>
              <?php for ($i = 0; $i < 60; $i += 5): ?>
                <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
              <?php endfor; ?>
            </select>
          </div>

          <?php
          // Ambil kategori user dari database
          $kategori_user = strtolower($user['kategori']); // pastikan kolom 'kategori' ada di tabel akun
          ?>
          <label for="JenisUsulan">Jenis Usulan</label>
          <?php if ($kategori_user === 'internal'): ?>
            <select id="JenisUsulan" name="JenisUsulan_display" disabled>
              <option value="internal" selected>Internal</option>
              <option value="eksternal/umum">Eksternal / Umum</option>
            </select>
            <input type="hidden" name="JenisUsulan" value="internal">
          <?php elseif ($kategori_user === 'eksternal'): ?>
            <select id="JenisUsulan" name="JenisUsulan_display" disabled>
              <option value="internal">Internal</option>
              <option value="eksternal/umum" selected>Eksternal / Umum</option>
            </select>
            <input type="hidden" name="JenisUsulan" value="eksternal/umum">
          <?php else: ?>
            <select id="JenisUsulan" name="JenisUsulan" required>
              <option value="">Pilih Jenis Usulan</option>
              <option value="internal">Internal</option>
              <option value="eksternal/umum">Eksternal / Umum</option>
            </select>
          <?php endif; ?>


          <label for="Alamat">Alamat</label>
          <textarea id="Alamat" name="Alamat" rows="3"></textarea>
        </div>
      </div>

      <button type="submit" class="btn">Pesan</button>
      <a href="Informasi.php" onclick="konfirmasiBatal(event)" class="btn_batal">Batal</a>
    </form>
    <p class="keterangan_reservasi">* Maksimal menunggu jawaban 3 hari kerja</p>
  </div>

  <script>
    function konfirmasiBatal(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Batalkan Form?',
        text: "Perubahan yang sudah Anda isi akan hilang.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Batalkan',
        cancelButtonText: 'Kembali'
      }).then((result) => {
        if (result.isConfirmed) {
          history.back();
        }
      });
    }

    document.getElementById("lampiran").addEventListener("change", function () {
      const fileName = this.files.length > 0 ? this.files[0].name : "Belum ada file dipilih";
      document.getElementById("file-name").textContent = fileName;
    });

    // Format tanggal ke Indonesia (contoh: 13 November 2025)
  function formatTanggalIndo(dateStr) {
    const bulanIndo = [
      "Januari", "Februari", "Maret", "April", "Mei", "Juni",
      "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    const date = new Date(dateStr);
    const hari = date.getDate();
    const bulan = bulanIndo[date.getMonth()];
    const tahun = date.getFullYear();
    return `${hari} ${bulan} ${tahun}`;
  }

  // Saat user memilih tanggal, tampilkan versi Indonesia di bawahnya
  document.getElementById('TanggalAwal').addEventListener('change', function() {
    document.getElementById('TanggalAwal_Display').textContent =
      "🗓️ " + formatTanggalIndo(this.value);
  });

  document.getElementById('TanggalAkhir').addEventListener('change', function() {
    document.getElementById('TanggalAkhir_Display').textContent =
      "🗓️ " + formatTanggalIndo(this.value);
  });
  </script>
</body>

</html>