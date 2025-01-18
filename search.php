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

$search_results = [];
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search'])) {
    $search_query = "%" . $conn->real_escape_string($_POST['search']) . "%";
    $sql = "SELECT movie_id, movie_name, comment, poster FROM film WHERE movie_name LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search_query);
    $stmt->execute();
    $search_results = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arama</title>
    <link rel="stylesheet" href="CSS/base.css">
    <link rel="stylesheet" href="CSS/search.css">
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
        <form method="POST" action="">
            <input type="text" name="search" id="search-input" placeholder="Yeni bir macera için arat">
            <button type="submit" class="search-btn">Ara</button>
        </form>
    </section>

    <section id="search-results" class="search-results">
        <?php if (!empty($search_results) && $search_results->num_rows > 0): ?>
            <?php while ($row = $search_results->fetch_assoc()): ?>
                <?php
                // İzleme listesinde olup olmadığını kontrol et
                $check_sql = "SELECT * FROM tracking WHERE user_id = ? AND movie_id = ?";
                $stmt_check = $conn->prepare($check_sql);
                $stmt_check->bind_param("ii", $user_id, $row['movie_id']);
                $stmt_check->execute();
                $check_result = $stmt_check->get_result();
                $is_in_watchlist = $check_result->num_rows > 0;
                ?>
                <div class="search-result-card">
                    <img src="<?php echo htmlspecialchars($row['poster']); ?>" alt="Film Afişi">
                    <h3><?php echo htmlspecialchars($row['movie_name']); ?></h3>
                    <p><?php echo htmlspecialchars($row['comment']); ?></p>
                    <form action="watch.php" method="GET">
                        <input type="hidden" name="movie_id" value="<?php echo $row['movie_id']; ?>">
                        <button type="submit" class="watch-btn">İzle</button>
                    </form>
                    <form class="update-watchlist-form" method="POST" style="display: block;">
                        <input type="hidden" name="movie_id" value="<?php echo $row['movie_id']; ?>">
                        <button type="button" class="watch-btn" data-movie-id="<?php echo $row['movie_id']; ?>">
                            <?php echo $is_in_watchlist ? 'Listeden Çıkar' : 'İzleme Listesine Ekle'; ?>
                        </button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
                <p style="color: white; text-align: center;">Sonuç bulunamadı. Başka bir arama yapmayı deneyin.</p>
            <?php endif; ?>
        <?php endif; ?>
    </section>

    <footer>
        <p>&copy; 2024 Umut Hub. Tüm Hakları Saklıdır.</p>
    </footer>
    <script src="JavaScript/searchajax.js"></script>
</body>
</html>