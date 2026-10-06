<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

$page_title = "Peminjaman Baru";
include __DIR__ . '/../includes/header.php';

$stmtAlat = $pdo->query("SELECT id, kode, nama FROM alat WHERE LOWER(status) = 'tersedia' ORDER BY nama ASC");
$listAlat = $stmtAlat->fetchAll(PDO::FETCH_ASSOC);

$stmtPenyewa = $pdo->query("SELECT id, id_penyewa, nama FROM penyewa ORDER BY nama ASC");
$listPenyewa = $stmtPenyewa->fetchAll(PDO::FETCH_ASSOC);

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Peminjaman Baru (Sewa Alat)</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?= e($flash['type'] ?? 'error'); ?>"><?= e($flash['pesan']); ?></p>
    <?php endif; ?>

    <form action="proses_tambah.php" method="POST">
        <?= csrf_field(); ?>

        <p>
            <label for="penyewa_id">Pilih Penyewa</label><br>
            <select name="penyewa_id" id="penyewa_id" required style="width: 100%; padding: 0.5rem;">
                <option value="">-- Pilih Penyewa --</option>
                <?php foreach ($listPenyewa as $p): ?>
                    <option value="<?= (int)$p['id']; ?>">[<?= e($p['id_penyewa']); ?>] <?= e($p['nama']); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="alat_id">Pilih Alat Kamera (Status Tersedia)</label><br>
            <select name="alat_id" id="alat_id" required style="width: 100%; padding: 0.5rem;">
                <option value="">-- Pilih Alat Tersedia --</option>
                <?php foreach ($listAlat as $a): ?>
                    <option value="<?= (int)$a['id']; ?>">[<?= e($a['kode']); ?>] <?= e($a['nama']); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="tanggal_pinjam">Tanggal Pinjam</label><br>
            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="<?= date('Y-m-d'); ?>" required style="width: 100%; padding: 0.5rem;">
        </p>

        <div class="form-actions">
            <button type="submit">Simpan Peminjaman</button>
            <a href="riwayat.php" class="btn-reset">Batal</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>