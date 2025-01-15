<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: adminLogin.php");
    exit;
}

$username = $_SESSION['username'];

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "film_sitesi");

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

$sql = "SELECT username, email, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kullanıcı Listesi</title>
    <link rel="stylesheet" href="CSS/base.css">
    <link rel="stylesheet" href="CSS/adminDash.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="adminDashboard.php">Film Ekle</a>
        <a href="adminDashMovieList.php">Film Listesi</a>
        <a href="adminDashUserList.php">Kullanıcı Listesi</a>
        <a href="PHP/logout.php">Çıkış</a>
    </div>

    <div class="main">
        <div class="card">
            <h3>Kullanıcı Listesi</h3>
            <table>
                <thead>
                    <tr>
                        <th>Kullanıcı Adı</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Güncelleme</th>
                        <th>Silme</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <form action="PHP/updateUserRole.php" method="POST">
                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td>
                                        <select name="role" required>
                                            <option value="user" <?php if ($row['role'] === 'user') echo 'selected'; ?>>User</option>
                                            <option value="admin" <?php if ($row['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                                        <button type="submit" class="btn">Güncelle</button>
                                    </td>
                                </form>
                                <td>
                                    <form action="PHP/deleteUser.php" method="POST" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                                        <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                                        <button type="submit" class="btn">Sil</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Hiç kullanıcı bulunamadı.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
