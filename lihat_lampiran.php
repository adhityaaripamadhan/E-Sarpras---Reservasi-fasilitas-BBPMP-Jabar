<?php
session_start();
if (!isset($_SESSION['id'])) {
    die("Akses ditolak");
}

if (isset($_GET['file'])) {
    $file = basename($_GET['file']); 
    $filePath = __DIR__ . "/../ASSET/GALERIDB/" . $file;

    if (file_exists($filePath)) {
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        switch ($ext) {
            case "pdf":
                header("Content-Type: application/pdf");
                break;
            case "doc":
            case "docx":
                header("Content-Type: application/msword");
                break;
            case "jpg":
            case "jpeg":
            case "png":
                header("Content-Type: image/" . $ext);
                break;
            default:
                header("Content-Type: application/octet-stream");
        }

        header("Content-Disposition: inline; filename=\"$file\"");
        readfile($filePath);
        exit;
    } else {
        echo "File tidak ditemukan.";
    }
} else {
    echo "Lampiran tidak tersedia.";
}
?>
