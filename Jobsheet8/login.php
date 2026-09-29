<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RentCam | Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f5f6f8;">

    <div style="width: 100%; max-width: 400px; background: #fff; padding: 2.2rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <h2 style="text-align: center; color: #4a1e2f; margin-bottom: 0.3rem;">RentCam</h2>
        <p style="text-align: center; font-size: 0.9rem; color: #666; margin-bottom: 1.5rem;">Silakan masuk ke akun Anda</p>

        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="flash flash-<?php echo htmlspecialchars($_SESSION['flash']['tipe']); ?>">
                <?php echo htmlspecialchars($_SESSION['flash']['pesan']); ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <form action="proses_login.php" method="POST">
            <p>
                <label for="username">Email</label>
                <input type="email" id="username" name="username" placeholder="Masukkan email terdaftar" autocomplete="off" required
                    style="width: 100%; padding: 0.55rem 0.7rem; border: 1px solid #cdd4da; border-radius: 4px; font-size: 1rem;">
            </p>

            <p>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required
                    style="width: 100%; padding: 0.55rem 0.7rem; border: 1px solid #cdd4da; border-radius: 4px; font-size: 1rem;">
            </p>

            <div class="form-actions" style="margin-top: 1.5rem;">
                <button type="submit" style="width: 100%;">Masuk</button>
            </div>
        </form>
    </div>

</body>
</html>