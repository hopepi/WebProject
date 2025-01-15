<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: adminLogin.php");
    exit;
}

$username = $_SESSION['username'];

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
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
        <a href="#">Film Ekle</a>
        <a href="adminDashMovieList.php">Film Listesi</a>
        <a href="adminDashUserList.php">Kullanıcı Listesi</a>
        <a href="PHP\logout.php">Çıkış</a>
    </div>

    <div class="main">
    <h1>Hoş Geldiniz, <?php echo htmlspecialchars($username); ?>!</h1>

        <div class="card">
            <h3>Film Ekle</h3>
            <form action="PHP/addMovie.php" method="POST" enctype="multipart/form-data">
                <label for="movie_name">Film Adı:</label><br>
                <input type="text" id="movie_name" name="movie_name" required><br>

                <label for="comment">Film Açıklaması:</label><br>
                <textarea id="comment" name="comment" required></textarea><br>

                <label for="movie_dir">Film Dosyası:</label><br>
                <input type="file" id="movie_dir" name="movie_dir" accept=".mp4,.avi,.mkv" required><br>

                <label for="poster_path">Film Posteri:</label><br>
                <input type="file" id="poster_path" name="poster_path" accept=".jpg,.jpeg,.png,.gif" required><br>

                <button type="submit">Ekle</button>
            </form>
        </div>
    </div>
</body>
</html>