<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieId = $_POST['movie_id'];
    $movieName = $_POST['movie_name'];
    $comment = $_POST['comment'];
    $movieDir = $_POST['movie_dir'];
    $poster = $_POST['poster'];

    $conn = new mysqli("localhost", "root", "", "film_sitesi");

    if ($conn->connect_error) {
        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("
        UPDATE film 
        SET movie_name = ?, comment = ?, movie_dir = ?, poster = ?
        WHERE movie_id = ?
    ");
    $stmt->bind_param("ssssi", $movieName, $comment, $movieDir, $poster, $movieId);

    if ($stmt->execute()) {
        echo "Film başarıyla güncellendi.";
        header("Location: ../adminDashMovieList.php");
        exit;
    } else {
        echo "Hata: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
