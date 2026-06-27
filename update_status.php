<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'koneksi.php';

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// FPDF
require 'fpdf/fpdf.php';

// --- Fungsi ubah tanggal ke format Indonesia ---
function tanggal_indo($tanggal)
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    $pecah = explode('-', $tanggal);
    return intval($pecah[2]) . ' ' . $bulan[(int) $pecah[1]] . ' ' . $pecah[0];
}

// --- Header Template ---
function header_pdf($pdf)
{
    if (file_exists('ASSET/logo bbpmp baru.png')) {
        $pdf->Image('ASSET/logo bbpmp baru.png', 25, 20, 25);
    }

    $pdf->SetXY(55, 20);
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(0, 6, 'Balai Besar Penjaminan Mutu Pendidikan Jawa Barat', 0, 1, 'L');

    $pdf->SetFont('Arial', '', 9);
    $pdf->SetX(55);
    $pdf->MultiCell(
        0,
        5,
        "Jl. Raya Batujajar No.KM.2 No.90, Laksanamekar, Kec. Padalarang, Kabupaten Bandung Barat, Jawa Barat 40553\n" .
        "Telepon: (022) 686 6152 | Email: saprasbbpmpjbr@gmail.com",
        0,
        'L'
    );

    $pdf->Ln(8);
    $pdf->Line(25, $pdf->GetY(), 185, $pdf->GetY());
    $pdf->Ln(12);
}

// --- Surat Persetujuan ---
function create_pdf_persetujuan($data, $pdf_path)
{
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetMargins(25, 20, 25);
    $pdf->SetAutoPageBreak(true, 20);

    header_pdf($pdf);

    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 6, "Perihal: Persetujuan Reservasi Fasilitas", 0, 1, 'L');
    $pdf->Ln(8);
    $pdf->MultiCell(0, 6, "Kepada Yth.:\n{$data['Nama']}\n{$data['Instansi']}\nDi Tempat", 0, 'L');
    $pdf->Ln(6);

    $tglAwal = tanggal_indo($data['TanggalAwal']);
    $tglAkhir = tanggal_indo($data['TanggalAkhir']);

    $body = "Dengan hormat,\n\n" .
        "Menindaklanjuti permohonan reservasi fasilitas untuk kegiatan \"{$data['NamaKegiatan']}\" " .
        "yang akan dilaksanakan pada tanggal {$tglAwal} s.d. {$tglAkhir} pukul {$data['WaktuAwal']} - {$data['WaktuAkhir']} " .
        "bertempat di ruang {$data['Ruangan']}, dengan ini kami menyampaikan bahwa permohonan tersebut telah Disetujui.\n\n" .
        "Demikian surat persetujuan ini kami sampaikan. Harap membawa dokumen ini sebagai bukti resmi pada saat penggunaan fasilitas.\n\n" .
        "Atas perhatian dan kerja samanya kami ucapkan terima kasih.";

    $pdf->MultiCell(0, 6, $body, 0, 'J');
    $pdf->Ln(10);

    $pdf->Cell(0, 6, "Bandung, " . tanggal_indo(date('Y-m-d')), 0, 1, 'R');
    $pdf->Ln(8);
    $pdf->Cell(0, 6, "Hormat kami,", 0, 1, 'L');
    $pdf->Cell(0, 6, "BBPMP Jawa Barat", 0, 1, 'L');

    $pdf->Output('F', $pdf_path);
}

