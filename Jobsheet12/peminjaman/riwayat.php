<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

$page_title = "Riwayat Peminjaman";
include __DIR__ . '/../includes/header.php';

$penyewa_id = filter_input(INPUT_GET, 'penyewa_id', FILTER_VALIDATE_INT);

$sql = "SELECT p.id, p.tanggal_pinjam, p.tanggal_kembali, p.status,
               a.nama AS nama_alat, a.kode AS kode_alat,
               py.nama AS nama_penyewa, py.id_penyewa
        FROM peminjaman p
        JOIN alat a ON p.alat_id = a.id
        JOIN penyewa py ON p.penyewa_id = py.id";

if ($penyewa_id) {
    $sql .= " WHERE p.penyewa_id = :penyewa_id";
}
$sql .= " ORDER BY p.id DESC";

$stmt = $pdo->prepare($sql);
if ($penyewa_id) {
    $stmt->execute(['penyewa_id' => $penyewa_id]);
} else {
    $stmt->execute();
}
$riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);

$listPenyewa = $pdo->query("SELECT id, id_penyewa, nama FROM penyewa ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<section>
    <h2>Riwayat Peminjaman Alat</h2>

    <form method="GET" action="riwayat.php" class="search-box" style="margin-bottom: 1.5rem;">
        <label for="penyewa_id">Filter berdasarkan Penyewa:</label>
        <select name="penyewa_id" id="penyewa_id" style="padding: 0.4rem;">
            <option value="">-- Semua Penyewa --</option>
            <?php foreach ($listPenyewa as $p): ?>
                <option value="<?= (int)$p['id']; ?>" <?= $penyewa_id === (int)$p['id'] ? 'selected' : ''; ?>>
                    [<?= e($p['id_penyewa']); ?>] <?= e($p['nama']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filter</button>
        <?php if ($penyewa_id): ?>
            <a href="riwayat.php">Reset</a>
        <?php endif; ?>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Alat Kamera</th>
                    <th>Penyewa</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($riwayat)): ?>
                    <tr><td colspan="5" style="text-align: center;">Belum ada histori peminjaman.</td></tr>
                <?php else: ?>
                    <?php foreach ($riwayat as $r): ?>
                        <tr>
                            <td>[<?= e($r['kode_alat']); ?>] <?= e($r['nama_alat']); ?></td>
                            <td>[<?= e($r['id_penyewa']); ?>] <?= e($r['nama_penyewa']); ?></td>
                            <td><?= e($r['tanggal_pinjam']); ?></td>
                            <td><?= e($r['tanggal_kembali'] ?? '-'); ?></td>
                            <td>
                                <span class="badge-status <?= strtolower($r['status']) === 'dipinjam' ? 'badge-disewa' : 'badge-tersedia'; ?>">
                                    <?= e($r['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>