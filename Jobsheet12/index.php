<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

$totalAlat     = (int) $pdo->query("SELECT COUNT(*) FROM alat")->fetchColumn();
$totalPenyewa  = (int) $pdo->query("SELECT COUNT(*) FROM penyewa")->fetchColumn();
$sedangDipinjam= (int) $pdo->query("SELECT COUNT(*) FROM peminjaman WHERE LOWER(status) = 'dipinjam'")->fetchColumn();
$totalTersedia = (int) $pdo->query("SELECT COUNT(*) FROM alat WHERE LOWER(status) = 'tersedia'")->fetchColumn();

$stmtDipinjam  = $pdo->query(
    "SELECT p.id, a.nama, a.kode, py.nama as nama_penyewa 
     FROM peminjaman p 
     JOIN alat a ON p.alat_id = a.id 
     JOIN penyewa py ON p.penyewa_id = py.id 
     WHERE LOWER(p.status) = 'dipinjam' 
     ORDER BY p.id DESC"
);
$dipinjam_list = $stmtDipinjam->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="hero-banner">
    <h2>Selamat Datang di Panel RentCam</h2>
    <p>Kelola inventaris sewa kamera dan transaksi penyewa secara real-time.</p>
    
    <div class="quick-links">
        <a href="peminjaman/tambah.php">+ Sewa Alat Baru</a>
        <a href="peminjaman/kembali.php">Pengembalian Alat</a>
    </div>
</section>

<section class="dashboard-grid">
    <div class="stats-container">
        <article class="metric-card">
            <h3>Total Unit Alat</h3>
            <p><?= $totalAlat; ?></p>
        </article>
        <article class="metric-card">
            <h3>Total Penyewa</h3>
            <p><?= $totalPenyewa; ?></p>
        </article>
        <article class="metric-card">
            <h3>Sedang Dipinjam</h3>
            <p style="color: #d9534f; font-weight: bold;"><?= $sedangDipinjam; ?></p>
        </article>
        <article class="metric-card">
            <h3>Unit Tersedia</h3>
            <p style="color: #5cb85c; font-weight: bold;"><?= $totalTersedia; ?></p>
        </article>
    </div>

    <article class="activity-card">
        <h3>Unit Sedang Dirental Saat Ini</h3>
        <ul class="activity-list">
            <?php if (empty($dipinjam_list)): ?>
                <li><span>Semua unit saat ini tersedia di studio.</span></li>
            <?php else: ?>
                <?php foreach ($dipinjam_list as $item): ?>
                    <li>
                        <span>[<?= e($item['kode']); ?>] <strong><?= e($item['nama']); ?></strong> - Disewa oleh: <?= e($item['nama_penyewa']); ?></span>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </article>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>