// --- Surat Penolakan ---
function create_pdf_penolakan($data, $pdf_path)
{
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetMargins(25, 20, 25);
    $pdf->SetAutoPageBreak(true, 20);

    header_pdf($pdf);

    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 6, "Perihal: Penolakan Reservasi Fasilitas", 0, 1, 'L');
    $pdf->Ln(8);
    $pdf->MultiCell(0, 6, "Kepada Yth.:\n{$data['Nama']}\n{$data['Instansi']}\nDi Tempat", 0, 'L');
    $pdf->Ln(6);

    $tglAwal = tanggal_indo($data['TanggalAwal']);
    $tglAkhir = tanggal_indo($data['TanggalAkhir']);

    $body = "Dengan hormat,\n\n" .
        "Menindaklanjuti permohonan reservasi fasilitas untuk kegiatan \"{$data['NamaKegiatan']}\" " .
        "yang akan dilaksanakan pada tanggal {$tglAwal} s.d. {$tglAkhir} pukul {$data['WaktuAwal']} - {$data['WaktuAkhir']} " .
        "bertempat di ruang {$data['Ruangan']}, dengan ini kami sampaikan bahwa permohonan tersebut Tidak dapat kami fasilitasi " .
        "karena pada tanggal tersebut sedang digunakan untuk kegiatan internal BBPMP Jawa Barat.\n\n" .
        "Apabila Bapak/Ibu ingin mengajukan jadwal lain, silakan melakukan pengajuan ulang melalui sistem reservasi E-Sarpras BBPMP Jawa Barat.\n\n" .
        "Atas pengertian dan kerja samanya, kami ucapkan terima kasih.";

    $pdf->MultiCell(0, 6, $body, 0, 'J');
    $pdf->Ln(10);

    $pdf->Cell(0, 6, "Bandung, " . tanggal_indo(date('Y-m-d')), 0, 1, 'R');
    $pdf->Ln(8);
    $pdf->Cell(0, 6, "Hormat kami,", 0, 1, 'L');
    $pdf->Cell(0, 6, "BBPMP Jawa Barat", 0, 1, 'L');

    $pdf->Output('F', $pdf_path);
}

