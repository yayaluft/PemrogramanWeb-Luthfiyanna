<?php
session_start();

// Mencegah akses langsung via URL GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: list.php");
    exit;
}

$kode     = trim($_POST['kode'] ?? '');
$nama     = trim($_POST['nama'] ?? '');
$kategori = trim($_POST['kategori'] ?? 'Kamera');
$tarif    = trim($_POST['tarif'] ?? '');
$status   = trim($_POST['status'] ?? 'Tersedia');

// Validasi Server-Side (berjalan mandiri walau JS dimatikan)
$errors = [];

if (empty($kode)) {
    $errors[] = "Kode alat wajib diisi.";
}
if (empty($nama)) {
    $errors[] = "Nama perangkat wajib diisi.";
}
if (!is_numeric($tarif) || (int)$tarif <= 0) {
    $errors[] = "Tarif sewa harus berupa angka lebih dari 0.";
}

// Jika ada field yang tidak valid
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'tipe'  => 'gagal',
        'pesan' => implode(' ', $errors)
    ];
    header("Location: tambah.php");
    exit;
}

// Inisialisasi session jika belum ada
if (!isset($_SESSION['alat'])) {
    $_SESSION['alat'] = [];
}

// Tambahkan ke array session
$_SESSION['alat'][] = [
    'kode'     => $kode,
    'nama'     => $nama,
    'kategori' => $kategori,
    'tarif'    => (int)$tarif,
    'status'   => $status
];

// Set flash message sukses
$_SESSION['flash'] = [
    'tipe'  => 'sukses',
    'pesan' => "Data unit '{$nama}' berhasil ditambahkan ke daftar!"
];

header("Location: list.php");
exit;