<?php
session_start();

// Mencegah akses langsung melalui URL GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: list.php");
    exit;
}

$id_penyewa = trim($_POST['id_penyewa'] ?? '');
$nama       = trim($_POST['nama'] ?? '');
$telepon    = trim($_POST['telepon'] ?? '');
$status     = trim($_POST['status'] ?? 'Aktif Menyewa');

// Validasi Server-Side
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

// Redirect kembali jika validasi gagal
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'tipe'  => 'gagal',
        'pesan' => implode(' ', $errors)
    ];
    header("Location: tambah.php");
    exit;
}

// Inisialisasi session jika belum ada
if (!isset($_SESSION['penyewa'])) {
    $_SESSION['penyewa'] = [];
}

// Simpan data penyewa baru
$_SESSION['penyewa'][] = [
    'id'      => $id_penyewa,
    'nama'    => $nama,
    'telepon' => $telepon,
    'status'  => $status
];

$_SESSION['flash'] = [
    'tipe'  => 'sukses',
    'pesan' => "Data penyewa '{$nama}' berhasil ditambahkan ke daftar!"
];

header("Location: list.php");
exit;