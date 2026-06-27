<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
$is_logged_in = isset($_SESSION['id']);

$notifikasi = [];
$history = [];
$new_notif = null;
$count_unread = ['jml' => 0];

$nama_pengguna = '';
$email_pengguna = '';
$nohp_pengguna = '';

if ($is_logged_in) {
  $id = $_SESSION['id'];
  $query = $koneksi->query("SELECT username, email, nohp FROM akun WHERE id = '$id'");
  $data_user = $query->fetch_assoc();

  $nama_pengguna = $data_user['username'] ?? '';
  $email_pengguna = $data_user['email'] ?? '';
  $nohp_pengguna = $data_user['nohp'] ?? '';

  $notif_query = $koneksi->query("
      SELECT id, pesan, tanggal, status 
      FROM notifikasi 
      WHERE user_id='$id' 
      ORDER BY tanggal DESC LIMIT 1
  ");
  while ($row = $notif_query->fetch_assoc()) {
    $notifikasi[] = $row;
  }

  $count_unread = $koneksi->query("
      SELECT COUNT(*) as jml FROM notifikasi WHERE user_id='$id' AND status='belum_dibaca'
  ")->fetch_assoc();

  $history_query = $koneksi->query("
      SELECT NamaKegiatan, Ruangan, status, TanggalAwal, TanggalAkhir
      FROM reservasi
      WHERE Email = '" . $koneksi->real_escape_string($email_pengguna) . "'
      ORDER BY id DESC LIMIT 5
  ");
  while ($row = $history_query->fetch_assoc()) {
    $history[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navigasi</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif
    }

    body {
      background: #f7f7f7;
      padding-top: 80px
    }

    header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 20px;
      background: #fff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      z-index: 1000
    }

    .logo img {
      height: 40px
    }

    nav {
      display: flex;
      gap: 30px;
      align-items: center
    }

    nav a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
      padding-bottom: 4px;
      border-bottom: 2px solid transparent;
      transition: 0.3s
    }

    nav a:hover,
    nav a.active {
      color: #007bff;
      border-bottom: 2px solid #007bff
    }

    .header-right-icons {
      display: flex;
      align-items: center;
      gap: 10px
    }

    .auth-links {
      display: flex;
      align-items: center;
      gap: 8px
    }

    .auth-links a {
      text-decoration: none;
      transition: 0.3s;
      font-weight: 500;
      padding: 6px 14px;
      border-radius: 6px;
      font-size: 14px
    }

    .txtbtn1 {
      color: #007bff;
      border: 1px solid #007bff;
      background: #fff
    }

    .txtbtn1:hover {
      background: #007bff;
      color: #fff
    }

    .txtbtn2 {
      background: #007bff;
      color: #fff
    }

    .txtbtn2:hover {
      background: #0056b3
    }

    .burger {
      display: none;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      width: 44px;
      height: 44px;
      cursor: pointer;
      position: relative;
      transition: background-color 0.3s ease
    }

    .burger span {
      display: block;
      width: 28px;
      height: 3px;
      background: #333;
      border-radius: 2px;
      transition: all 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
      position: absolute;
      left: 50%;
      transform: translateX(-50%)
    }

    .burger span:nth-child(1) {
      top: 12px
    }

    .burger span:nth-child(2) {
      top: 50%;
      transform: translateX(-50%) translateY(-50%)
    }

    .burger span:nth-child(3) {
      bottom: 12px
    }

    .burger.open span:nth-child(1) {
      top: 50%;
      transform: translateX(-50%) translateY(-50%) rotate(45deg)
    }

    .burger.open span:nth-child(2) {
      opacity: 0
    }

    .burger.open span:nth-child(3) {
      top: 50%;
      transform: translateX(-50%) translateY(-50%) rotate(-45deg)
    }

    @media(max-width:768px) {
      nav {
        display: none;
        flex-direction: column;
        gap: 10px;
        padding: 15px;
        align-items: flex-start;
        position: absolute;
        top: 70px;
        right: 20px;
        width: 150px;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        animation: slideDown 0.3s ease;
        z-index: 999
      }

      nav.show {
        display: flex
      }

      nav a {
        width: 100%;
        padding: 8px 5px;
        border-radius: 4px;
        margin-bottom: 5px;
        text-align: left
      }

      nav a:last-child {
        margin-bottom: 0
      }

      .burger {
        display: flex
      }

      .dropdown-card {
        display: none;
        position: absolute;
        left: -150px;
        top: 45px;
        width: 300px;
        background: #fff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 1000
      }

      .profile-card {
        display: none;
        position: absolute;
        left: -190px;
        margin-top: 8px;
        width: 260px;
        background: #fff;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        border-radius: 12px;
        text-align: center;
        z-index: 1000
      }
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px)
      }

      to {
        opacity: 1;
        transform: translateY(0)
      }
    }

    .profile-container {
      position: relative;
      display: inline-block
    }

    .profile-btn {
      background: #007bff;
      color: white;
      font-size: 18px;
      border: none;
      cursor: pointer;
      border-radius: 50%;
      height: 42px;
      width: 42px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15)
    }

    .profile-card {
      display: none;
      position: absolute;
      right: 0;
      top:55px;
      width: 280px;
      background: #fff;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      border-radius: 12px;
      text-align: center;
      z-index: 1000
    }

    .profile-avatar {
      background: #007bff;
      color: #fff;
      font-size: 28px;
      font-weight: bold;
      border-radius: 50%;
      height: 70px;
      width: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 10px auto
    }

    .profile-name {
      font-weight: 600;
      font-size: 16px;
      margin-bottom: 15px
    }

    .profile-detail {
      border-bottom: 1px solid #ccc;
      padding: 10px 0;
      text-align: left;
      cursor: pointer;
      position: relative
    }

    .profile-detail summary {
      list-style: none;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 500
    }

    .profile-detail summary::-webkit-details-marker {
      display: none
    }

    .profile-detail i {
      transition: transform 0.3s
    }

    .profile-detail[open] i {
      transform: rotate(180deg)
    }

    .profile-detail p {
      font-size: 13px;
      color: #444;
      margin: 8px 0 0 0;
      animation: fadeIn 0.3s ease
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-5px)
      }

      to {
        opacity: 1;
        transform: translateY(0)
      }
    }

    .profile-button.logout {
      background: none;
      border: none;
      color: red;
      font-weight: 600;
      font-size: 15px;
      margin-top: 15px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
      justify-content: center
    }

    .profile-button.logout:hover {
      color: darkred
    }

    .notif-container,
    .history-container {
      position: relative;
      display: inline-block
    }

    .icon-btn {
      position: relative;
      background: none;
      border: none;
      cursor: pointer;
      color: #333;
      transition: transform 0.2s ease, color 0.2s ease
    }

    .icon-btn:hover {
      color: #007bff;
      transform: scale(1.15)
    }

    .badge {
      position: absolute;
      top: -5px;
      right: -8px;
      background: red;
      color: white;
      font-size: 12px;
      font-weight: bold;
      border-radius: 50%;
      padding: 2px 6px
    }

    .dropdown-card {
      display: none;
      position: absolute;
      top: 45px;
      width: 300px;
      background: #fff;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      z-index: 1000;
    }

    .notif-container .dropdown-card,
    .history-container .dropdown-card {
      right: 0;
      left: auto;
      transform: none;
    }

    @media (max-width: 768px) {

      .notif-container .dropdown-card,
      .history-container .dropdown-card {
        position: absolute;
        top: 55px;
        right: 10px;
        left: -190px;
        transform: none;
        width: 90%;
        max-width: 350px;
        min-width: 280px;
      }
    }

    .dropdown-card h4 {
      margin-bottom: 10px;
      font-size: 16px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px
    }

    .dropdown-card ul {
      list-style: none;
      padding: 0;
      margin: 0
    }

    .dropdown-card li {
      margin-bottom: 10px;
      font-size: 14px;
      color: #333
    }

    .lihat-semua {
      display: block;
      text-align: center;
      margin-top: 8px;
      font-size: 14px;
      color: #007bff;
      text-decoration: none
    }

    .lihat-semua:hover {
      text-decoration: underline
    }

    .icon {
      width: 24px;
      height: 24px;
      stroke-width: 2
    }

    .bell {
      transform-origin: top center
    }

    
    @keyframes ring { 
      0% {
        transform: rotate(0)
      }

      10% {
        transform: rotate(15deg)
      }

      20% {
        transform: rotate(-15deg)
      }

      30% {
        transform: rotate(10deg)
      }

      40% {
        transform: rotate(-10deg)
      }

      50% {
        transform: rotate(5deg)
      }

      60% {
        transform: rotate(-5deg)
      }

      70% {
        transform: rotate(0)
      }

      100% {
        transform: rotate(0)
      }
    }

    .close-btn {
      position: absolute;
      top: 8px;
      right: 10px;
      background: none;
      border: none;
      font-size: 18px;
      font-weight: bold;
      color: #666;
      cursor: pointer;
      transition: 0.2s
    }

    .close-btn:hover {
      color: red
    }
  </style>
