<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kontak - E-sarpras BBPMP Jabar</title>
  <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: #f7f7f7;
      overflow-x: hidden;
    }

    .hero {
      background: #0090d4;
      color: white;
      text-align: center;
      padding: 40px 20px;
      border-radius: 10px;
      max-width: 1000px;
      margin: 20px auto;
    }

    .hero h2 {
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .hero span {
      font-size: 16px;
      display: block;
    }

    .container {
      display: flex;
      justify-content: center;
      padding: 40px 10px;
    }

    .card {
      background: #ffffff;
      width: 100%;
      max-width: 1000px;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card h3 {
      color: #0056b3;
      margin-bottom: 15px;
      font-size: 22px;
    }

    .card p {
      margin-bottom: 20px;
      line-height: 1.8;
      color: #333;
    }

    .kontak {
      margin-top: 20px;
      line-height: 1.8;
      font-size: 16px;
    }

    .btn-wa {
      display: inline-block;
      margin-top: 15px;
      padding: 10px 20px;
      background-color: #25D366;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
      transition: 0.3s;
    }

    .btn-wa:hover {
      background-color: #128C7E;
    }

    .map {
      margin-top: 30px;
    }

    iframe {
      width: 100%;
      height: 450px;
      border-radius: 10px;
      border: 0;
    }

    @media (max-width: 768px) {
      .hero h2 {
        font-size: 18px;
      }

      .hero span {
        font-size: 14px;
      }

      .card {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>

  <div class="hero">
    <h2>BBPMP Provinsi Jawa Barat Kampus I</h2>
    <span>Jl. Raya Batujajar No.KM.2 No.90, Laksanamekar, Kec. Padalarang,
      Kabupaten Bandung Barat, Jawa Barat 40553</span>
  </div>

  <main class="container">
    <div class="card">
      <h3>Tentang Kami</h3>
      <p>
        Balai Besar Penjaminan Mutu Pendidikan (BBPMP) Provinsi Jawa Barat merupakan unit pelaksana teknis
        Kementerian Pendidikan Dasar dan Menengah yang berada di dua lokasi:
        <br>- Kampus 1 di Padalarang, Kabupaten Bandung Barat
        <br>- Kampus 2 di Jayagiri, Lembang Kabupaten Bandung Barat
      </p>

      <h3>Kontak</h3>
      <div class="kontak">
        📞 (022) 686 6152 <br>
        📱 0851 6888 8390<br>
        ✉️ saprasbbpmpjbr@gmail.com <br>
        📍 Lihat di Google Maps
        <br>
        <a class="btn-wa"
          href="https://api.whatsapp.com/send/?phone=628111171313&text&type=phone_number&app_absent=0">
          Chat WhatsApp
        </a>
      </div>

      <div class="map">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3429.8658355569937!2d107.49981267430825!3d-6.87763696729425!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e49561a2c469%3A0xdbb4904025ba391e!2sBalai%20Besar%20Penjaminan%20Mutu%20Pendidikan%20(BBPMP)%20Jawa%20Barat!5e1!3m2!1sid!2sid!4v1752717620468!5m2!1sid!2sid"
          allowfullscreen="" loading="lazy"></iframe>
      </div>
    </div>
  </main>
</body>
</html>
