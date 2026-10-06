<?php
require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id         = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$id_penyewa = trim($_POST['id_penyewa'] ?? '');
$nama       = trim($_POST['nama'] ?? '');
$telepon    = trim($_POST['telepon'] ?? '');
$status     = trim($_POST['status'] ?? 'Aktif Menyewa');

$errors = [];
if (!$id) $errors[] = "ID data tidak valid.";
if ($id_penyewa === '') $errors[] = "ID Penyewa wajib diisi.";
if ($nama === '') $errors[] = "Nama penyewa wajib diisi.";
if (!preg_match('/^[0-9]{10,14}$/', $telepon)) $errors[] = "Nomor HP harus berupa angka (10-14 digit).";

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . (int)$id);
    exit;
}

try {
    $stmt = $pdo->prepare(
        "UPDATE penyewa
         SET id_penyewa = :id_penyewa, nama = :nama, telepon = :telepon, status = :status
         WHERE id = :id"
    );

    $stmt->execute([
        'id'         => $id,
        'id_penyewa' => $id_penyewa,
        'nama'       => $nama,
        'telepon'    => $telepon,
        'status'     => $status
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => "Data penyewa '{$nama}' berhasil diubah."];
    header('Location: list.php');
    exit;
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mengubah data: ' . $e->getMessage()];
    header('Location: edit.php?id=' . (int)$id);
    exit;
}