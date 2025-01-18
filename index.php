<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "film_sitesi");

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}


$sql = "SELECT movie_id, movie_name, poster FROM film";
$result = $conn->query($sql);
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
            <?php
            $tracking_sql = "
                SELECT film.movie_id, film.movie_name, film.poster 
                FROM tracking
                INNER JOIN film ON tracking.movie_id = film.movie_id
                WHERE tracking.user_id = ?
            ";
            $stmt = $conn->prepare($tracking_sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $tracking_result = $stmt->get_result();

            if ($tracking_result->num_rows > 0):
                while ($row = $tracking_result->fetch_assoc()):
            ?>
                <div class="tracking-movies-card">
                    <img src="<?php echo htmlspecialchars($row['poster']); ?>" alt="Film Afişi">
                    <h3><?php echo htmlspecialchars($row['movie_name']); ?></h3>
                    <form action="PHP/updateWatchList.php" method="POST" style="display: inline-block;">
                        <input type="hidden" name="movie_id" value="<?php echo $row['movie_id']; ?>">
                        <button type="submit" name="action" value="remove" class="card-btn">Listeden Çıkar</button>
                    </form>
                    <form action="watch.php" method="GET" style="display: inline-block;">
                        <input type="hidden" name="movie_id" value="<?php echo $row['movie_id']; ?>">
                        <button type="submit" class="card-btn">İzle</button>
                    </form>
                </div>
            <?php
                endwhile;
            else:
            ?>
                <p>Henüz izleme listenizde bir yapım bulunmamaktadır.</p>
            <?php endif; ?>
        </div>
    </section>

    
    <section id="popular-movies">
        <h2>Popüler Yapımlar</h2>
        <div class="movie-list">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                $movie_id = $row['movie_id'];
                // İzleme listesinde olup olmadığını kontrol et
                $check_sql = "SELECT * FROM tracking WHERE user_id = ? AND movie_id = ?";
                $stmt = $conn->prepare($check_sql);
                $stmt->bind_param("ii", $user_id, $movie_id);
                $stmt->execute();
                $check_result = $stmt->get_result();
                $is_in_watchlist = $check_result->num_rows > 0;
                ?>
                <div class="movie-card">
                    <img src="<?php echo htmlspecialchars($row['poster']); ?>" alt="Film Afişi">
                    <h3><?php echo htmlspecialchars($row['movie_name']); ?></h3>
                    <form action="PHP/updateWatchList.php" method="POST" style="display: block;">
                        <input type="hidden" name="movie_id" value="<?php echo $row['movie_id']; ?>">
                        <button type="submit" name="action" value="<?php echo $is_in_watchlist ? 'remove' : 'add'; ?>" class="card-btn">
                            <?php echo $is_in_watchlist ? 'Listeden Çıkar' : 'İzleme Listesine Ekle'; ?>
                        </button>
                    </form>
                    <form action="" method="GET" style="display: block; margin-top: 10px;">
                        <input type="hidden" name="movie_id" value="<?php echo $row['movie_id']; ?>">
                        <button type="submit" class="card-btn">İzle</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Henüz bir yapım bulunmamaktadır.</p>
        <?php endif; ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Umut Hub. Tüm Hakları Saklıdır.</p>
    </footer>
    <script src="JavaScript/video.js"></script>
    <script src="JavaScript/ajax.js"></script>
</body>
</html>