</head>

<body>
  <header>
    <div class="logo">
      <a href="https://www.bbpmpjabar.id/"><img src="../ASSET/logo bbpmp baru.png" alt="logo BBPMP"></a>
    </div>
    <nav id="menu">
      <a href="Dashboard.php" class="<?= $current_page == 'Dashboard.php' ? 'active' : '' ?>"><i
          class="fas fa-home"></i> Beranda</a>
      <a href="Informasi.php" class="<?= $current_page == 'Informasi.php' ? 'active' : '' ?>"><i
          class="fas fa-calendar-check"></i> Reservasi</a>
      <a href="Kontak.php" class="<?= $current_page == 'Kontak.php' ? 'active' : '' ?>"><i class="fas fa-phone"></i>
        Kontak</a>
    </nav>

    <div class="header-right-icons">
      <?php if ($is_logged_in): ?>
        <div class="notif-container">
          <button onclick="toggleNotif()" class="icon-btn">
            <svg class="icon bell" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <?php if ($count_unread['jml'] > 0): ?><span class="badge"
                id="notifBadge"><?= $count_unread['jml']; ?></span><?php endif; ?>
          </button>
          <div class="dropdown-card" id="notifCard">
            <button class="close-btn" onclick="closeNotif()">×</button>
            <h4>Notifikasi</h4>
            <?php if (count($notifikasi) > 0): ?>
              <ul><?php foreach ($notifikasi as $n): ?>
                  <li>
                    <?= ($n['pesan']); ?><br><small><?= date("d-m-Y H:i", strtotime($n['tanggal'])); ?></small>
                  </li><?php endforeach; ?>
              </ul>
            <?php else: ?>
              <p>Tidak ada notifikasi</p><?php endif; ?>
          </div>
        </div>

        <div class="history-container">
          <button onclick="toggleHistory()" class="icon-btn">
            <svg class="icon history" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </button>
          <div class="dropdown-card" id="historyCard">
            <button class="close-btn" onclick="closeHistory()">×</button>
            <h4>History</h4>
            <?php if (count($history) > 0): ?>
              <ul><?php foreach ($history as $h): ?>
                  <li><?= htmlspecialchars($h['NamaKegiatan']); ?> - <?= htmlspecialchars($h['Ruangan']); ?><br><small>Status:
                      <?= htmlspecialchars($h['status']); ?><br><?= $h['TanggalAwal']; ?> s/d
                      <?= $h['TanggalAkhir']; ?></small></li><?php endforeach; ?>
              </ul>
              <a href="history.php" class="lihat-semua">Lihat Semua</a>
            <?php else: ?>
              <p>Belum ada reservasi</p><?php endif; ?>
          </div>
        </div>
        <div class="profile-container">
          <button onclick="toggleProfile()" class="profile-btn"><?= strtoupper(substr($nama_pengguna, 0, 1)); ?></button>
          <div class="profile-card" id="profileCard">
            <div class="profile-avatar"><?= strtoupper(substr($nama_pengguna, 0, 1)); ?></div>
            <div class="profile-name"><?= htmlspecialchars($nama_pengguna); ?></div>
            <details class="profile-detail">
              <summary>Email <i class="fas fa-chevron-down"></i></summary>
              <p><?= htmlspecialchars($email_pengguna); ?></p>
            </details>
            <details class="profile-detail">
              <summary>No HP <i class="fas fa-chevron-down"></i></summary>
              <p><?= htmlspecialchars($nohp_pengguna); ?></p>
            </details>
            <form id="logoutForm" action="logout.php" method="post"><button type="button" class="profile-button logout"
                onclick="konfirmasiLogout()"><i class="fas fa-sign-out-alt"></i> Keluar</button></form>
          </div>
        </div>
      <?php endif; ?>
      <div class="burger" id="burger"><span></span><span></span><span></span></div>
    </div>
  </header>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const burger = document.getElementById("burger"); const menu = document.getElementById("menu");
      burger.addEventListener("click", () => { menu.classList.toggle("show"); burger.classList.toggle("open") });
      window.addEventListener("click", function (e) { if (!menu.contains(e.target) && !burger.contains(e.target)) { menu.classList.remove("show"); burger.classList.remove("open") } })
    });
    function toggleProfile() {
      const card = document.getElementById("profileCard"); card.style.display = (card.style.display === "block") ? "none" : "block"; document.getElementById("notifCard").style.display = "none"; document.getElementById("historyCard").style.display = "none"
    }
    function toggleNotif() { const card = document.getElementById("notifCard"); const bell = document.querySelector(".bell"); const badge = document.getElementById("notifBadge"); card.style.display = (card.style.display === "block") ? "none" : "block"; document.getElementById("profileCard").style.display = "none"; document.getElementById("historyCard").style.display = "none"; bell.style.animation = "ring 1s ease"; setTimeout(() => bell.style.animation = "", 1000); if (badge) { badge.style.display = "none" }; fetch("update_notif.php") }
    function toggleHistory() { const card = document.getElementById("historyCard"); card.style.display = (card.style.display === "block") ? "none" : "block"; document.getElementById("notifCard").style.display = "none"; document.getElementById("profileCard").style.display = "none" }
    function closeNotif() { document.getElementById("notifCard").style.display = "none" }
    function closeHistory() { document.getElementById("historyCard").style.display = "none" }
    function konfirmasiLogout() { Swal.fire({ title: 'Apakah Anda yakin?', text: "Anda akan keluar dari akun ini!", icon: 'warning', showCancelButton: true, confirmButtonColor: '#007bff', cancelButtonColor: '#d33', confirmButtonText: 'Ya, Keluar!', cancelButtonText: 'Batal' }).then((result) => { if (result.isConfirmed) { document.getElementById("logoutForm").submit() } }) }
  </script>
</body>

</html>