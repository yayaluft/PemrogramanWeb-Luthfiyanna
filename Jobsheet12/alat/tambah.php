<?php
require_once __DIR__ . '/../includes/auth.php';

$page_title = "Tambah Alat";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Tambah Data Alat</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo e($flash['type'] ?? $flash['tipe'] ?? 'error'); ?>">
            <?php echo e($flash['pesan']); ?>
        </p>
    <?php endif; ?>

    <form id="form-tambah" action="proses_tambah.php" method="POST" novalidate>
        <!-- TAMBAHAN JOBSHEET 11: CSRF TOKEN -->
        <?= csrf_field(); ?>

        <p>
            <label for="kode">Kode Alat</label>
            <input type="text" id="kode" name="kode" placeholder="Contoh: CAM-03">
        </p>

        <p>
            <label for="nama">Nama Perangkat</label>
            <input type="text" id="nama" name="nama" placeholder="Contoh: Canon EOS R6 Mark II">
        </p>

        <p>
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" style="width: 100%; padding: 0.6rem; border: 1px solid #ced4da; border-radius: 4px;">
                <option value="Kamera">Kamera</option>
                <option value="Lensa">Lensa</option>
                <option value="Aksesoris">Aksesoris</option>
            </select>
        </p>

        <p>
            <label for="tarif">Tarif / Hari (Rp)</label>
            <input type="number" id="tarif" name="tarif" placeholder="Contoh: 380000">
        </p>

        <p>
            <label for="status">Status Awal</label>
            <select id="status" name="status" style="width: 100%; padding: 0.6rem; border: 1px solid #ced4da; border-radius: 4px;">
                <option value="Tersedia">Tersedia</option>
                <option value="Disewa">Disewa</option>
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