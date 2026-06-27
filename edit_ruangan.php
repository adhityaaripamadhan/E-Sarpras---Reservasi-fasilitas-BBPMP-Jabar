<?php
include 'koneksi.php';
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM ruangan WHERE id_ruangan = '$id'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Ruangan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: "Segoe UI", Arial, sans-serif;
    }

    .wrapp_form {
      width: 380px;
      padding: 25px 20px;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
      position: relative;
      animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .wrapp_form h2 {
      margin: 0 0 20px;
      text-align: center;
      font-size: 22px;
      font-weight: 600;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-size: 14px;
      font-weight: 600;
      color: #444;
    }

    input,
    textarea {
      width: 100%;
      padding: 10px 12px;
      margin-bottom: 15px;
      border: 1px solid #d0d0d0;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    input:focus,
    textarea:focus {
      border-color: #007bff;
      box-shadow: 0 0 4px rgba(0, 123, 255, 0.4);
      outline: none;
    }

    textarea {
      resize: vertical;
      min-height: 90px;
    }

    input[type="file"] {
      padding: 6px;
      border: 1px solid #d0d0d0;
      border-radius: 8px;
      font-size: 14px;
      background: #f8f9fa;
      cursor: pointer;
    }

    input[type="file"]::-webkit-file-upload-button {
      background: #007bff;
      color: #fff;
      border: none;
      padding: 8px 14px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 13px;
      font-weight: 600;
      margin-right: 8px;
      transition: background 0.3s ease;
    }

    input[type="file"]::-webkit-file-upload-button:hover {
      background: #0056b3;
    }

    .btn_submit {
      width: 100%;
      padding: 12px;
      background: #007bff;
      border: none;
      border-radius: 8px;
      color: #fff;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.1s ease;
    }

    .btn_submit:hover {
      background: #0056b3;
    }

    .btn_submit:active {
      transform: scale(0.97);
    }

    .btn_close {
      position: absolute;
      top: 14px;
      right: 16px;
      text-decoration: none;
      font-size: 22px;
      font-weight: bold;
      color: #888;
      transition: color 0.3s ease;
      cursor: pointer;
    }

    .btn_close:hover {
      color: #e74c3c;
    }
  </style>
</head>

<body>
  <div class="wrapp_form">
    <a href="#" class="btn_close" id="btnClose">&times;</a>
    <h2>Edit Ruangan</h2>
    <form action="proses_edit" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id_ruangan" value="<?= $data['id_ruangan']; ?>">

      <label>Nama Ruangan</label>
      <input type="text" name="nama_ruangan" value="<?= htmlspecialchars($data['nama_ruangan']); ?>" required>

      <label>Deskripsi</label>
      <textarea name="deskripsi" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>

      <label>Ganti Gambar (Opsional)</label>
      <input type="file" name="foto" accept="image/*">

      <button type="submit" class="btn_submit">Simpan Perubahan</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Tombol Close (X)
    document.getElementById("btnClose").addEventListener("click", function (e) {
      e.preventDefault();
      Swal.fire({
        title: 'Batalkan perubahan?',
        text: 'Perubahan yang belum disimpan akan hilang.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Batalkan',
        cancelButtonText: 'Tidak',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "infomin.php";
        }
      });
    });
  </script>
</body>

</html>
