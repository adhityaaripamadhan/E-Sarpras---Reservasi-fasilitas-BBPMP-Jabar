   <?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navigasi Tengah dengan Ikon</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: #f7f7f7;
      padding-top: 80px;
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
      z-index: 1000;
    }

    .logo img {
      height: 40px;
    }

    nav {
      display: flex;
      gap: 30px;
      align-items: center;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
    }

    nav a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
      padding-bottom: 4px;
      border-bottom: 2px solid transparent;
      transition: 0.3s;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    nav a:hover,
    nav a.active {
      color: #007bff;
      border-bottom: 2px solid #007bff;
    }

    nav a i {
      font-size: 16px;
    }

    .auth-links {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .auth-links a {
      text-decoration: none;
      transition: 0.3s;
      font-weight: 500;
      padding: 6px 14px;
      border-radius: 6px;
      font-size: 14px;
    }

    .txtbtn1 {
      color: #007bff;
      border: 1px solid #007bff;
      background: #fff;
    }

    .txtbtn1:hover {
      background: #007bff;
      color: #fff;
    }

    .txtbtn2 {
      background: #007bff;
      color: #fff;
    }

    .txtbtn2:hover {
      background: #0056b3;
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
      transition: background-color 0.3s ease;
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
      transform: translateX(-50%);
    }

    .burger span:nth-child(1) {
      top: 12px;
    }

    .burger span:nth-child(2) {
      top: 50%;
      transform: translateX(-50%) translateY(-50%);
    }

    .burger span:nth-child(3) {
      bottom: 12px;
    }

    .burger.open span:nth-child(1) {
      top: 50%;
      transform: translateX(-50%) translateY(-50%) rotate(45deg);
    }

    .burger.open span:nth-child(2) {
      opacity: 0;
    }

    .burger.open span:nth-child(3) {
      top: 50%;
      transform: translateX(-50%) translateY(-50%) rotate(-45deg);
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
        left: auto;
        right: 20px;
        transform: none;
        width: 180px;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        animation: slideDown 0.3s ease;
      }

      nav.show {
        display: flex;
      }

      nav a {
        width: 100%;
        padding: 8px 5px;
        margin-bottom: 5px;
        border-radius: 4px;
      }

      nav a:last-child {
        margin-bottom: 0;
      }

      .burger {
        display: flex;
      }
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <header>
    <div class="logo">
      <a href="https://www.bbpmpjabar.id/">
        <img src="../ASSET/logo bbpmp baru.png" alt="logo BBPMP">
      </a>
    </div>

    <nav id="menu">
      <a href="../index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-house"></i> Beranda
      </a>
      <a href="../informasi.php" class="<?= $current_page == 'informasi.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-calendar-check"></i> Reservasi
      </a>
      <a href="../kontak.php" class="<?= $current_page == 'kontak.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-phone"></i> Kontak
      </a>
    </nav>

    <div style="display:flex; align-items:center;">
      <div class="auth-links">
        <a href="../login.php" class="txtbtn1">Masuk</a> 
        |
        <a href="../daftar.php" class="txtbtn2">Daftar</a>
      </div>
      <div class="burger" onclick="toggleMenu()">
        <span></span><span></span><span></span>
      </div>
    </div>
  </header>

  <script>
    function toggleMenu() {
      document.getElementById('menu').classList.toggle('show');
      document.querySelector('.burger').classList.toggle('open');
    }
  </script>
</body>
</html>