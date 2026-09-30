<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hitung path relatif otomatis ke root folder proyek
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

                <?php if (isset($_SESSION['user'])): ?>
                    <li style="border-top: 1px solid rgba(255,255,255,0.15); padding-top: 0.5rem; margin-top: 0.5rem;">
                        <span style="color: #f3d5dc; font-size: 0.85rem; display: block; margin-bottom: 0.3rem;">
                            Halo, <?php echo htmlspecialchars($_SESSION['user']['nama_lengkap']); ?>
                        </span>
                        <a href="<?php echo $base; ?>logout.php" style="display: inline-block; background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255,255,255,0.3); color: #fff; padding: 0.4rem 0.9rem; border-radius: 6px; font-size: 0.85rem; text-decoration: none;">
                            Keluar
                        </a>
                    </li>
                <?php else: ?>
                    <li style="border-top: 1px solid rgba(255,255,255,0.15); padding-top: 0.5rem; margin-top: 0.5rem;">
                        <a href="<?php echo $base; ?>login.php" style="display: inline-block; background: #ffffff; color: #4a1e2f; font-weight: 600; padding: 0.45rem 1.1rem; border-radius: 6px; text-decoration: none; font-size: 0.85rem;">
                            Masuk
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <?php if (!empty($_SESSION['flash'])): ?>
            <?php 
                $flashType = $_SESSION['flash']['type'] ?? $_SESSION['flash']['tipe'] ?? 'info';
                $flashPesan = $_SESSION['flash']['pesan'] ?? '';
            ?>
            <div class="flash flash-<?php echo htmlspecialchars((string)$flashType); ?>">
                <?php echo htmlspecialchars((string)$flashPesan); ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>