<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "film_sitesi");

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

$movie_id = $_POST['movie_id'];

$delete_sql = "DELETE FROM daily_movie";
$conn->query($delete_sql);

$insert_sql = "INSERT INTO daily_movie (movie_id) VALUES (?)";
$stmt = $conn->prepare($insert_sql);
$stmt->bind_param("i", $movie_id);

if ($stmt->execute()) {
    echo "Günün filmi başarıyla güncellendi!";
    header("Location: ../adminDashMovieList.php"); // Admin paneline geri yönlendirme
} else {
    echo "Hata oluştu: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
