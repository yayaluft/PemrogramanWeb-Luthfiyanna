<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) && !isset($_SESSION['user'])) {
    $__jobsheetRoot = dirname(__DIR__);
    $__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
    $__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
    $base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);

    $_SESSION['flash'] = [
        'tipe'  => 'gagal',
        'pesan' => 'Silakan login terlebih dahulu untuk mengakses halaman tersebut.'
    ];

    header("Location: " . $base . "auth/login.php");
    exit;
}