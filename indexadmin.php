<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Beranda - E-sapras BBPMP Jabar</title>
  <link rel="stylesheet" href="../CSS/style2.css">
  <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
</head>


<body>
  <?php include '../PHP/headeratmin.php'; ?>
  <main>
    <div class="header-container">
      <div class="slideshow">
        <img src="../ASSET/BBPMP.jpg" class="slide active">
        <img src="../ASSET/tenis.jpg" class="slide">
        <img src="../ASSET/Aula.jpg" class="slide">
        <img src="../ASSET/tamanBBPMP.jpg" class="slide">
        <img src="../ASSET/mess dan asrama.jpg" class="slide">
      </div>
    </div>

    <h2 style="text-align: center; margin-top: 40px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
      Galeri Ruangan di BBPMP
    </h2>

    <div class="custom-gallery">
      <div class="item item1">
        <img src="../ASSET/Aula.jpg" alt="">
        <div class="hover-text">Aula Tangkuban Parahu</div>
      </div>
      <div class="item item2">
        <img src="../ASSET/kelas.jpeg" alt="">
        <div class="hover-text">Kelas Cikurai I</div>
      </div>
      <div class="item item3">
        <img src="../ASSET/kelas.jpeg" alt="">
        <div class="hover-text">Kelas Cikurai II</div>
      </div>
      <div class="item item4">
        <img src="../ASSET/mess dan asrama.jpg" alt="">
        <div class="hover-text">Mess 1</div>
      </div>
    </div>




  </main>

  <br>
  <div class="qna-reservasi-container">
    <div class="qna-section">
      <h2 class="qnajudul">Yang perlu anda ketahui</h2>
      <div class="qna-wrapper">
        <div class="qna-column">

          <div class="qna-item">
            <div class="qna-question" onclick="toggleQnA(this)">
              Apa saja jenis ruangan yang tersedia untuk disewa di BBPMP Jabar?<span class="arrow">⌄</span>
            </div>
            <div class="qna-answer">Ruangan yang tersedia meliputi Aula Tangkuban Parahu untuk kegiatan besar,
              Kelas Cikurai I dan II untuk pelatihan atau kelas kecil-menengah,
              serta Mess dan Asrama untuk kebutuhan penginapan peserta kegiatan.
            </div>
          </div>

          <div class="qna-item">
            <div class="qna-question" onclick="toggleQnA(this)">
              Bagaimana prosedur pengecekan ketersediaan ruangan sebelum reservasi?<span class="arrow">⌄</span>
            </div>
            <div class="qna-answer">Pengguna dapat mengecek ketersediaan ruangan dengan menghubungi bagian layanan umum
              BBPMP Jawa Barat melalui
              telepon, email, atau mengakses jadwal penggunaan ruangan (jika tersedia online).
              Setelah itu, konfirmasi reservasi bisa dilakukan jika ruangan masih tersedia.
            </div>
          </div>

          <div class="qna-item">
            <div class="qna-question" onclick="toggleQnA(this)">
              Berapa lama durasi maksimal penggunaan ruangan dalam satu hari?<span class="arrow">⌄</span>
            </div>
            <div class="qna-answer"> Secara umum, kedua kelas memiliki fasilitas yang serupa, seperti proyektor, papan
              tulis, dan kursi-meja
              belajar. Namun,
              perbedaan kecil bisa terletak pada tata letak atau kapasitas ruangan, tergantung kebutuhan pengguna.
            </div>
          </div>

          <div class="qna-item">
            <div class="qna-question" onclick="toggleQnA(this)">
              Apakah ruangan di BBPMP Jawa Barat bisa digunakan pada akhir pekan atau hari libur?<span
                class="arrow">⌄</span>
            </div>
            <div class="qna-answer"> Durasi penggunaan ruangan umumnya dibatasi hingga pukul 17.00 WIB. Namun, untuk
              kegiatan khusus yang
              membutuhkan waktu lebih panjang,
              pengguna dapat mengajukan izin khusus kepada pengelola BBPMP.
            </div>
          </div>

          <div class="qna-item">
            <div class="qna-question" onclick="toggleQnA(this)">
              Apakah ada perbedaan fasilitas antara Kelas Cikurai I dan Cikurai II? <span class="arrow">⌄</span>
            </div>
            <div class="qna-answer">Ya, penggunaan ruangan pada akhir pekan atau hari libur dimungkinkan, namun harus
              diajukan terlebih dahulu dan
              mendapat persetujuan dari pihak pengelola BBPMP.
              Ketersediaan dan petugas operasional akan disesuaikan dengan jadwal kegiatan yang direncanakan.
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="reservasi-section">
      <h2 class="qnajudul">Cara reservasi</h2>
      <div class="reservasi-box">
        <ol>
          <li>Login ke akun Anda terlebih dahulu.</li>
          <li>Pilih jenis ruangan yang ingin dipesan.</li>
          <li>Klik pada gambar/kartu ruangan untuk melihat jadwal.</li>
          <li>Tentukan tanggal dan waktu yang diinginkan.</li>
          <li>Klik tombol “Pesan” dan isi formulir reservasi.</li>
          <li>Tunggu konfirmasi dari admin. <br> (Maksimal menunggu jawaban 3 hari kerja)</li>
        </ol>
      </div>
    </div>
  </div>

  <script>
    function toggleQnA(el) {
      const currentlyActive = document.querySelector('.qna-question.active');
      const answerShown = el.nextElementSibling;

      if (currentlyActive && currentlyActive !== el) {
        currentlyActive.classList.remove('active');
        currentlyActive.nextElementSibling.classList.remove('show');
      }

      el.classList.toggle('active');
      answerShown.classList.toggle('show');
    }
    let slideIndex = 0;
    const slides = document.querySelectorAll('.header-container .slide');

    function showSlides() {
      slides.forEach((slide, i) => {
        slide.classList.remove('active');
      });

      slideIndex = (slideIndex + 1) % slides.length;
      slides[slideIndex].classList.add('active');
    }

    slides[slideIndex].classList.add('active');

    setInterval(showSlides, 4000);

    document.querySelector(".bg1").onclick = () => window.location.href = "../PHP/jadwal.php?jenis=Aula Tangkuban Parahu";
    document.querySelector(".bg2").onclick = () => window.location.href = "../PHP/jadwal.php?jenis=Kelas Cikurai I";
    document.querySelector(".bg3").onclick = () => window.location.href = "../PHP/jadwal.php?jenis=Kelas Cikurai II";
    document.querySelector(".bg4").onclick = () => window.location.href = "../PHP/jadwal.php?jenis=Mess dan Asrama";
  </script>
  <br>
  <br>
  <br>

  <footer>
    <div class="foottxt">
      <p class="txtbawah1">© 2025 E-Sapras BBPMP Jawa Barat</p>
      <p class="txtbawah2">Jl. Raya Batujajar No.KM.2 No.90 | Telp: (022) 686 6152</p>
      <p class="txtbawah2">saprasbbpmpjbr@gmail.com</p>
    </div>
  </footer>
</body>

</html>