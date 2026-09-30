<?php
require_once __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$page_title = "Edit Penyewa";
include __DIR__ . '/../includes/header.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID penyewa tidak valid.'];
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM penyewa WHERE id = :id");
$stmt->execute(['id' => $id]);
$penyewa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$penyewa) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data penyewa tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Edit Data Penyewa</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type'] ?? $flash['tipe'] ?? 'error'); ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </p>
    <?php endif; ?>

    <form id="form-tambah" action="proses_edit.php" method="POST" novalidate>
        <input type="hidden" name="id" value="<?php echo (int) $penyewa['id']; ?>">

        <p>
            <label for="id_penyewa">ID Penyewa</label>
            <input type="text" id="id_penyewa" name="id_penyewa"
                value="<?php echo htmlspecialchars($penyewa['id_penyewa']); ?>">
        </p>

        <p>
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($penyewa['nama']); ?>">
        </p>

        <p>
            <label for="telepon">No. WhatsApp / HP</label>
            <input type="tel" id="telepon" name="telepon" value="<?php echo htmlspecialchars($penyewa['telepon']); ?>">
        </p>

        <p>
            <label for="status">Status Transaksi</label>
            <select id="status" name="status">
                <option value="Aktif Menyewa" <?php echo $penyewa['status'] === 'Aktif Menyewa' ? 'selected' : ''; ?>>
                    Aktif Menyewa</option>
                <option value="Selesai" <?php echo $penyewa['status'] === 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
            </select>
        </p>

        <div class="form-actions">
            <button type="submit">Simpan Perubahan</button>
            <a href="list.php" class="btn-reset"
                style="display: inline-block; padding: 0.6rem 1.6rem; background-color: #6c757d; color: #fff; border-radius: 4px; font-size: 0.95rem; font-weight: 600; text-decoration: none;">Batal</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>