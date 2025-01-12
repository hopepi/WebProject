<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Umut Hub</title>
    <link rel="stylesheet" href="CSS/base.css">
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body>

    <header>
        <div class="logo">
            <h1>Umut Hub</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#">Ana Sayfa</a></li>
                <li><a href="search.php">Arama</a></li>
                <li><a href="PHP/logout.php">Çıkış yap</a></li>
            </ul>
        </nav>
    </header>

    <section id="hero">
        <div class="card">
            <div class="front">
                <span class="badge">Günün Önerisi</span>
                <h2>Interstellar (2014)</h2>
                <img src="resim.jpg" alt="Film Afişi">
                <p>Bilim kurgu dünyasına heyecan verici bir yolculuk.</p>
            </div>
            <div class="back">
                <video muted loop>
                    <source src="video.mp4" type="video/mp4">
                </video>
                <div class="back-content">
                    <h2>Interstellar</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga placeat quam ipsa eius aliquam nesciunt voluptas veniam et esse,
                        enim alias, libero accusantium, repudiandae officiis delectus quod quaerat ad beatae impedit eum sint quas quo. Eveniet, 
                        saepe quia iusto ipsa exercitationem dignissimos impedit similique nulla harum error. Non, optio aut.
                    </p>
                    <button>Fragmanı İzle</button>
                    <button>İzle</button>
                </div>
            </div>
        </div>
    </section>

    <section id="tracking-movies">
        <h2>Takip Edilen Yapımlar</h2>
        <div class="tracking-movies-list">
            <div class="tracking-movies-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 1</h3>
                <button class="card-btn">İzle</button>
            </div>
            <div class="tracking-movies-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 2</h3>
                <button class="card-btn">İzle</button>
            </div>
            <div class="tracking-movies-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 3</h3>
                <button class="card-btn">İzle</button>
            </div>
            <div class="tracking-movies-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 1</h3>
                <button class="card-btn">İzle</button>
            </div>
            <div class="tracking-movies-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 2</h3>
                <button class="card-btn">İzle</button>
            </div>
            <div class="tracking-movies-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 3</h3>
                <button class="card-btn">İzle</button>
            </div>
            <div class="tracking-movies-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 1</h3>
                <button class="card-btn">İzle</button>
            </div>
            <div class="tracking-movies-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 2</h3>
                <button class="card-btn">İzle</button>
            </div>
            <div class="tracking-movies-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 3</h3>
                <button class="card-btn">İzle</button>
            </div>
            <div class="tracking-movies-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 3</h3>
                <button class="card-btn">İzle</button>
            </div>
        </div>
    </section>
    

    <section id="popular-movies">
        <h2>Popüler Yapımlar</h2>
        <div class="movie-list">
            <div class="movie-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 1</h3>
            </div>
            <div class="movie-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 2</h3>
            </div>
            <div class="movie-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 3</h3>
            </div>
            <div class="movie-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 1</h3>
            </div>
            <div class="movie-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 2</h3>
            </div>
            <div class="movie-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 3</h3>
            </div>
            <div class="movie-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 1</h3>
            </div>
            <div class="movie-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 2</h3>
            </div>
            <div class="movie-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 3</h3>
            </div>
            <div class="movie-card">
                <img src="https://via.placeholder.com/200x300" alt="Film Afişi">
                <h3>Film Adı 3</h3>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Umut Hub. Tüm Hakları Saklıdır.</p>
    </footer>
    <script src="JavaScript/video.js"></script>
</body>
</html>