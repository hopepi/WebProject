<?php
// Veritabanı bağlantısı
$conn = new mysqli("localhost", "root", "", "film_sitesi");

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Kullanıcı adı veya e-posta kontrolü
    $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "Kullanıcı adı veya e-posta zaten alınmış!";
    } else {
        // Kullanıcıyı ekle
        $insert_query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'user')";
        if ($conn->query($insert_query)) {
            echo "Kayıt başarılı! Giriş yapabilirsiniz.";
            header("Location: ../login.php");
            exit;
        } else {
            echo "Hata: " . $conn->error;
        }
    }
}
?>
