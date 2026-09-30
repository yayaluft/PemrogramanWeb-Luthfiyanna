<?php
require_once __DIR__ . '/../includes/koneksi.php';
require __DIR__ . '/../includes/koneksi.php';

$kode     = trim($_POST['kode'] ?? '');
$nama     = trim($_POST['nama'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$tarif    = $_POST['tarif'] ?? '';
$status   = trim($_POST['status'] ?? 'Tersedia');

$errors = [];
if ($kode === '') {
    $errors[] = "Kode alat wajib diisi.";
}
if ($nama === '') {
    $errors[] = "Nama alat wajib diisi.";
}
if ($kategori === '') {
    $errors[] = "Kategori wajib diisi.";
}
if (!is_numeric($tarif) || $tarif < 0) {
    $errors[] = "Tarif sewa harus berupa angka dan tidak boleh negatif.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO alat (kode, nama, kategori, tarif, status)
         VALUES (:kode, :nama, :kategori, :tarif, :status)
         RETURNING id"
    );
    $stmt->execute([
        'kode'     => $kode,
        'nama'     => $nama,
        'kategori' => $kategori,
        'tarif'    => (float) $tarif,
        'status'   => $status,
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => "Alat '{$nama}' berhasil ditambahkan."];
    header('Location: list.php');
    exit;

} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menyimpan data: ' . $e->getMessage()];
    header('Location: tambah.php');
    exit;
}