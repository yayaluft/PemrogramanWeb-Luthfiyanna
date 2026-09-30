<?php
$page_title = "Daftar Alat";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$keyword = trim($_GET['keyword'] ?? '');
$halaman = max(1, (int)($_GET['halaman'] ?? 1));
$batas = 10;

if ($keyword !== '') {
    $stmtCount = $pdo->prepare("SELECT COUNT(*) FROM alat WHERE nama ILIKE :keyword");
    $stmtCount->execute(['keyword' => '%' . $keyword . '%']);
    $totalData = (int)$stmtCount->fetchColumn();
} else {
    $totalData = (int)$pdo->query("SELECT COUNT(*) FROM alat")->fetchColumn();
}

$totalHalaman = max(1, (int)ceil($totalData / $batas));
$halaman = min($halaman, $totalHalaman);
$offset = ($halaman - 1) * $batas;

if ($keyword !== '') {
    $stmt = $pdo->prepare(
        "SELECT * FROM alat
         WHERE nama ILIKE :keyword
         ORDER BY id DESC
         LIMIT :batas OFFSET :offset"
    );
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
} else {
    $stmt = $pdo->prepare(
        "SELECT * FROM alat
         ORDER BY id DESC
         LIMIT :batas OFFSET :offset"
    );
}

$stmt->bindValue(':batas', $batas, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarAlat = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section>
    <h2>Daftar Unit &amp; Aksesoris</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type'] ?? $flash['tipe'] ?? 'info'); ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </p>
    <?php endif; ?>

    <form class="search-box" method="GET" action="list.php">
        <label for="search-input">Cari Nama Alat</label>
        <input type="text" id="search-input" name="keyword"
               value="<?php echo htmlspecialchars($keyword); ?>"
               placeholder="Ketik nama alat...">
        <button type="submit">Cari</button>
        <?php if ($keyword !== ''): ?>
            <a href="list.php">Reset</a>
        <?php endif; ?>
    </form>

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
                        <td colspan="6" style="text-align: center;">
                            <?php echo $keyword !== '' ? 'Data alat tidak ditemukan.' : 'Belum ada data alat. Silakan tambah lewat menu "Tambah Alat".'; ?>
                        </td>
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
                                <a href="edit.php?id=<?php echo (int)$alat['id']; ?>" class="btn-edit">Edit</a>
                                <form action="hapus.php" method="POST" class="form-hapus" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo (int)$alat['id']; ?>">
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
                <a href="?halaman=<?php echo $halaman - 1; ?>&keyword=<?php echo urlencode($keyword); ?>">Sebelumnya</a>
            <?php endif; ?>

            <span>Halaman <?php echo $halaman; ?> dari <?php echo $totalHalaman; ?></span>

            <?php if ($halaman < $totalHalaman): ?>
                <a href="?halaman=<?php echo $halaman + 1; ?>&keyword=<?php echo urlencode($keyword); ?>">Berikutnya</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>

<?php
include __DIR__ . '/../includes/footer.php';
?>