<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/csrf.php';

csrf_verify();

$alat_id        = filter_input(INPUT_POST, 'alat_id', FILTER_VALIDATE_INT);
$penyewa_id     = filter_input(INPUT_POST, 'penyewa_id', FILTER_VALIDATE_INT);
$tanggal_pinjam = trim($_POST['tanggal_pinjam'] ?? date('Y-m-d'));

if (!$alat_id || !$penyewa_id) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Pilih alat dan penyewa yang valid.'];
    header('Location: tambah.php');
    exit;
}

try {
    $stmtCekTerlambat = $pdo->prepare(
        "SELECT COUNT(*) FROM peminjaman 
         WHERE penyewa_id = :penyewa_id 
           AND status = 'dipinjam' 
           AND (CURRENT_DATE - tanggal_pinjam) > 14"
    );
    $stmtCekTerlambat->execute(['penyewa_id' => $penyewa_id]);
    if ($stmtCekTerlambat->fetchColumn() > 0) {
        $_SESSION['flash'] = [
            'type'  => 'error',
            'pesan' => 'Peminjaman ditolak! Penyewa memiliki transaksi terlambat lebih dari 14 hari yang belum dikembalikan.'
        ];
        header('Location: tambah.php');
        exit;
    }

    $pdo->beginTransaction();

    $stmtCekAlat = $pdo->prepare("SELECT status FROM alat WHERE id = :id FOR UPDATE");
    $stmtCekAlat->execute(['id' => $alat_id]);
    $alat = $stmtCekAlat->fetch(PDO::FETCH_ASSOC);

    if (!$alat || strtolower($alat['status']) !== 'tersedia') {
        $pdo->rollBack();
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Alat tidak tersedia atau baru saja disewa pengguna lain.'];
        header('Location: tambah.php');
        exit;
    }

    $stmtInsert = $pdo->prepare(
        "INSERT INTO peminjaman (alat_id, penyewa_id, tanggal_pinjam, status) 
         VALUES (:alat_id, :penyewa_id, :tanggal_pinjam, 'dipinjam')"
    );
    $stmtInsert->execute([
        'alat_id'        => $alat_id,
        'penyewa_id'     => $penyewa_id,
        'tanggal_pinjam' => $tanggal_pinjam
    ]);

    $stmtUpdate = $pdo->prepare("UPDATE alat SET status = 'disewa' WHERE id = :id");
    $stmtUpdate->execute(['id' => $alat_id]);

    $pdo->commit();

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Peminjaman alat berhasil diproses.'];
    header('Location: kembali.php');
    exit;

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memproses transaksi: ' . $e->getMessage()];
    header('Location: tambah.php');
    exit;
}