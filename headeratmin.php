<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id'])) {
  echo "<script>alert('Silakan login terlebih dahulu');window.location='formlogin.html'</script>";
  exit;
}

$id = $_SESSION['id'];
$query = $koneksi->query("SELECT username FROM akun WHERE id = '$id'");
$data_user = $query->fetch_assoc();
$nama_pengguna = $data_user['username'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background-color: #f7f7f7;
      padding-top: 100px;
    }

    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      background-color: #ffffff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .logo {
      width: 120px;
    }

    .group3 {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 20px;
    }

    .group3 a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
      transition: all 0.3s ease;
      padding-bottom: 4px;
      border-bottom: 2px solid transparent;
      margin: 0 15px;
    }

    .group3 a:hover {
      color: #007bff;
      border-bottom: 2px solid #007bff;
    }


    .group2 {
      display: flex;
      align-items: center;
    }

    .txtbtn1,
    .txtbtn2 {
      font-weight: 600;
      padding: 8px 16px;
      border-radius: 5px;
      text-decoration: none;
    }

    .txtbtn1 {
      color: #007bff;
    }

    .txtbtn1:hover {
      text-decoration: underline;
    }

    .txtbtn2 {
      background-color: #007bff;
      color: #ffffff;
    }

    .txtbtn2:hover {
      background-color: #0056b3;
    }

    .txt5 {
      margin: 0 10px;
      font-size: 18px;
      color: #999;
    }

    .profile-container {
      position: relative;
      display: inline-block;
    }

    .profile-btn {
      background-color: #007bff;
      color: white;
      font-size: 20px;
      border: none;
      cursor: pointer;
      border-radius: 50%;
      height: 50px;
      width: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
    }


    .profile-card {
      display: none;
      position: absolute;
      right: 0;
      top: 60px;
      width: 240px;
      background-color: #fff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      padding: 20px;
      z-index: 1000;
      border-radius: 16px;
      text-align: center;
    }

    .profile-avatar {
      background-color: #007bff;
      color: white;
      font-size: 20px;
      border: none;
      border-radius: 50%;
      height: 80px;
      width: 80px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      margin-bottom: 20px;
    }


    .profile-name {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 20px;
      color: black;
    }

    .profile-button {
      display: block;
      width: 100%;
      padding: 10px;
      margin: 6px 0;
      border: none;
      border-radius: 8px;
      font-weight: 500;
      cursor: pointer;
      text-align: center;
      transition: background-color 0.2s;
    }

    .profile-button.edit {
      background-color: #f1f3f4;
      color: #202124;
      font-size: 13px;
      text-decoration: none;
    }

    .profile-button.logout {
      background-color: #ffffff;
      border: 1px solid #007bff;
      color: #007bff;
    }

    .profile-button.logout:hover {
      background-color: #e6f0ff;
    }
  </style>
</head>

<body>
  <header class="header">
    <a href="https://www.bbpmpjabar.id/">
      <img src="../ASSET/logo bbpmp baru.png" alt="Logo BBPMP" class="logo">
    </a>
    <nav class="group3">
      <a href="Dashboard2.php">Home</a>
      <a href="infomin.php">Informasi</a>
      <a href="pesanmin.php">Reservasi</a>
      <a href="kontakmin.php">Kontak</a>

      <a href="atminberanda.php">Daftar Peminjam</a>
    </nav>
    <div class="group2">
      <div class="profile-container">
        <button onclick="toggleProfile()" class="profile-btn">
          <?php echo strtoupper(substr($nama_pengguna, 0, 1)); ?>
        </button>
        <div class="profile-card" id="profileCard">
          <button class="profile-avatar" onclick="toggleProfile()" class="profile-btn">
            <?php echo strtoupper(substr($nama_pengguna, 0, 1)); ?>
          </button>
          <div class="profile-name"><?php echo htmlspecialchars($nama_pengguna); ?></div>

          <form action="logout.php" method="post">
            <button class="profile-button logout" type="submit" onclick="konfirmasiLogout(event)">Logout</button>
          </form>
        </div>

      </div>
  </header>

  <script>
    function toggleProfile() {
      const card = document.getElementById("profileCard");
      card.style.display = (card.style.display === "block") ? "none" : "block";
    }

    window.onclick = function (event) {
      if (!event.target.matches('.profile-btn')) {
        const card = document.getElementById("profileCard");
        if (card && card.style.display === "block") {
          card.style.display = "none";
        }
      }
    }

    function konfirmasiLogout(event) {
      if (!confirm("Apakah kamu yakin ingin logout?")) {
        event.preventDefault();
      }
    }

  </script>
</body>

</html>