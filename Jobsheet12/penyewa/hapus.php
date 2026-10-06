<?php
require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID penyewa tidak valid.'];
    header('Location: list.php');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM penyewa WHERE id = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() === 0) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data penyewa tidak ditemukan atau sudah dihapus.'];
    } else {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penyewa berhasil dihapus.'];
    }
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus data: ' . $e->getMessage()];
}

header('Location: list.php');
exit;