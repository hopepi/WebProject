<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
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
        <h2>Giriş Yap</h2>
        <form action="PHP\login.php" method="POST">
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
            <p>Hesabınız yok mu? <a href="register.php">Kayıt Ol</a></p>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Umut Hub. Tüm Hakları Saklıdır.</p>
    </footer>
</body>
</html>
