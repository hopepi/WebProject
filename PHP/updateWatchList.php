<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Kullanıcı girişi yapılmamış.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$movie_id = $_POST['movie_id'];
$action = $_POST['action'];

$conn = new mysqli("localhost", "root", "", "film_sitesi");
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// İzleme listesine ekleme ya da çıkarma işlemi
if ($action === 'add') {
    $sql = "INSERT INTO tracking (user_id, movie_id) VALUES (?, ?)";
} else if ($action === 'remove') {
    $sql = "DELETE FROM tracking WHERE user_id = ? AND movie_id = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $movie_id);
$result = $stmt->execute();

if ($result) {
    echo json_encode(['success' => true, 'message' => 'İşlem başarılı']);
} else {
    echo json_encode(['success' => false, 'message' => 'İşlem başarısız']);
}
?>
