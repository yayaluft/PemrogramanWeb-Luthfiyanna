<?php
require_once __DIR__ . '/../includes/auth.php';

$page_title = "Tambah Penyewa";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Tambah Data Penyewa</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo e($flash['type'] ?? $flash['tipe'] ?? 'error'); ?>">
            <?php echo e($flash['pesan']); ?>
        </p>
    <?php endif; ?>

    <form id="form-tambah" action="proses_tambah.php" method="POST" novalidate>
        <!-- TAMBAHAN JOBSHEET 11: CSRF TOKEN -->
        <?= csrf_field(); ?>

        <p>
            <label for="id_penyewa">ID Penyewa</label>
            <input type="text" id="id_penyewa" name="id_penyewa" placeholder="Contoh: CUST-005">
        </p>

        <p>
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" placeholder="Masukkan nama penyewa">
        </p>

        <p>
            <label for="telepon">No. WhatsApp / HP</label>
            <input type="tel" id="telepon" name="telepon" placeholder="Contoh: 081234567890">
        </p>

        <p>
            <label for="status">Status Transaksi</label>
            <select id="status" name="status" style="width: 100%; padding: 0.6rem; border: 1px solid #ced4da; border-radius: 4px;">
                <option value="Aktif Menyewa">Aktif Menyewa</option>
                <option value="Selesai">Selesai</option>
            </select>
        </p>

        <div class="form-actions">
            <button type="submit">Simpan</button>
            <button type="reset" class="btn-reset">Batal</button>
        </div>
    </form>
</section>

<?php
include __DIR__ . '/../includes/footer.php';
?>