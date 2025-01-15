<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../adminLogin.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "film_sitesi");

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = $conn->real_escape_string($_POST['username']);

    $sql = "DELETE FROM users WHERE username = '$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Kullanıcı başarıyla silindi.";
    } else {
        echo "Hata: " . $conn->error;
    }
}

$conn->close();
header("Location: ../adminDashUserList.php");
exit;
?>
