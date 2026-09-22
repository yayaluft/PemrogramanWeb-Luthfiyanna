<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';

// Inisialisasi awal ke $_SESSION jika data alat belum ada
if (!isset($_SESSION['alat'])) {
    $_SESSION['alat'] = [
        ["kode" => "CAM-01", "nama" => "Sony Alpha a7 IV Body", "kategori" => "Kamera", "tarif" => 350000, "status" => "Disewa"],
        ["kode" => "ACC-01", "nama" => "Lensa Sony FE 24-70mm f/2.8 GM", "kategori" => "Aksesoris", "tarif" => 180000, "status" => "Disewa"],
        ["kode" => "CAM-02", "nama" => "Fujifilm X-T5 Body", "kategori" => "Kamera", "tarif" => 275000, "status" => "Tersedia"],
        ["kode" => "ACC-02", "nama" => "Gimbal Stabilizer DJI Ronin-SC", "kategori" => "Aksesoris", "tarif" => 120000, "status" => "Tersedia"],
    ];
}

$total_alat = count($_SESSION['alat']);
$disewa_list = array_filter($_SESSION['alat'], function($item) {
    return strtolower($item['status']) === 'disewa';
});
$disewa = count($disewa_list);
$tersedia = $total_alat - $disewa;
?>

<section class="hero-banner">
    <h2>Selamat Datang di Panel RentCam</h2>
    <p>Kelola inventaris sewa kamera dan transaksi penyewa berbasis PHP Dasar.</p>
    <div class="quick-links">
        <a href="alat/tambah.php">+ Tambah Alat</a>
        <a href="penyewa/tambah.php">+ Tambah Penyewa</a>
    </div>
</section>

<section class="dashboard-grid">
    <div class="stats-container">
        <article class="metric-card">
            <h3>Total Unit</h3>
            <p><?php echo $total_alat; ?></p>
        </article>
        <article class="metric-card">
            <h3>Total Kamera</h3>
            <p><?php echo count(array_filter($_SESSION['alat'], fn($i) => strtolower($i['kategori']) === 'kamera')); ?></p>
        </article>
        <article class="metric-card">
            <h3>Sedang Disewa</h3>
            <p><?php echo $disewa; ?></p>
        </article>
        <article class="metric-card">
            <h3>Unit Tersedia</h3>
            <p><?php echo $tersedia; ?></p>
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