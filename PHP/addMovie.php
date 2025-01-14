<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Formdan gelen veriler
    $movieName = $_POST['movie_name'];
    $comment = $_POST['comment'];

    // Dosyaların yüklenmesi
    if (isset($_FILES['movie_dir']) && isset($_FILES['poster_path'])) {
        $movieDir = "C:/wamp64/www/WebProje/uploads/" . basename($_FILES['movie_dir']['name']);  // Film dosyasının yolu
        $posterPath = "C:/wamp64/www/WebProje/uploads/" . basename($_FILES['poster_path']['name']);  // Poster dosyasının yolu

        // Dosya yükleme hatalarını kontrol etme
        if ($_FILES['movie_dir']['error'] !== UPLOAD_ERR_OK) {
            echo "Film dosyası yüklenirken bir hata oluştu: " . $_FILES['movie_dir']['error'];
        } elseif ($_FILES['poster_path']['error'] !== UPLOAD_ERR_OK) {
            echo "Poster dosyası yüklenirken bir hata oluştu: " . $_FILES['poster_path']['error'];
        } else {
            if (move_uploaded_file($_FILES['movie_dir']['tmp_name'], $movieDir) && move_uploaded_file($_FILES['poster_path']['tmp_name'], $posterPath)) {
                // Veritabanına bağlan
                $conn = new mysqli('localhost', 'root', '', 'film_sitesi');

                // Bağlantıyı kontrol et
                if ($conn->connect_error) {
                    die("Bağlantı hatası: " . $conn->connect_error);
                }

                // SQL sorgusu
                $stmt = $conn->prepare("
                    INSERT INTO film (movie_name, comment, movie_dir, date, poster)
                    VALUES (?, ?, ?, NOW(), ?)
                ");
                $stmt->bind_param("ssss", $movieName, $comment, $movieDir, $posterPath); // 'poster_path' yerine 'poster'

                if ($stmt->execute()) {
                    echo "Film başarıyla eklendi!<br>";
                    header("Location: ../adminDashboard.php");
                    exit;
                } else {
                    echo "Hata: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();
            } else {
                echo "Dosya yükleme hatası.";
            }
        }
    } else {
        echo "Lütfen film dosyasını ve posterini yükleyin.";
    }
}
?>
