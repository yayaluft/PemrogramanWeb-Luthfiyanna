<?php
$page_title = "Daftar Penyewa";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$halaman = max(1, (int)($_GET['halaman'] ?? 1));
$batas = 10;

$totalData = (int)$pdo->query("SELECT COUNT(*) FROM penyewa")->fetchColumn();
$totalHalaman = max(1, (int)ceil($totalData / $batas));

if ($halaman > $totalHalaman) {
    $halaman = $totalHalaman;
}

$offset = ($halaman - 1) * $batas;

$stmt = $pdo->prepare(
    "SELECT * FROM penyewa
     ORDER BY id DESC
     LIMIT :batas OFFSET :offset"
);
$stmt->bindValue(':batas', $batas, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarPenyewa = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section>
    <h2>Daftar Penyewa</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type'] ?? $flash['tipe'] ?? 'info'); ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </p>
    <?php endif; ?>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID Penyewa</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Status Transaksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarPenyewa)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada data penyewa. Silakan tambah lewat menu "Tambah Penyewa".</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarPenyewa as $penyewa): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($penyewa['id_penyewa']); ?></td>
                            <td><?php echo htmlspecialchars($penyewa['nama']); ?></td>
                            <td><?php echo htmlspecialchars($penyewa['telepon']); ?></td>
                            <td>
                                <?php $isAktif = stripos($penyewa['status'], 'aktif') !== false; ?>
                                <span class="badge-status <?php echo $isAktif ? 'badge-disewa' : 'badge-tersedia'; ?>">
                                    <?php echo htmlspecialchars($penyewa['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit.php?id=<?php echo (int)$penyewa['id']; ?>" class="btn-edit">Edit</a>
                                <form action="hapus.php" method="POST" class="form-hapus" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo (int)$penyewa['id']; ?>">
                                    <button type="submit" class="btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalHalaman > 1): ?>
        <div class="pagination" style="margin-top: 1rem;">
            <?php if ($halaman > 1): ?>
                <a href="?halaman=<?php echo $halaman - 1; ?>">Sebelumnya</a>
            <?php endif; ?>

            <span>Halaman <?php echo $halaman; ?> dari <?php echo $totalHalaman; ?></span>

            <?php if ($halaman < $totalHalaman): ?>
                <a href="?halaman=<?php echo $halaman + 1; ?>">Berikutnya</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>

<?php
include __DIR__ . '/../includes/footer.php';
?>