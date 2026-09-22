<?php
session_start();

// Prefix relatif ke root proyek otomatis dari modul dosen
$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RentCam<?php echo isset($page_title) ? ' | ' . $page_title : ''; ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>
    <header>
        <h1>RentCam</h1>
        <button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
        <nav>
            <ul>
                <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
                <li><a href="<?php echo $base; ?>alat/list.php">Daftar Alat</a></li>
                <li><a href="<?php echo $base; ?>alat/tambah.php">Tambah Alat</a></li>
                <li><a href="<?php echo $base; ?>penyewa/list.php">Daftar Penyewa</a></li>
                <li><a href="<?php echo $base; ?>penyewa/tambah.php">Tambah Penyewa</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="flash flash-<?php echo htmlspecialchars($_SESSION['flash']['tipe']); ?>">
                <?php echo htmlspecialchars($_SESSION['flash']['pesan']); ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>