<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Reservasi - E-sarpras BBPMP Jabar</title>
  <link href="../CSS/style2.css" rel="stylesheet">
  <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f5f5f5;
    }

    .main-container {
      padding: 30px;
    }

    .slider {
      position: relative;
      overflow: hidden;
      width: 100%;
      max-width: 1100px;
      margin: 0 auto 40px;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .slides {
      display: flex;
      transition: transform 0.5s ease-in-out;
    }

    .slides img {
      width: 100%;
      height: 350px;
      object-fit: cover;
    }

    .nav-button {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background-color: rgba(0, 0, 0, 0.5);
      color: #fff;
      border: none;
      padding: 10px;
      font-size: 24px;
      cursor: pointer;
      border-radius: 50%;
      z-index: 1;
    }

    .prev {
      left: 10px;
    }

    .next {
      right: 10px;
    }

    .card-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
      padding: 10px;
    }

    .card {
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      display: flex;
      flex-direction: column;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card-img img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .card-btn {
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      color: white;
      border: none;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .card-btn:hover {
      background-color: #0056b3;
    }

    .image-hover-container {
      position: relative;
      display: inline-block;
      width: 100%;
      height: 200px;
      overflow: hidden;
      border-radius: 5px;
    }

    .image-hover-container img {
      width: 100%;
      height: 100%;
      display: block;
      object-fit: cover;
    }

    .hover-text {
      position: absolute;
      bottom: 0;
      background: rgba(0, 0, 0, 0.6);
      color: #fff;
      width: 100%;
      padding: 10px;
      text-align: center;
      opacity: 0;
      transition: opacity 0.3s ease;
      font-weight: bold;
      font-size: 14px;
      bottom: -20px;
    }

    .image-hover-container:hover .hover-text {
      opacity: 1;
      bottom: 20px;
    }

    @media (max-width: 768px) {
      .main-container {
        padding: 15px;
      }

      .slides img {
        height: 220px;
      }

      .card-btn {
        font-size: 14px;
        padding: 10px;
      }

      .hover-text {
        font-size: 12px;
      }
    }

    @media (max-width: 480px) {
      .slides img {
        height: 180px;
      }

      .card-grid {
        grid-template-columns: 1fr;
      }

      .card-btn {
        font-size: 13px;
      }
    }
  </style>
</head>

<body>
  <?php include 'header2.php'; ?>
  <main>
    <div class="main-container">

      <div class="slider">
        <div class="slides" id="slideContainer">
          <img src="../ASSET/AulaSlide.jpg" alt="Gambar 1">
          <img src="../ASSET/mess dan asrama.jpg" alt="Gambar 2">
          <img src="../ASSET/kelas.jpeg" alt="Gambar 3">
        </div>
        <button class="nav-button prev" onclick="prevSlide()"><i class="fas fa-chevron-left"></i></button>
        <button class="nav-button next" onclick="nextSlide()"><i class="fas fa-chevron-right"></i></button>
      </div>

      <div class="card-grid">
        <?php
        $result = mysqli_query($koneksi, "SELECT * FROM ruangan");
        while ($row = mysqli_fetch_assoc($result)) {
          $nama = $row['nama_ruangan'];
          $foto = !empty($row['photo']) ? '../ASSET/GALERIDB/' . $row['photo'] : '../ASSET/noimage.jpg';
          echo "
            <div class='card'>
              <div class='card-img'>
                <div class='image-hover-container'>
                  <img src='{$foto}' alt='{$nama}'>
                  <div class='hover-text'>{$nama}</div>
                </div>
              </div>
              <a href='reservasi.php?ruangan=" . urlencode($nama) . "'>
                <button class='card-btn'>Pesan</button>
              </a>
            </div>
          ";
        }
        ?>
      </div>

    </div>

    <script>
      let index = 0;
      function showSlide(i) {
        const container = document.getElementById("slideContainer");
        const slides = container.querySelectorAll("img");
        const totalSlides = slides.length;
        index = (i + totalSlides) % totalSlides;
        container.style.transform = `translateX(-${index * 100}%)`;
      }
      function nextSlide() { showSlide(index + 1); }
      function prevSlide() { showSlide(index - 1); }
      window.onload = function () {
        showSlide(0);
        setInterval(nextSlide, 5000);
      };
    </script>
  </main>
</body>

</html>