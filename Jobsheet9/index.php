<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

$totalAlat    = $pdo->query("SELECT COUNT(*) FROM alat")->fetchColumn();
$totalKamera  = $pdo->query("SELECT COUNT(*) FROM alat WHERE LOWER(kategori) = 'kamera'")->fetchColumn();
$totalDisewa  = $pdo->query("SELECT COUNT(*) FROM alat WHERE LOWER(status) = 'disewa'")->fetchColumn();
$totalTersedia = $pdo->query("SELECT COUNT(*) FROM alat WHERE LOWER(status) = 'tersedia'")->fetchColumn();

$stmtDisewa   = $pdo->query("SELECT * FROM alat WHERE LOWER(status) = 'disewa' ORDER BY id DESC");
$disewa_list  = $stmtDisewa->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="hero-banner">
    <h2>Selamat Datang di Panel RentCam</h2>
    <p>Kelola inventaris sewa kamera dan transaksi penyewa.</p>
    <div class="quick-links">
        <a href="alat/tambah.php">+ Tambah Alat</a>
        <a href="penyewa/tambah.php">+ Tambah Penyewa</a>
    </div>
</section>

<section class="dashboard-grid">
    <div class="stats-container">
        <article class="metric-card">
            <h3>Total Unit</h3>
            <p><?php echo $totalAlat; ?></p>
        </article>
        <article class="metric-card">
            <h3>Total Kamera</h3>
            <p><?php echo $totalKamera; ?></p>
        </article>
        <article class="metric-card">
            <h3>Sedang Disewa</h3>
            <p><?php echo $totalDisewa; ?></p>
        </article>
        <article class="metric-card">
            <h3>Unit Tersedia</h3>
            <p><?php echo $totalTersedia; ?></p>
        </article>
    </div>

    <article class="activity-card">
        <h3>Unit Sedang Dirental</h3>
        <ul class="activity-list">
            <?php if (empty($disewa_list)): ?>
                <li><span>Semua unit saat ini tersedia.</span></li>
            <?php else: ?>
                <?php foreach ($disewa_list as $item): ?>
                    <li>
                        <span><?php echo htmlspecialchars($item['nama']); ?></span>
                        <span class="status-tag"><?php echo htmlspecialchars($item['kode']); ?></span>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </article>
</section>

<?php
include __DIR__ . '/includes/footer.php';
?>