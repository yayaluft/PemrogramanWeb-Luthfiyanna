<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'ID alat tidak valid.'];
    header('Location: list.php');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM alat WHERE id = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() === 0) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data alat tidak ditemukan atau sudah dihapus.'];
    } else {
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data alat berhasil dihapus.'];
    }
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus data: ' . $e->getMessage()];
}

header('Location: list.php');
exit;