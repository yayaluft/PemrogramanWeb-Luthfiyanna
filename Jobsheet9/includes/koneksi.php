<?php
$db_url = getenv('DATABASE_URL');

if ($db_url) {
    $dbopts = parse_url($db_url);

    $host = $dbopts["host"];
    $port = isset($dbopts["port"]) ? $dbopts["port"] : "5432";
    $user = $dbopts["user"];
    $pass = $dbopts["pass"];
    $db = ltrim($dbopts["path"], '/');

    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
} else {
    $host = "localhost";
    $port = "5433";
    $db = "rentcam_db";
    $user = "postgres";
    $pass = "12345678";

    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
}

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}