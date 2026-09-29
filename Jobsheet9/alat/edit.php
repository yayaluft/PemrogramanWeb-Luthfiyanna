<?php
$page_title = "Edit Alat";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID alat tidak valid.'];
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM alat WHERE id = :id");
$stmt->execute(['id' => $id]);
$alat = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$alat) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data alat tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Edit Data Alat</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type'] ?? $flash['tipe'] ?? 'error'); ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </p>
    <?php endif; ?>

    <form id="form-tambah" action="proses_edit.php" method="POST" novalidate>
        <input type="hidden" name="id" value="<?php echo (int)$alat['id']; ?>">

        <p>
            <label for="kode">Kode Alat</label>
            <input type="text" id="kode" name="kode" value="<?php echo htmlspecialchars($alat['kode']); ?>">
        </p>

        <p>
            <label for="nama">Nama Perangkat</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($alat['nama']); ?>">
        </p>

        <p>
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori">
                <option value="Kamera" <?php echo $alat['kategori'] === 'Kamera' ? 'selected' : ''; ?>>Kamera</option>
                <option value="Lensa" <?php echo $alat['kategori'] === 'Lensa' ? 'selected' : ''; ?>>Lensa</option>
                <option value="Aksesoris" <?php echo $alat['kategori'] === 'Aksesoris' ? 'selected' : ''; ?>>Aksesoris</option>
            </select>
        </p>

        <p>
            <label for="tarif">Tarif / Hari (Rp)</label>
            <input type="number" id="tarif" name="tarif" value="<?php echo htmlspecialchars($alat['tarif']); ?>">
        </p>

        <p>
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="Tersedia" <?php echo $alat['status'] === 'Tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                <option value="Disewa" <?php echo $alat['status'] === 'Disewa' ? 'selected' : ''; ?>>Disewa</option>
            </select>
        </p>

        <div class="form-actions">
            <button type="submit">Simpan Perubahan</button>
            <a href="list.php" class="btn-reset">Batal</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>