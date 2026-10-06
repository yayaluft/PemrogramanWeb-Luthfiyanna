<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/csrf.php';

csrf_verify();

$peminjaman_id = filter_input(INPUT_POST, 'peminjaman_id', FILTER_VALIDATE_INT);

if (!$peminjaman_id) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID peminjaman tidak valid.'];
    header('Location: kembali.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $stmtCek = $pdo->prepare("SELECT alat_id, status FROM peminjaman WHERE id = :id FOR UPDATE");
    $stmtCek->execute(['id' => $peminjaman_id]);
    $pinjam = $stmtCek->fetch(PDO::FETCH_ASSOC);

    if (!$pinjam || $pinjam['status'] === 'dikembalikan') {
        $pdo->rollBack();
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data peminjaman tidak ditemukan atau sudah dikembalikan.'];
        header('Location: kembali.php');
        exit;
    }

    $stmtUpdatePinjam = $pdo->prepare(
        "UPDATE peminjaman SET status = 'dikembalikan', tanggal_kembali = CURRENT_DATE WHERE id = :id"
    );
    $stmtUpdatePinjam->execute(['id' => $peminjaman_id]);

    $stmtUpdateAlat = $pdo->prepare("UPDATE alat SET status = 'tersedia' WHERE id = :id");
    $stmtUpdateAlat->execute(['id' => $pinjam['alat_id']]);

    $pdo->commit();

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Alat berhasil dikembalikan dan status diperbarui menjadi tersedia.'];
    header('Location: kembali.php');
    exit;

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memproses pengembalian: ' . $e->getMessage()];
    header('Location: kembali.php');
    exit;
}