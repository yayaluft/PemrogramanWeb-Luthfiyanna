<?php
$page_title = "Daftar Penyewa";
include __DIR__ . '/../includes/header.php';

// Inisialisasi awal ke $_SESSION jika data penyewa masih kosong
if (!isset($_SESSION['penyewa'])) {
    $_SESSION['penyewa'] = [
        ["id" => "CUST-001", "nama" => "Bagas Pratama", "telepon" => "081234567890", "status" => "Aktif Menyewa"],
        ["id" => "CUST-002", "nama" => "Nabila Azzahra", "telepon" => "085712345678", "status" => "Aktif Menyewa"],
        ["id" => "CUST-003", "nama" => "Rizky Pratama", "telepon" => "087890123456", "status" => "Selesai"],
        ["id" => "CUST-004", "nama" => "Fajar Ramadhan", "telepon" => "089612345678", "status" => "Aktif Menyewa"],
    ];
}
?>

<section>
    <h2>Daftar Penyewa</h2>

    <div class="table-toolbar">
        <a href="tambah.php" class="btn-add">+ Tambah Penyewa</a>
        <div class="filter-group">
            <input type="text" id="search-input" class="search-input" placeholder="Ketik untuk mencari penyewa...">
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID Penyewa</th>
                    <th>Nama Lengkap</th>
                    <th>No. WhatsApp / HP</th>
                    <th>Status Transaksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($_SESSION['penyewa'])): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada data penyewa yang tersimpan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($_SESSION['penyewa'] as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['id']); ?></td>
                            <td><?php echo htmlspecialchars($item['nama']); ?></td>
                            <td><?php echo htmlspecialchars($item['telepon']); ?></td>
                            <td>
                                <?php 
                                $isAktif = stripos($item['status'], 'aktif') !== false;
                                ?>
                                <span class="badge-status <?php echo $isAktif ? 'badge-disewa' : 'badge-tersedia'; ?>">
                                    <?php echo htmlspecialchars($item['status']); ?>
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn-edit">Edit</button>
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