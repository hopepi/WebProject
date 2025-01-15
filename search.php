<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="CSS/base.css">
    <link rel="stylesheet" href="CSS/search.css"> <!-- Arama sayfası için özel CSS -->
</head>
<body>
    <header>
        <div class="logo">
            <h1>Umut Hub</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="#">Arama</a></li>
                <li><a href="PHP/logout.php">Çıkış yap</a></li>
            </ul>
        </nav>
    </header>

    <section id="search-container">
        <input type="text" id="search-input" placeholder="Yeni bir macera için arat">
    </section>

    <section id="search-results" class="search-results">
        <div class="search-result-card">
            <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
            <h3>Film Adı</h3>
            <p>Film açıklaması kısa bir şekilde buraya gelecek.</p>
            <button class="watch-btn">İzle</button>
            <button class="watch-btn">İzleme Listeme ekle</button> 
        </div>
    </section>
    

    <footer>
        <p>&copy; 2024 Umut Hub. Tüm Hakları Saklıdır.</p>
    </footer>
</body>
</html>