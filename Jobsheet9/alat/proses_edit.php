<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id       = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$kode     = trim($_POST['kode'] ?? '');
$nama     = trim($_POST['nama'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$tarif    = $_POST['tarif'] ?? '';
$status   = trim($_POST['status'] ?? 'Tersedia');

$errors = [];
if (!$id) $errors[] = "ID alat tidak valid.";
if ($kode === '') $errors[] = "Kode alat wajib diisi.";
if ($nama === '') $errors[] = "Nama alat wajib diisi.";
if ($kategori === '') $errors[] = "Kategori wajib diisi.";
if (!is_numeric($tarif) || $tarif < 0) $errors[] = "Tarif sewa harus berupa angka dan tidak boleh negatif.";

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . (int)$id);
    exit;
}

try {
    $stmt = $pdo->prepare(
        "UPDATE alat
         SET kode = :kode, nama = :nama, kategori = :kategori, tarif = :tarif, status = :status
         WHERE id = :id"
    );

    $stmt->execute([
        'id'       => $id,
        'kode'     => $kode,
        'nama'     => $nama,
        'kategori' => $kategori,
        'tarif'    => (float)$tarif,
        'status'   => $status
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => "Data alat '{$nama}' berhasil diubah."];
    header('Location: list.php');
    exit;
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mengubah data: ' . $e->getMessage()];
    header('Location: edit.php?id=' . (int)$id);
    exit;
}