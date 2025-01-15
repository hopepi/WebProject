<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$conn = new mysqli("localhost", "root", "", "film_sitesi");

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie_id = intval($_POST['movie_id']);
    $user_id_query = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $conn->prepare($user_id_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_id = $result->fetch_assoc()['user_id'];

    $insert_query = "INSERT INTO tracing (user_id, movie_id) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ii", $user_id, $movie_id);

    if ($stmt->execute()) {
        header("Location: ../index.php?status=success");
    } else {
        header("Location: ../index.php?status=error");
    }
}
?>
