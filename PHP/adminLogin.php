<?php
session_start();

if (isset($_SESSION['username']) && $_SESSION['role'] === 'admin') {
    header("Location: ../admin_dashboard.php");
    exit;
}

// Veritabanı bağlantısı
$conn = new mysqli("localhost", "root", "", "film_sitesi");

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Kullanıcıyı username'e göre sorgula
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Şifre ve rol kontrolü
        if ($password === $user['password'] && $user['role'] === 'admin') {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];
            header("Location: ../adminDashboard.php");
            exit;
        } elseif ($user['role'] !== 'admin') {
            echo "Yalnızca admin kullanıcılar giriş yapabilir!";
        } else {
            echo "Hatalı şifre!";
        }
    } else {
        echo "Kullanıcı bulunamadı!";
    }
}
?>