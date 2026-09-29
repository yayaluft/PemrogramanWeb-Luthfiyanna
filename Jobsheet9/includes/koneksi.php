<?php

$host = "aws-0-ap-southeast-1.pooler.supabase.com";
$port = "6543";
$db   = "postgres";
$user = "postgres.rjbcawduieilmqrwwbnb";

$pass = "Rentcam2026";

$dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}