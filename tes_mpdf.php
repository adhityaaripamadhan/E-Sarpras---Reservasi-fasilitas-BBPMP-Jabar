<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mpdfPath = __DIR__ . '/mpdf/src';
$fpdiPath = __DIR__ . '/fpdi/src';
$psrPath  = __DIR__ . '/psr/Log';

// include file inti mPDF
require_once $mpdfPath . '/Config/ConfigVariables.php';
require_once $mpdfPath . '/Config/FontVariables.php';

// autoload manual untuk mPDF, FPDI, dan PSR-Log
spl_autoload_register(function ($class) use ($mpdfPath, $fpdiPath, $psrPath) {
    $prefixes = [
        'Mpdf\\'         => $mpdfPath . '/',
        'setasign\\Fpdi\\' => $fpdiPath . '/',
        'Psr\\Log\\'     => $psrPath . '/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) continue;

        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// pastikan Strict.php manual di-include kalau belum ke-load
if (!class_exists('Mpdf\\Strict') && file_exists($mpdfPath . '/Strict.php')) {
    require_once $mpdfPath . '/Strict.php';
}

try {
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML('<h1 style="text-align:center;color:green;">✅ mPDF Berhasil Lengkap!</h1>');
    $mpdf->Output();
} catch (Throwable $e) {
    echo '<pre style="color:red;">⚠️ Error: ' . $e->getMessage() . '</pre>';
}
?>
