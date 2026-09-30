<?php
session_start();
require_once '../includes/koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['user']     = $user; 
                $_SESSION['nama']     = $user['nama'];
                $_SESSION['role']     = $user['role'];

                header("Location: ../index.php");
                exit;
            }
        } catch (PDOException $e) {
            $_SESSION['flash'] = [
                'tipe'  => 'gagal',
                'pesan' => 'Terjadi kesalahan pada sistem.'
            ];
            header("Location: login.php");
            exit;
        }
    }

    $_SESSION['flash'] = [
        'tipe'  => 'gagal',
        'pesan' => 'Username atau password salah!'
    ];
    header("Location: login.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}