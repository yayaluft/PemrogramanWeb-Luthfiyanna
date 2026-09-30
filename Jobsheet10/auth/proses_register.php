<?php
session_start();
require_once __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = 'petugas';

    if (empty($nama) || empty($username) || empty($password)) {
        $_SESSION['flash'] = [
            'type'  => 'danger',
            'pesan' => 'Semua field wajib diisi!'
        ];
        header("Location: register.php");
        exit;
    }

    // Hash password menggunakan password_hash()
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (nama, username, password, role) VALUES (:nama, :username, :password, :role)");
        $stmt->execute([
            'nama'     => $nama,
            'username' => $username,
            'password' => $hashed_password,
            'role'     => $role
        ]);

        $_SESSION['flash'] = [
            'type'  => 'success',
            'pesan' => 'Registrasi berhasil! Silakan login.'
        ];
        header("Location: login.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['flash'] = [
            'type'  => 'danger',
            'pesan' => 'Username sudah digunakan, cari username lain!'
        ];
        header("Location: register.php");
        exit;
    }
} else {
    header("Location: register.php");
    exit;
}