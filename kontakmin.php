<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>E-sapras BBPMP Jabar - Kontak</title>
    <link rel="icon" href="../ASSET/logoicon.png" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: #f7f7f7;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .logo {
            width: 120px;
        }

        .group1 a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .btn3 {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            background-color: #25D366;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
            top: 150px;
            right: 100px;
        }

        .btn3:hover {
            background-color: #128C7E;
        }

        .txtbnt3 {
            font-size: 12px;
        }

        .txt5 {
            margin: 0 10px;
            font-size: 18px;
            color: #999;
        }

        .bg1 {
            background: rgb(237, 233, 233);
            width: 100%;
        }

        .bg2 {
            background: #0090d4;
            ;
            position: relative;
            left: 63px;
            width: 90%;
            height: 160px;
            justify-items: center;
        }

        .bg3 {
            background: #fffafa;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 90%;
            height: 1100px;
            margin: auto;
        }

        .bg4 {
            background: #ffffff;
            width: 80%;
            height: 90%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
        }

        .textj1 {
            font-size: 35px;
            color: white;
            position: relative;
            top: 35px;
        }

        .textj2 {
            color: white;
            position: relative;
            left: 235px;
            top: 40px;
        }

        .textj3 {
            color: #0056b3;
            position: relative;
            left: 20px;
            top: 40px;
        }

        .textj4 {
            position: relative;
            left: 20px;
            top: 60px;
        }

        .textj5 {
            color: #0056b3;
            position: relative;
            left: 20px;
            top: 90px;

        }

        .textj6 {
            position: relative;
            left: 25px;
            top: 110px;
        }

        .textj7 {
            position: relative;
            left: -111px;
            top: 150px;
        }

        .textj8 {
            position: relative;
            left: -376px;
            top: 190px;
        }

        .textj9 {
            position: relative;
            left: -610px;
            top: 230px;
        }

        .map {
            position: relative;
            top: 240px;
            left: 30px;
        }
    </style>
</head>

<body>
    <?php include 'headeratmin.php'; ?>
    <main>

        <div class="bg1">
            <div class="bg2" ?>
                <h2 class="textj1">BBPMP Provinsi Jawa Barat Kampus I</h2>
                <text class="textj2">Jl. Raya Batujajar No.KM.2 No.90, Laksanamekar, Kec. Padalarang, Kabupaten Bandung
                    Barat, Jawa Barat 40553</text>
            </div>
            <div class="bg3">
                <div class="bg4">
                    <h2 class="textj3">Tentang Kami</h2>
                    <text class="textj4">Balai Besar Penjaminan Mutu Pendidikan (BBPMP) Provinsi Jawa Barat merupakan
                        unit pelaksana teknis Kementerian
                        <br> Pendidikan Dasar dan Menengah yang berada di dua lokasi Kampus 1 berlokasi di Padalarang
                        Kabupaten Bandung Barat <br>
                        Dan Kampus 2 Berlokasi di Jayagiri Lembang Kabupaten Bandung Barat</text>

                    <h2 class="textj5">Kontak</h2>
                    <span class="textj6">📞 (022) 686 6152</span>
                    <span class="textj7">📱 081 1117 1313</span>
                    <a class="btn3"
                        href="https://api.whatsapp.com/send/?phone=628111171313&text&type=phone_number&app_absent=0">
                        <span class="txtbnt3">Chat WhatsApp</span>
                    </a>

                    </button>
                    <span class="textj8">✉️ saprasbbpmpjbr@gmail.com</span>
                    <span class="textj9">📍 Lihat di Google Maps</span>

                    <div class="map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3429.8658355569937!2d107.49981267430825!3d-6.87763696729425!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e49561a2c469%3A0xdbb4904025ba391e!2sBalai%20Besar%20Penjaminan%20Mutu%20Pendidikan%20(BBPMP)%20Jawa%20Barat!5e1!3m2!1sid!2sid!4v1752717620468!5m2!1sid!2sid"
                            width="95%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function toggleProfile() {
                var card = document.getElementById("profileCard");
                card.style.display = (card.style.display === "block") ? "none" : "block";
            }

            window.onclick = function (event) {
                if (!event.target.matches('.profile-btn')) {
                    var card = document.getElementById("profileCard");
                    if (card && card.style.display === "block") {
                        card.style.display = "none";
                    }
                }
            }
        </script>
</body>

</html>