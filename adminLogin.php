<?php
session_start();

// Kullanıcı giriş yapmışsa doğrudan adminDashboard'a yönlendir
if (isset($_SESSION['username']) && $_SESSION['role'] === 'admin') {
    header("Location: adminDashboard.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Umut Hub</title>
    <link rel="stylesheet" href="CSS/base.css">
    <link rel="stylesheet" href="CSS/login_register.css">
</head>
<body>
    <div class="logo">
        <h1>Umut Hub</h1>
    </div>
    <div class="login-container">
        <h2>Yönetim Giriş Sayfası</h2>
        <form action="PHP\adminLogin.php" method="POST">
            <div class="input-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" required placeholder="Kullanıcı adınızı girin">
            </div>
            <div class="input-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" required placeholder="Şifrenizi girin">
            </div>
            <div class="input-group">
                <button type="submit">Giriş Yap</button>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Umut Hub. Tüm Hakları Saklıdır.</p>
    </footer>
</body>
</html>
