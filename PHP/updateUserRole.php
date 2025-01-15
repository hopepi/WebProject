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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['role'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $role = $conn->real_escape_string($_POST['role']);

    // Kullanıcı rolünü güncelle
    $sql = "UPDATE users SET role = '$role' WHERE username = '$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Kullanıcı rolü başarıyla güncellendi.";
    } else {
        echo "Hata: " . $conn->error;
    }
}

$conn->close();
header("Location: ../adminDashUserList.php");
exit;
?>