<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: ../main.php"); // Giriş yapmışsa ana sayfaya yönlendirilir
    exit;
}

// Veritabanı bağlantısı
$conn = new mysqli("localhost", "root", "", "film_sitesi");

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            $_SESSION['username'] = $username;
            header("Location: ../main.php");
            exit;
        } else {
            echo "Hatalı şifre!";
        }
    } else {
        echo "Kullanıcı bulunamadı!";
    }
}
?>