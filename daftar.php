<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-sapras BBPMP Jabar - Daftar Akun</title>
  <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!-- IMPORT FONT AWESOME -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- IMPORT SWEETALERT -->

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: #fff;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }

    body::before,
    /* DEKORATIF */
    body::after {
      content: '';
      position: absolute;
      width: 250px;
      height: 250px;
      border-radius: 50%;
      filter: blur(140px);
      z-index: 0;
    }

    body::before {
      /* DEKORATIF */
      top: -50px;
      left: -60px;
      background: rgba(0, 152, 229, 0.18);
    }

    body::after {
      /* DEKORATIF */
      bottom: -50px;
      right: -60px;
      background: rgba(0, 152, 229, 0.12);
    }

    .container {
      width: 100%;
      max-width: 420px;
      position: relative;
      z-index: 1;
    }

    .login {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(15px);
      padding: 2rem;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 8px 28px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.9s ease-out forwards;
      opacity: 0;
      transform: scale(0.96);
    }

    @keyframes fadeIn {

      /* ANIMASI FADE IN FORM */
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .logo {
      width: 120px;
      margin-bottom: 12px;
    }

    .judul {
      font-size: 22px;
      margin-bottom: 15px;
      font-weight: bold;
      color: #333;
    }

    form input {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 25px;
      transition: 0.2s ease;
      font-size: 16px;
      background: #fafafa;
    }

    form input:focus {
      border-color: #007bdb;
      outline: none;
      box-shadow: 0 0 6px rgba(0, 123, 219, 0.3);
      background: #fff;
    }

    .input-icon {
      position: relative;
    }

    .input-icon i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #777;
      font-size: 15px;
    }

    .input-icon input {
      padding-left: 40px;
    }

    button {
      width: 100%;
      background: linear-gradient(135deg, #0098e5, #007ac2);
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 25px;
      font-weight: bold;
      margin-top: 10px;
      cursor: pointer;
      transition: 0.3s ease;
      font-size: 16px;
      letter-spacing: 0.5px;
    }

    button i {
      margin-right: 8px;
    }

    button:hover {
      background: linear-gradient(135deg, #007ac2, #0067a8);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0, 123, 219, 0.4);
    }

    .daftar {
      margin-top: 12px;
      font-size: 0.95rem;
      color: #555;
    }

    .daftar a {
      color: #007ac2;
      font-weight: bold;
      text-decoration: none;
    }

    .daftar a:hover {
      text-decoration: underline;
    }

    .text_kembali {
      position: absolute;
      top: 14px;
      right: 16px;
      text-decoration: none;
      font-size: 18px;
      font-weight: bold;
      color: #888;
      transition: color 0.3s ease;
    }

    .text_kembali:hover {
      color: #007ac2;
      transform: scale(1.1);
    }

    @media (max-width: 480px) {

      /* RESPONSIVE */
      .login {
        padding: 1.6rem;
      }

      .logo {
        width: 100px;
      }

      form input,
      button {
        font-size: 15px;
      }

      .text_kembali {
        font-size: 18px;
      }
    }
  </style>
</head>

<body>

  <div class="container"> <!-- Wrapp Daftar -->
    <div class="login">
      <a href="../index.php" onclick="return konfirmasiBatal()" class="text_kembali">x</a> <!-- Close Button -->
      <img src="../ASSET/logo bbpmp baru.png" alt="Logo BBPMP Jabar" class="logo" />
      <h2 class="judul">Form Pendaftaran</h2>

      <form method="post" action="cek_registrasi">
        <div class="input-icon">
          <i class="fas fa-user"></i>
          <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-icon">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-icon">
          <i class="fas fa-phone"></i>
          <input type="text" name="nohp" placeholder="No. HP" required>
        </div>

        <!-- PILIH ROLE -->
        <div class="input-icon">
          <i class="fas fa-users"></i>
          <select name="kategori" required style="
      width: 100%;
      padding: 12px 15px 12px 40px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 25px;
      background: #fafafa;
      font-size: 16px;
      appearance: none;
      color: #555;
    ">
            <option value="" disabled selected>Pilih Jenis Pengguna</option>
            <option value="internal">Internal (Pegawai BBPMP)</option>
            <option value="eksternal">Eksternal (Tamu / Instansi Luar)</option>
          </select>
        </div>

        <div class="input-icon">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Password" required>
        </div>

        <div class="input-icon">
          <i class="fas fa-lock"></i>
          <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
        </div>

        <button type="submit">
          <i class="fas fa-user-plus"></i> DAFTAR
        </button>
      </form>


      <p class="daftar">Sudah punya akun?
        <a href="../login.php">Login</a>
      </p>
    </div>
  </div>

  <script> // FUNGSI KONFIRMASI BATAL DAFTAR
    function konfirmasiBatal() {
      event.preventDefault();
      Swal.fire({
        title: 'Batalkan Pendaftaran?',
        text: "Anda akan kembali ke halaman utama",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Kembali',
        cancelButtonText: 'Tetap di sini',
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'index.php';
        }
      });
      return false;
    }
  </script>
</body>

</html>