<?php
$page_title = "Daftar Penyewa";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarPenyewa = $pdo->query("SELECT * FROM penyewa ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<section>
    <h2>Daftar Penyewa</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type'] ?? $flash['tipe'] ?? 'info'); ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </p>
    <?php endif; ?>

    <div class="search-box">
        <label for="search-input">Cari Nama Penyewa</label>
        <input type="text" id="search-input" placeholder="Ketik nama penyewa...">
    </div>

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
                                <?php
                                $isAktif = stripos($penyewa['status'], 'aktif') !== false;
                                ?>
                                <span class="badge-status <?php echo $isAktif ? 'badge-disewa' : 'badge-tersedia'; ?>">
                                    <?php echo htmlspecialchars($penyewa['status']); ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn-edit" type="button">Edit</button>
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