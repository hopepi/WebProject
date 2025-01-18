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
        $updatePopularity = "UPDATE film SET popularity = popularity + 1 WHERE movie_id = ?";
    } else if ($action === 'remove') {
        $sql = "DELETE FROM tracking WHERE user_id = ? AND movie_id = ?";
        $updatePopularity = "UPDATE film SET popularity = popularity - 1 WHERE movie_id = ?";
    }

    // Tracking tablosuna ekleme veya silme işlemi
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $movie_id);
    
    if ($stmt->execute()) {
        // Popülerlik güncellemesi
        $popularityStmt = $conn->prepare($updatePopularity);
        $popularityStmt->bind_param("i", $movie_id);
        
        // Popülerlik güncelleme işlemine ait kontrol ekleyelim
        if ($popularityStmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Popülerlik güncellemesi başarısız: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Veritabanı işlemi başarısız: ' . $conn->error]);
    }
}

$conn->close();
?>