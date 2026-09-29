<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id_penyewa = trim($_POST['id_penyewa'] ?? '');
$nama       = trim($_POST['nama'] ?? '');
$telepon    = trim($_POST['telepon'] ?? '');
$status     = trim($_POST['status'] ?? 'Aktif Menyewa');

$errors = [];
if (empty($id_penyewa)) {
    $errors[] = "ID Penyewa wajib diisi.";
}
if (empty($nama)) {
    $errors[] = "Nama penyewa wajib diisi.";
}
if (empty($telepon) || !preg_match('/^[0-9]{10,14}$/', $telepon)) {
    $errors[] = "Nomor HP harus berupa angka (10-14 digit).";
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => implode(' ', $errors)
    ];
    header("Location: tambah.php");
    exit;
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO penyewa (id_penyewa, nama, telepon, status)
         VALUES (:id_penyewa, :nama, :telepon, :status)
         RETURNING id"
    );

    $stmt->execute([
        'id_penyewa' => $id_penyewa,
        'nama'       => $nama,
        'telepon'    => $telepon,
        'status'     => $status,
    ]);

    $_SESSION['flash'] = [
        'type'  => 'success',
        'pesan' => "Data penyewa '{$nama}' berhasil ditambahkan!"
    ];

} catch (PDOException $e) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => "Gagal menyimpan data: " . $e->getMessage()
    ];
    header("Location: tambah.php");
    exit;
}

header("Location: list.php");
exit;