// === Proses utama ===
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $koneksi->real_escape_string($_POST['id']);
    $status = $koneksi->real_escape_string($_POST['status']);

    $update = mysqli_query($koneksi, "UPDATE reservasi SET status='$status' WHERE id='$id'");

    // Normalisasi tanggal
    if ($status === 'disetujui') {
        $cekTanggal = mysqli_query($koneksi, "SELECT TanggalAwal, TanggalAkhir FROM reservasi WHERE id='$id'");
        if ($cekTanggal && mysqli_num_rows($cekTanggal) > 0) {
            $row = mysqli_fetch_assoc($cekTanggal);
            $tglAwal = date('Y-m-d', strtotime($row['TanggalAwal']));
            $tglAkhir = date('Y-m-d', strtotime($row['TanggalAkhir']));
            mysqli_query($koneksi, "
                UPDATE reservasi 
                SET TanggalAwal='$tglAwal', TanggalAkhir='$tglAkhir'
                WHERE id='$id'
            ");
        }
    }

    // Kalender
    if ($status === 'disetujui') {
        $cek = $koneksi->query("SELECT * FROM kalender WHERE reservasi_id='$id'");
        if ($cek->num_rows == 0) {
            $data_res = $koneksi->query("SELECT * FROM reservasi WHERE id='$id'")->fetch_assoc();
            if ($data_res) {
                $koneksi->query("
                    INSERT INTO kalender (reservasi_id, nama_kegiatan, ruangan, tanggal_awal, tanggal_akhir, waktu_awal, waktu_akhir, keterangan)
                    VALUES (
                        '$id',
                        '{$data_res['NamaKegiatan']}',
                        '{$data_res['Ruangan']}',
                        '{$data_res['TanggalAwal']}',
                        '{$data_res['TanggalAkhir']}',
                        '{$data_res['WaktuAwal']}',
                        '{$data_res['WaktuAkhir']}',
                        'Reservasi Disetujui'
                    )
                ");
            }
        }
    } else {
        $koneksi->query("DELETE FROM kalender WHERE reservasi_id='$id'");
    }

    $q = $koneksi->query("SELECT * FROM reservasi WHERE id='$id'");
    $r = $q->fetch_assoc();
    if (!$r)
        die('Reservasi tidak ditemukan.');

   // === TAMBAHKAN NOTIFIKASI ===
$email = $r['Email'];
$getAkun = $koneksi->query("SELECT id FROM akun WHERE email='$email' LIMIT 1");

if ($getAkun && $getAkun->num_rows > 0) {
    $akun = $getAkun->fetch_assoc();
    $id_user = $akun['id'];

    // Tentukan isi pesan
    if ($status === 'disetujui') {
        $pesan = "Reservasi untuk kegiatan '{$r['NamaKegiatan']}' di ruang {$r['Ruangan']} telah <b>disetujui</b>.";
    } elseif ($status === 'ditolak') {
        $pesan = "Mohon maaf, reservasi untuk kegiatan '{$r['NamaKegiatan']}' di ruang {$r['Ruangan']} <b>belum dapat difasilitasi</b>.";
    } else {
        $pesan = null;
    }

    // Insert notifikasi jika pesan ada
    if (!empty($pesan)) {
        $stmt = $koneksi->prepare("INSERT INTO notifikasi (user_id, pesan, tanggal, status) VALUES (?, ?, NOW(), 'belum_dibaca')");
        $stmt->bind_param("is", $id_user, $pesan);
        $stmt->execute();
        $stmt->close();
    }
} else {
    error_log("Gagal menambahkan notifikasi: akun dengan email $email tidak ditemukan.");
}


    // === BUAT PDF & KIRIM EMAIL ===
    $data = [
        'Nama' => $r['Nama'],
        'NamaKegiatan' => $r['NamaKegiatan'],
        'Instansi' => $r['Namainstansi'],
        'Ruangan' => $r['Ruangan'],
        'TanggalAwal' => $r['TanggalAwal'],
        'TanggalAkhir' => $r['TanggalAkhir'],
        'WaktuAwal' => $r['WaktuAwal'],
        'WaktuAkhir' => $r['WaktuAkhir']
    ];

    $pdf_path = __DIR__ . "/surat_{$status}_{$id}.pdf";
    if ($status === 'disetujui')
        create_pdf_persetujuan($data, $pdf_path);
    else
        create_pdf_penolakan($data, $pdf_path);

    // Kirim email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'mail.bbpmpjabar.info';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@bbpmpjabar.info';
        $mail->Password = 'Bbpmpjabar@admin290';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('admin@bbpmpjabar.info', 'BBPMP Jawa Barat');
        $mail->addAddress($r['Email'], $r['Nama']);

        $judul = ($status === 'disetujui')
            ? 'Persetujuan Reservasi Fasilitas'
            : 'Penolakan Reservasi Fasilitas';

        $mail->isHTML(true);
        $mail->Subject = "$judul - BBPMP Jawa Barat";

        if ($status === 'disetujui') {
            $mail->addAttachment($pdf_path, 'Surat_Resmi_Reservasi.pdf');
            $mail->Body = "
                <h3>Halo {$r['Nama']},</h3>
                <p>Surat resmi persetujuan reservasi Anda telah dilampirkan.</p>
                <br><p>Hormat kami,<br><b>BBPMP Jawa Barat</b></p>
            ";
        } else {
            $mail->addAttachment($pdf_path, 'Surat_Penolakan_Reservasi.pdf');
            $mail->Body = "
                <h3>Halo {$r['Nama']},</h3>
                <p>Mohon maaf, pengajuan reservasi Anda belum dapat difasilitasi.</p>
                <br><p>Hormat kami,<br><b>BBPMP Jawa Barat</b></p>
            ";
        }

        $mail->send();
    } catch (Exception $e) {
        error_log("Gagal kirim email ke {$r['Email']}: {$mail->ErrorInfo}");
    } finally {
        if (file_exists($pdf_path))
            unlink($pdf_path);
    }

    header("Location: Dashboard2.php");
    exit;
}
?>