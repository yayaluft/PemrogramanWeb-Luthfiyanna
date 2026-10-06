<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

$page_title = "Pengembalian Alat";
include __DIR__ . '/../includes/header.php';

$sql = "SELECT p.id, p.tanggal_pinjam, 
               a.nama AS nama_alat, a.kode AS kode_alat,
               py.nama AS nama_penyewa, py.id_penyewa
        FROM peminjaman p
        JOIN alat a ON p.alat_id = a.id
        JOIN penyewa py ON p.penyewa_id = py.id
        WHERE p.status = 'dipinjam'
        ORDER BY p.id DESC";

$stmt = $pdo->query($sql);
$pinjamAktif = $stmt->fetchAll(PDO::FETCH_ASSOC);

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Daftar Pengembalian Alat (Aktif)</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?= e($flash['type'] ?? 'info'); ?>"><?= e($flash['pesan']); ?></p>
    <?php endif; ?>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Alat Kamera</th>
                    <th>Penyewa</th>
                    <th>Tanggal Pinjam</th>
                    <th>Durasi (Hari)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pinjamAktif)): ?>
                    <tr><td colspan="5" style="text-align: center;">Tidak ada alat yang sedang dipinjam saat ini.</td></tr>
                <?php else: ?>
                    <?php foreach ($pinjamAktif as $item): ?>
                        <?php 
                            $tglPinjam = new DateTime($item['tanggal_pinjam']);
                            $hariIni = new DateTime();
                            $durasi = $hariIni->diff($tglPinjam)->days;
                        ?>
                        <tr>
                            <td>[<?= e($item['kode_alat']); ?>] <?= e($item['nama_alat']); ?></td>
                            <td>[<?= e($item['id_penyewa']); ?>] <?= e($item['nama_penyewa']); ?></td>
                            <td><?= e($item['tanggal_pinjam']); ?></td>
                            <td><?= $durasi; ?> hari <?= $durasi > 14 ? '<strong style="color:red;">(Terlambat)</strong>' : ''; ?></td>
                            <td>
                                <form action="proses_kembali.php" method="POST" style="display:inline;">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="peminjaman_id" value="<?= (int)$item['id']; ?>">
                                    <button type="submit" class="btn-edit" onclick="return confirm('Proses pengembalian alat ini?')">Kembalikan</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>