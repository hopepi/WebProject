<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['username'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Kullanıcı girişi yapılmamış. Lütfen giriş yapın.'
    ]);
    exit;
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "film_sitesi");

if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Veritabanı bağlantısı başarısız: ' . $conn->connect_error
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie_id = $_POST['movie_id'];
    $action = $_POST['action'];  // 'add' veya 'remove'

    if ($action === 'add') {
        $sql = "INSERT INTO tracking (user_id, movie_id) VALUES (?, ?)";
    } else if ($action === 'remove') {
        $sql = "DELETE FROM tracking WHERE user_id = ? AND movie_id = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $movie_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Veritabanı işlemi başarısız.']);
    }
}

$conn->close();
?>
