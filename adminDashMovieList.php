<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: adminLogin.html");
    exit;
}

$username = $_SESSION['username'];

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit;
}
$conn = new mysqli("localhost", "root", "", "film_sitesi");

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Filmleri çekme sorgusu
$sql = "SELECT * FROM film";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="CSS/base.css">
    <link rel="stylesheet" href="CSS/adminDash.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="adminDashboard.php">Film Ekle</a>
        <a href="adminDashMovieList.php">Film Listesi</a>
        <a href="#">Kullanıcı Listesi</a>
        <a href="#">Roller</a>
        <a href="PHP\logout.php">Çıkış</a>
    </div>

    <div class="main">
        <div class="card">
            <h3>Film Listesi</h3>
            <table>
                <thead>
                    <tr>
                        <th>Film Adı</th>
                        <th>Açıklama</th>
                        <th>Film Yolu</th>
                        <th>Poster Yolu</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                            <form action="PHP/updateMovie.php" method="POST">
                                <td>
                                    <input type="text" name="movie_name" value="<?php echo htmlspecialchars($row['movie_name']); ?>" required>
                                </td>
                                <td>
                                    <textarea name="comment" required><?php echo htmlspecialchars($row['comment']); ?></textarea>
                                </td>
                                <td>
                                    <input type="text" name="movie_dir" value="<?php echo htmlspecialchars($row['movie_dir']); ?>" required>
                                </td>
                                <td>
                                    <input type="text" name="poster" value="<?php echo htmlspecialchars($row['poster']); ?>" required>
                                </td>
                                <td>
                                    <input type="hidden" name="movie_id" value="<?php echo $row['movie_id']; ?>">
                                    <button type="submit" class="btn">Güncelle</button>
                                </td>
                            </form>
                            <form action="PHP/deleteMovie.php" method="POST" onsubmit="return confirm('Bu filmi silmek istediğinize emin misiniz?');">
                                <td>
                                    <input type="hidden" name="movie_id" value="<?php echo $row['movie_id']; ?>">
                                    <button type="submit" class="btn">Sil</button>
                                </td>
                            </form>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Hiç film bulunamadı.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>