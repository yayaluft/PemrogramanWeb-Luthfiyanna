<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$email    = strtolower(trim($_POST['username'] ?? ''));
$password = trim($_POST['password'] ?? '');

$allowed_email    = 'syanuha66@gmail.com';
$allowed_password = 'admin123';

if (empty($email) || empty($password)) {
    $_SESSION['flash'] = [
        'tipe'  => 'gagal',
        'pesan' => 'Email dan password wajib diisi.'
    ];
    header("Location: login.php");
    exit;
}

if ($email !== $allowed_email) {
    $_SESSION['flash'] = [
        'tipe'  => 'gagal',
        'pesan' => 'Akses ditolak: Hanya email terdaftar yang dapat masuk.'
    ];
    header("Location: login.php");
    exit;
}

if ($password === $allowed_password) {
    session_regenerate_id(true);

    $_SESSION['user'] = [
        'username'     => $email,
        'nama_lengkap' => 'Luthfiyanna'
    ];

    $_SESSION['flash'] = [
        'tipe'  => 'sukses',
        'pesan' => 'Selamat datang kembali, Luthfiyanna!'
    ];
    header("Location: index.php");
    exit;
} else {
    $_SESSION['flash'] = [
        'tipe'  => 'gagal',
        'pesan' => 'Password salah.'
    ];
    header("Location: login.php");
    exit;
}