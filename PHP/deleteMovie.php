<?php
session_start();

// Eğer admin giriş yapmamışsa giriş sayfasına yönlendir
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: adminLogin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // movie_id'yi al
    $movie_id = $_POST['movie_id'];

    // Veritabanı bağlantısı
    $conn = new mysqli('localhost', 'root', '', 'film_sitesi');

    // Bağlantıyı kontrol et
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    // Film verisini silme işlemi
    $sql = "DELETE FROM film WHERE movie_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);  // "i" int parametreyi belirtir

    if ($stmt->execute()) {
        echo "Film başarıyla silindi!";
        header("Location: ../adminDashMovieList.php");  // Silme işlemi sonrası film listesine yönlendir
        exit;
    } else {
        echo "Hata: " . $stmt->error;
    }

    // Bağlantıyı kapat
    $stmt->close();
    $conn->close();
}
?>