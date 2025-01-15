<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "film_sitesi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movie_name = mysqli_real_escape_string($conn, $_POST['movie_name']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $movie_dir = $_FILES['movie_dir'];
    $poster_path = $_FILES['poster_path'];

    // Film dosyasını yükle
    $movie_dir_name = time() . "_" . basename($movie_dir["name"]);
    $movie_dir_path = "../uploads/movies/" . $movie_dir_name;
    
    if (move_uploaded_file($movie_dir["tmp_name"], $movie_dir_path)) {
        echo "Film dosyası başarıyla yüklendi.";
    } else {
        echo "Film dosyası yüklenirken bir hata oluştu.";
    }
    $movie_dir_path = "uploads/movies/" . $movie_dir_name;

    // Poster dosyasını yükle
    $poster_name = time() . "_" . basename($poster_path["name"]);
    $poster_path_name = "../uploads/posters/" . $poster_name;
    
    if (move_uploaded_file($poster_path["tmp_name"], $poster_path_name)) {
        echo "Poster dosyası başarıyla yüklendi.";
    } else {
        echo "Poster dosyası yüklenirken bir hata oluştu.";
    }

    $poster_path_name = "uploads/posters/" . $poster_name;

    $base_url = "http://localhost/WEBPROJE/";

    $movie_dir_full_path = $base_url . $movie_dir_path;  // Tam URL
    $poster_path_full_name = $base_url . $poster_path_name;  // Tam URL

    $current_date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO film (movie_name, comment, movie_dir, poster, date) 
            VALUES ('$movie_name', '$comment', '$movie_dir_full_path', '$poster_path_full_name', '$current_date')";

    if ($conn->query($sql) === TRUE) {
        echo "Yeni film başarıyla eklendi!";

        header("refresh:2;url=../adminDashboard.php"); 
        exit();
    } else {
        echo "Hata: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>