<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-sapras BBPMP Jabar - Login Form</title>
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
      background: linear-gradient(135deg, #ffffff, #f9fcff);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }

    .shape { /* DEKORATIF */
      position: absolute;
      border-radius: 50%;
      filter: blur(120px);
      opacity: 0.3;
      z-index: 0;
    }

    .shape1 { /* DEKORATIF */
      width: 300px;
      height: 300px;
      background: #3fa9f5;
      top: -120px;
      left: -80px;
    }

    .shape2 { /* DEKORATIF */
      width: 350px;
      height: 350px;
      background: #007ac2;
      bottom: -150px;
      right: -120px;
    }

    .shape3 { /* DEKORATIF */
      width: 200px;
      height: 200px;
      background: #00c2ff;
      bottom: 80px;
      left: -100px;
    }

    .container {
      width: 100%;
      max-width: 420px;
      z-index: 1;
      position: relative;
    }

    .login {
      background: #ffffff;
      padding: 2rem;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
      animation: fadeInUp 0.9s ease-out forwards;
      opacity: 0;
      position: relative;
    }

    @keyframes fadeInUp { /* ANIMASI FADE IN FORM */
      0% {
        opacity: 0;
        transform: translateY(30px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .logo {
      width: 120px;
      margin-bottom: 20px;
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
      color: #007bdb;
    }

    form input {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 25px;
      transition: 0.2s ease;
      font-size: 16px;
    }

    form input:focus {
      border-color: #007bdb;
      outline: none;
      box-shadow: 0 0 6px rgba(0, 123, 219, 0.25);
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
    }

    .input-icon input {
      padding-left: 40px;
    }

    button {
      width: 100%;
      background: #0098e5;
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 25px;
      font-weight: bold;
      margin-top: 15px;
      cursor: pointer;
      transition: transform 0.2s ease, background 0.3s ease;
      font-size: 16px;
    }

    button i {
      margin-right: 8px;
    }

    button:hover {
      background: #007ac2;
      transform: scale(1.03);
    }

    .daftar {
      margin-top: 15px;
      font-size: 1rem;
    }

    .daftar a {
      color: #0098e5;
      font-weight: bold;
      text-decoration: none;
    }

    .daftar a:hover {
      text-decoration: underline;
    }

    @media (max-width: 480px) { /* RESPONSIVE */
      body {
        padding: 10px;
      }
      .login {
        padding: 1.5rem;
      }
      .logo {
        width: 100px;
      }
      form input,
      button {
        font-size: 15px;
        padding: 11px 14px;
      }
      .text_kembali {
        font-size: 20px;
        right: 10px;
        top: 10px;
      }
    }
  </style>
</head>

<body>
  <div class="shape shape1"></div>
  <div class="shape shape2"></div>
  <div class="shape shape3"></div>

  <div class="container"> <!-- Wrapp Login-->
    <div class="login">
      <a href="index.php" onclick="return konfirmasiBatal()" class="text_kembali">x</a> <!-- Close Button -->
      <img src="../ASSET/logo bbpmp baru.png" alt="Logo BBPMP Jabar" class="logo" />

      <form method="post" action="proses_login">
        <div class="input-icon">
          <i class="fas fa-user"></i> 
          <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-icon">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit">
          <i class="fas fa-sign-in-alt"></i> MASUK
        </button>
      </form>

      <p class="daftar">Belum Punya Akun?
        <a href="daftar.php">Daftar</a>
      </p>
    </div>
  </div>

  <script> // FUNGSI KONFIRMASI BATAL LOGIN
    function konfirmasiBatal() {
      event.preventDefault();
      Swal.fire({
        title: 'Batalkan Login?',
        text: "Anda akan kembali ke halaman utama",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Kembali',
        cancelButtonText: 'Tetap di sini',
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '../index.php';
        }
      });
      return false;
    }
  </script>
</body>

</html>
