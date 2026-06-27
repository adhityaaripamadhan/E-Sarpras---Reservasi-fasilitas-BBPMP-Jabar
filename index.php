<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Beranda - E-sarpras BBPMP Jabar</title>
  <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9fafc;
      color: #333;
      overflow-x: hidden;
    }

    main {
      margin-top: 20px;
    }

    .header-container {
      width: 100%;
      height: 350px;
      overflow: hidden;
      position: relative;
      box-shadow: none;
      margin: 0;
      border-radius: 0;
    }

    .slide {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transform: scale(1.1);
      transition: opacity 1s ease-in-out, transform 6s ease;
    }

    .slide.active {
      opacity: 1;
      z-index: 1;
      transform: scale(1);
    }

    /* overlay gelap agar teks lebih jelas */
    .hero-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.45);
      z-index: 2;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: white;
      padding: 0 20px;
    }

    .hero-overlay h1 {
      font-size: 42px;
      font-weight: 700;
      margin-bottom: 15px;
      line-height: 1.2;
      animation: fadeInDown 1s ease both;
    }

    .hero-overlay p {
      font-size: 18px;
      max-width: 700px;
      margin: 0 auto;
      opacity: 0.9;
      animation: fadeInUp 1.2s ease both;
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h2.section-title {
      text-align: center;
      margin: 60px 20px 30px 20px;
      font-size: 28px;
      font-weight: 600;
      color: #2c3e50;
      position: relative;
      display: inline-block;
    }

    h2.section-title::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: -8px;
      width: 100%;
      height: 3px;
      background: linear-gradient(90deg, #2ba2f1ff, #c2d7f5ff);
      border-radius: 2px;
    }

    .custom-gallery {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      padding: 0 60px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .item {
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
      height: 250px;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .item:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.18);
    }

    .item1 {
      grid-column: 1 / span 2;
    }

    .item4 {
      grid-column: 2 / span 2;
    }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
      .custom-gallery {
        grid-template-columns: repeat(2, 1fr);
        padding: 0 30px;
      }

      .item1,
      .item4 {
        grid-column: auto;
      }

      .hero-overlay h1 {
        font-size: 32px;
      }

      .hero-overlay p {
        font-size: 16px;
      }
    }

    @media (max-width: 600px) {
      .custom-gallery {
        grid-template-columns: 1fr;
        padding: 0 20px;
      }

      .item {
        height: 220px;
      }

      .hero-overlay h1 {
        font-size: 26px;
      }

      .hero-overlay p {
        font-size: 14px;
      }
    }

    .qna-reservasi-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      padding: 60px;
      max-width: 1200px;
      margin: 0 auto;
      align-items: start;
    }

    @media (max-width: 900px) {
      .qna-reservasi-container {
        grid-template-columns: 1fr;
        gap: 20px;
        padding: 20px;
        max-width: 100%;
      }
    }

    .qna-section,
    .reservasi-section {
      background: #fff;
      border-radius: 14px;
      padding: 25px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
      position: relative;
      overflow: hidden;
      animation: fadeInUp 1s ease both;
    }

    .qna-section::before,
    .reservasi-section::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 6px;
      background: linear-gradient(90deg, #2ba2f1ff, #c2d7f5ff);
    }

    .qnajudul {
      font-size: 22px;
      font-weight: 600;
      margin-bottom: 20px;
      color: #2c3e50;
    }

    .qna-item {
      border-bottom: 1px solid #eee;
    }

    .qna-question {
      cursor: pointer;
      padding: 16px 10px;
      font-weight: 500;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: background 0.2s;
    }

    .qna-question:hover {
      background: #f8f8f8;
    }

    .qna-answer {
      padding: 0 10px 15px 10px;
      display: none;
      font-size: 15px;
      color: #555;
      line-height: 1.5;
    }

    .arrow {
      transition: transform 0.3s ease;
    }

    .qna-question.active .arrow {
      transform: rotate(180deg);
    }

    .qna-answer.show {
      display: block;
    }

    .reservasi-box ol {
      padding-left: 20px;
      font-size: 15px;
      color: #444;
      line-height: 1.6;
    }

    footer {
      background-color: #2c3e50;
      color: white;
      padding: 30px 20px;
      text-align: center;
      margin-top: 60px;
    }

    .foottxt p {
      margin: 6px 0;
      font-size: 14px;
    }

    .txtbawah1 {
      font-weight: bold;
      font-size: 16px;
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?> <!-- Panggil Header -->

  <!-- Hero Slideshow -->
  <main>
    <div class="header-container">

      <div class="slideshow">
        <img src="/ASSET/BBPMP.jpg" class="slide active">
        <img src="/ASSET/tenis.jpg" class="slide">
        <img src="/ASSET/Aula.jpg" class="slide">
        <img src="/ASSET/tamanBBPMP.jpg" class="slide">
        <img src="/ASSET/mess dan asrama.jpg" class="slide">
      </div>
      <div class="hero-overlay">
        <!-- Title hero -->
        <h1>Selamat Datang di E-Sarpras BBPMP Jawa Barat</h1>

        <!-- Deskripsi Hero -->
        <p>Temukan berbagai fasilitas ruang pertemuan, pelatihan, hingga penginapan dengan mudah, nyaman, dan cepat.</p>
      </div>
    </div>

  <!-- Galeri Ruangan -->
    <center>
      <h2 class="section-title">Galeri Ruangan di BBPMP</h2>
    </center>
    <div class="custom-gallery">
      <div class="item item1">
        <img src="../ASSET/Aula.jpg" alt="Aula">
      </div>
      <div class="item item2">
        <img src="../ASSET/kelas.jpeg" alt="Kelas 1">
      </div>
      <div class="item item3">
        <img src="../ASSET/kelas.jpeg" alt="Kelas 2">
      </div>
      <div class="item item4">
        <img src="../ASSET/mess dan asrama.jpg" alt="Mess">
      </div>
    </div>
  </main>

  <!-- Faq + Cara Reservasi -->
  <div class="qna-reservasi-container">
    <div class="qna-section">
      <h2 class="qnajudul">FAQ</h2>
      <div class="qna-item">
        <div class="qna-question" onclick="toggleQnA(this)">
          Apa saja jenis ruangan yang tersedia?<span class="arrow">⌄</span>
        </div>
        <div class="qna-answer">Ruangan yang tersedia meliputi Aula Tangkuban Parahu untuk kegiatan besar,
          Kelas Cikurai I dan II untuk pelatihan atau kelas kecil-menengah,
          serta Mess dan Asrama untuk kebutuhan penginapan peserta kegiatan.</div>
      </div>
      <div class="qna-item">
        <div class="qna-question" onclick="toggleQnA(this)">
          Bagaimana prosedur pengecekan ketersediaan?<span class="arrow">⌄</span>
        </div>
        <div class="qna-answer">Pengguna dapat mengecek ketersediaan ruangan dengan menghubungi bagian layanan umum
          BBPMP Jawa Barat melalui telepon, email, atau mengakses jadwal penggunaan ruangan (jika tersedia online).
          Setelah itu, konfirmasi reservasi bisa dilakukan jika ruangan masih tersedia.</div>
      </div>
      <div class="qna-item">
        <div class="qna-question" onclick="toggleQnA(this)">
          Berapa lama durasi maksimal penggunaan?<span class="arrow">⌄</span>
        </div>
        <div class="qna-answer">Durasi penggunaan ruangan umumnya dibatasi hingga pukul 17.00 WIB.
          Namun, untuk kegiatan khusus yang membutuhkan waktu lebih panjang,
          pengguna dapat mengajukan izin khusus kepada pengelola BBPMP.</div>
      </div>
      <div class="qna-item">
        <div class="qna-question" onclick="toggleQnA(this)">
          Bisa dipakai akhir pekan?<span class="arrow">⌄</span>
        </div>
        <div class="qna-answer">Ya, penggunaan ruangan pada akhir pekan atau hari libur dimungkinkan, namun harus
          diajukan terlebih dahulu
          dan mendapat persetujuan dari pihak pengelola BBPMP.
          Ketersediaan dan petugas operasional akan disesuaikan dengan jadwal kegiatan yang direncanakan.</div>
      </div>
    </div>

    <div class="reservasi-section">
      <h2 class="qnajudul">Cara reservasi</h2>
      <div class="reservasi-box">
        <ol>
          <li>Login ke akun Anda.</li>
          <li>Pilih jenis ruangan yang ingin dipesan.</li>
          <li>Klik tombol "Detail" untuk melihat jadwal ruangan.</li>
          <li>Tentukan tanggal dan waktu.</li>
          <li>Klik tombol “Pesan” dan isi formulir reservasi.</li>
          <li>Tunggu konfirmasi dari admin (maks. 3 hari kerja).</li>
        </ol>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="foottxt">
      <p class="txtbawah1">© 2025 E-Sapras BBPMP Jawa Barat</p>
      <p>Jl. Raya Batujajar No.KM.2 No.90 | Telp: (022) 686 6152</p>
      <p>saprasbbpmpjbr@gmail.com</p>
    </div>
  </footer>

  <script>
  // --- FUNGSI DROPDOWN FAQ ---
  function toggleQnA(el) {
    const active = document.querySelector('.qna-question.active');
    const answer = el.nextElementSibling;

    // Tutup pertanyaan lain jika sedang terbuka
    if (active && active !== el) {
      active.classList.remove('active');
      active.nextElementSibling.classList.remove('show');
    }

    // Buka/tutup pertanyaan yang diklik
    el.classList.toggle('active');
    answer.classList.toggle('show');
  }

  // --- SLIDESHOW GAMBAR HERO ---
  let slideIndex = 0;
  const slides = document.querySelectorAll('.header-container .slide');
  const slideDuration = 5000; // 5 detik per gambar

  function showSlides(n) {
    slides.forEach(s => s.classList.remove('active'));
    slideIndex = n;
    slides[slideIndex].classList.add('active');
  }

  function nextSlide() {
    slideIndex = (slideIndex + 1) % slides.length;
    showSlides(slideIndex);
  }

  // Jalankan otomatis
  setInterval(nextSlide, slideDuration);
  showSlides(slideIndex);
</script>
</body>

</html>