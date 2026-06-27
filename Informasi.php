<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Reservasi - E-sarpras BBPMP Jabar</title>
  <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      overflow-x: hidden;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 0;
    }

    .bg1 {
      background: #ffffff;
      width: 100%;
      margin-top: 10px;
    }

    .bg2 {
      background: #0090d4;
      position: relative;
      margin: auto;
      width: 90%;
      height: auto;
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      color: white;
      border-radius: 5px;
      align-items: center;
      text-align: center;
    }

    .textj1 {
      font-size: 35px;
    }

    .textj2 {
      margin-top: 5px;
      font-size: 18px;
    }

    .search-bar {
      width: 90%;
      margin: 20px auto 0;
      display: flex;
      justify-content: center;
    }

    .search-wrapper {
      display: flex;
      align-items: center;
      background: #fff;
      border: 2px solid #ddd;
      border-radius: 30px;
      padding: 8px 15px;
      width: 100%;
      max-width: 500px;
      transition: 0.3s;
    }

    .search-wrapper i {
      font-size: 16px;
      color: #888;
      margin-right: 10px;
    }

    .search-wrapper .divider {
      width: 1px;
      height: 20px;
      background: #717171ff;
      margin-right: 10px;
    }

    .search-wrapper input {
      flex: 1;
      border: none;
      outline: none;
      font-size: 15px;
    }

    .search-wrapper:focus-within {
      border-color: #007bff;
      box-shadow: 0 0 6px rgba(0, 123, 255, 0.4);
    }

    .group1 {
      margin-top: 20px;
      display: flex;
      gap: 14px;
      overflow-x: auto;
      padding: 10px 15px;
      scroll-snap-type: x mandatory;
      scrollbar-width: thin;
      scrollbar-color: #2c8dddff #f1f1f1;
      justify-content: center;
    }

    .group1::-webkit-scrollbar {
      height: 6px;
    }

    .group1::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .group1::-webkit-scrollbar-thumb {
      background: #007bff;
      border-radius: 10px;
    }

    .group1 a {
      flex: 0 0 auto;
      scroll-snap-align: start;
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 18px;
      font-size: 15px;
      border-radius: 30px;
      text-decoration: none;
      background: linear-gradient(135deg, #fdfdfd, #ececec);
      color: #333;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }

    .group1 a i {
      font-size: 16px;
      transition: transform 0.3s ease;
    }

    .group1 a:hover {
      background: linear-gradient(135deg, #00a2ff, #007bff);
      color: white;
      transform: translateY(-3px);
      box-shadow: 0 6px 12px rgba(0, 123, 255, 0.3);
    }

    .group1 a:hover i {
      transform: scale(1.2) rotate(8deg);
    }

    .group1 a.active {
      background: linear-gradient(135deg, #007bff, #0056b3);
      color: white;
      border: 2px solid #ffffff66;
    }

    .card-wrapper {
      background: #ffffff;
      width: 90%;
      margin: 30px auto;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      max-width: 1200px;
      margin: auto;
    }

    .card {
      background: #ffffff;
      width: 350px;
      height: 370px;
      display: flex;
      flex-direction: column;
      border: 1px solid #c0c0c0ff; 
      border-radius: 3px;
      cursor: pointer;
      transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .card:hover {
      transform: scale(1.02);
    }

    .card.hide {
      opacity: 0;
      transform: scale(0.95);
      pointer-events: none;
      position: absolute;
    }

    .card img {
      width: 100%;
      height: 200px;
      border-top-left-radius: 3px;
      border-top-right-radius: 3px;
      object-fit: cover;
    }

    .card-content {
      padding: 10px;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }

    .category {
      font-size: 15px;
      color: blue;
    }

    .title {
      font-size: 22px;
      font-weight: bold;
      color: black;
      margin: 10px 0 5px;
    }

    .desc {
      font-size: 15px;
      color: black;
      margin: 5px 0;
    }

    .status {
      font-weight: bold;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 14px;
    }

    .status-kosong {
      color: #28a745;
      background-color: #d4edda;
    }

    .status-pinjam {
      color: #dc3545;
      background-color: #f8d7da;
    }

    .card-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: auto;
    }

    .btn-group {
      display: flex;
      gap: 8px;
    }

    .btn-pesan {
      padding: 6px 12px;
      background: #007bff;
      color: #fff;
      font-weight: bold;
      text-decoration: none;
      border-radius: 5px;
      transition: background 0.3s ease;
      font-size: 14px;
    }

    .btn-pesan:hover {
      background: #0056b3;
    }

    .btn-action-detail {
      background: #bfc0c2ff;
      color: white;
      padding: 6px 12px;
      border-radius: 5px;
      text-decoration: none;
      font-size: 14px;
      font-weight: bold;
      transition: background 0.3s ease;
      white-space: nowrap;
      display: inline-flex;
      align-items: center;
    }

    .btn-action-detail:hover {
      background: #8a8a8aff;
    }

    /* --- Responsive --- */
    @media (max-width: 1024px) {
      .textj1 {
        font-size: 28px;
      }

      .card {
        width: 300px;
        height: auto;
      }
    }

    @media (max-width: 768px) {
      .bg2 {
        width: 95%;
        padding: 15px;
      }

      .textj1 {
        font-size: 24px;
      }

      .textj2 {
        font-size: 16px;
      }

      .card {
        width: 100%;
        max-width: 100%;
      }

      .group1 a {
        font-size: 14px;
        padding: 6px 12px;
      }
    }

    @media (max-width: 480px) {
      .textj1 {
        font-size: 20px;
      }

      .textj2 {
        font-size: 14px;
      }

      .card {
        width: 100%;
      }
    }

    @media (max-width: 768px) {
      .group1 {
        justify-content: flex-start;
      }
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>
  <div class="bg1">
    <div class="bg2">
      <h2 class="textj1">Fasilitas BBPMP Jabar</h2>
      <p class="textj2">Daftar ruangan dan kapasitas yang tersedia</p>
    </div>

    <div class="search-bar">
      <div class="search-wrapper">
        <i class="fa-solid fa-magnifying-glass"></i>
        <span class="divider"></span>
        <input type="text" id="searchInput" placeholder="Cari ruangan atau deskripsi...">
      </div>
    </div>

    <div class="group1">
      <a class="active" onclick="filterKategori(this, 'semua')">
        <i class="fa-solid fa-border-all"></i> Semua
      </a>
      <a onclick="filterKategori(this, 'aula')">
        <i class="fa-solid fa-building-columns"></i> Aula
      </a>
      <a onclick="filterKategori(this, 'kelas')">
        <i class="fa-solid fa-chalkboard-user"></i> Kelas
      </a>
      <a onclick="filterKategori(this, 'mess')">
        <i class="fa-solid fa-bed"></i> Mess
      </a>
      <a onclick="filterKategori(this, 'lainnya')">
        <i class="fa-solid fa-layer-group"></i> Lainnya
      </a>
    </div>

    <!-- Card -->
    <div class="card-wrapper">
      <div class="card-container">
        <?php
        include 'koneksi.php';
        $query = "SELECT * FROM ruangan ORDER BY id_ruangan ASC";
        $result = mysqli_query($koneksi, $query);
        $today = date('Y-m-d');

        while ($row = mysqli_fetch_assoc($result)) {
          $id_ruangan = $row['id_ruangan'];
          $nama = htmlspecialchars($row['nama_ruangan']);
          $deskripsi = nl2br(htmlspecialchars($row['deskripsi']));
          $foto = htmlspecialchars($row['photo']);
          $url = "jadwal.php?jenis=" . urlencode($nama);

          $kategori = (stripos($nama, 'aula') !== false) ? 'aula' :
            ((stripos($nama, 'kelas') !== false) ? 'kelas' :
              ((stripos($nama, 'mess') !== false) ? 'mess' : 'lainnya'));

          $cek = mysqli_query($koneksi, "
            SELECT Status FROM reservasi
            WHERE Ruangan = '$nama'
            AND '$today' BETWEEN TanggalAwal AND TanggalAkhir
            ORDER BY id DESC LIMIT 1
          ");

          $statusText = 'Kosong';
          $statusClass = 'status-kosong';
          if (mysqli_num_rows($cek) > 0) {
            $statusRow = mysqli_fetch_assoc($cek);
            $status = strtolower($statusRow['Status']);
            switch ($status) {
              case 'disetujui':
                $statusText = 'Sudah Dipinjam';
                $statusClass = 'status-pinjam';
                break;
              case 'proses':
                $statusText = 'Sedang Diproses';
                $statusClass = 'status-pinjam';
                break;
              case 'pending':
                $statusText = 'Menunggu Verifikasi';
                $statusClass = 'status-pinjam';
                break;
              case 'ditolak':
                $statusText = 'Ditolak';
                $statusClass = 'status-pinjam';
                break;
            }
          }

          echo "
          <div class='card' data-kategori='$kategori'>
            <img src='../ASSET/GALERIDB/$foto' alt='$nama'> 
            <div class='card-content'>
              <p class='category'>Ruangan</p>
              <p class='title'>$nama</p>
              <p class='desc'>$deskripsi</p>
              <div class='card-footer'>
                <p class='status $statusClass'>$statusText</p>
                <div class='btn-group'>
                <a href='jadwal.php?jenis=" . urlencode($nama) . "' class='btn-action-detail'>Detail</a>
                <a class='btn-pesan' href='reservasi?redirect=$url'>Pesan</a>
                </div>
              </div>
            </div>
          </div>";
        }
        ?>
      </div>
    </div>
  </div>

  <script>
    function filterKategori(element, kategori) {
      document.querySelectorAll('.group1 a').forEach(a => a.classList.remove('active'));
      element.classList.add('active');
      document.querySelectorAll('.card').forEach(card => {
        const cardKategori = card.getAttribute('data-kategori');
        const matchKategori = (kategori === 'semua' || cardKategori === kategori);
        card.classList.toggle('hide', !matchKategori);
      });
    }

    document.getElementById("searchInput").addEventListener("keyup", function () {
      const value = this.value.toLowerCase();
      document.querySelectorAll(".card").forEach(card => {
        const title = card.querySelector(".title").textContent.toLowerCase();
        const desc = card.querySelector(".desc").textContent.toLowerCase();
        const match = title.includes(value) || desc.includes(value);
        card.classList.toggle("hide", !match);
      });
    });
  </script>
</body>

</html>
