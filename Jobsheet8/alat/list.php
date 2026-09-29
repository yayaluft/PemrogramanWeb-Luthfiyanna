<?php
$page_title = "Daftar Alat";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarAlat = $pdo->query("SELECT * FROM alat ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<section>
    <h2>Daftar Unit &amp; Aksesoris</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type'] ?? $flash['tipe'] ?? 'info'); ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </p>
    <?php endif; ?>

    <div class="search-box">
        <label for="search-input">Cari Nama Alat</label>
        <input type="text" id="search-input" placeholder="Ketik nama alat...">
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
                <?php if (empty($daftarAlat)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Belum ada data alat. Silakan tambah lewat menu "Tambah Alat".</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarAlat as $alat): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($alat['kode']); ?></td>
                            <td><?php echo htmlspecialchars($alat['nama']); ?></td>
                            <td><?php echo htmlspecialchars($alat['kategori']); ?></td>
                            <td>Rp <?php echo number_format($alat['tarif'], 0, ',', '.'); ?></td>
                            <td>
                                <span class="badge-status <?php echo strtolower($alat['status']) === 'tersedia' ? 'badge-tersedia' : 'badge-disewa'; ?>">
                                    <?php echo htmlspecialchars($alat['status']); ?>
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