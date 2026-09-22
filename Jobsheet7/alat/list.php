<?php
$page_title = "Daftar Alat";
include __DIR__ . '/../includes/header.php';

// Inisialisasi awal ke $_SESSION jika data alat masih kosong
if (!isset($_SESSION['alat'])) {
    $_SESSION['alat'] = [
        ["kode" => "CAM-01", "nama" => "Sony Alpha a7 IV Body", "kategori" => "Kamera", "tarif" => 350000, "status" => "Disewa"],
        ["kode" => "ACC-01", "nama" => "Lensa Sony FE 24-70mm f/2.8 GM", "kategori" => "Aksesoris", "tarif" => 180000, "status" => "Disewa"],
        ["kode" => "CAM-02", "nama" => "Fujifilm X-T5 Body", "kategori" => "Kamera", "tarif" => 275000, "status" => "Tersedia"],
        ["kode" => "ACC-02", "nama" => "Gimbal Stabilizer DJI Ronin-SC", "kategori" => "Aksesoris", "tarif" => 120000, "status" => "Tersedia"],
    ];
}
?>

<section>
    <h2>Daftar Unit &amp; Aksesoris</h2>

    <div class="table-toolbar">
        <a href="tambah.php" class="btn-add">+ Tambah Alat</a>
        <div class="filter-group">
            <input type="text" id="search-input" class="search-input" placeholder="Ketik untuk mencari...">
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Perangkat</th>
                    <th>Kategori</th>
                    <th>Tarif / Hari</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($_SESSION['alat'])): ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Tidak ada data unit/alat yang tersimpan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($_SESSION['alat'] as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['kode']); ?></td>
                            <td><?php echo htmlspecialchars($item['nama']); ?></td>
                            <td><?php echo htmlspecialchars($item['kategori']); ?></td>
                            <td>Rp <?php echo number_format($item['tarif'], 0, ',', '.'); ?></td>
                            <td>
                                <span class="badge-status <?php echo strtolower($item['status']) === 'tersedia' ? 'badge-tersedia' : 'badge-disewa'; ?>">
                                    <?php echo htmlspecialchars($item['status']); ?>
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn-edit">Edit</button>
                                <button type="button" class="btn-hapus">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php
include __DIR__ . '/../includes/footer.php';
?>